{{-- ================================================= --}}
{{-- FINANCIAL ACTIVITY (LINE CHART) --}}
{{-- ================================================= --}}

@php
    // 1. Ambil data 10 tahun terakhir langsung dari model
    $now = now();
    $transactions = \App\Models\Transaction::where('created_at', '>=', $now->copy()->subYears(10))->get();

    // 2. Siapkan kerangka data kosong
    $chartData = [
        'monthly' => ['labels' => [], 'income' => [], 'expense' => []],
        'yearly' => ['labels' => [], 'income' => [], 'expense' => []],
        'five_years' => ['labels' => [], 'income' => [], 'expense' => []],
        'ten_years' => ['labels' => [], 'income' => [], 'expense' => []],
    ];

    // --- Setup Bulan Ini (Tanggal 1 s/d Akhir Bulan) ---
    for ($i = 1; $i <= $now->daysInMonth; $i++) {
        $chartData['monthly']['labels'][] = (string)$i;
        $chartData['monthly']['income'][$i] = 0;
        $chartData['monthly']['expense'][$i] = 0;
    }

    // --- Setup Tahun Ini (Januari - Desember) ---
    $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    foreach ($months as $k => $m) {
        $chartData['yearly']['labels'][] = $m;
        $chartData['yearly']['income'][$k+1] = 0;
        $chartData['yearly']['expense'][$k+1] = 0;
    }

    // --- Setup 5 Tahun Terakhir ---
    for ($i = 4; $i >= 0; $i--) {
        $year = $now->year - $i;
        $chartData['five_years']['labels'][] = (string)$year;
        $chartData['five_years']['income'][$year] = 0;
        $chartData['five_years']['expense'][$year] = 0;
    }

    // --- Setup 10 Tahun Terakhir ---
    for ($i = 9; $i >= 0; $i--) {
        $year = $now->year - $i;
        $chartData['ten_years']['labels'][] = (string)$year;
        $chartData['ten_years']['income'][$year] = 0;
        $chartData['ten_years']['expense'][$year] = 0;
    }

    // 3. Kelompokkan Data ke dalam Masing-Masing Kategori
    foreach ($transactions as $t) {
        
        // SESUAIKAN NAMA KOLOM JIKA BERBEDA DI DATABASEMU: 
        // Diasumsikan 'amount' untuk nominal, 'type' untuk tipe pemasukan/pengeluaran
        $amount = (float) $t->amount;
        $isIncome = in_array(strtolower($t->type), ['income', 'pemasukan', 'in']);

        $d = $t->created_at;

        // Masuk ke Bulan Ini
        if ($d->month === $now->month && $d->year === $now->year) {
            if ($isIncome) $chartData['monthly']['income'][$d->day] += $amount;
            else $chartData['monthly']['expense'][$d->day] += $amount;
        }

        // Masuk ke Tahun Ini
        if ($d->year === $now->year) {
            if ($isIncome) $chartData['yearly']['income'][$d->month] += $amount;
            else $chartData['yearly']['expense'][$d->month] += $amount;
        }

        // Masuk ke 5 Tahun Terakhir
        if ($d->year >= $now->year - 4) {
            if ($isIncome) $chartData['five_years']['income'][$d->year] += $amount;
            else $chartData['five_years']['expense'][$d->year] += $amount;
        }

        // Masuk ke 10 Tahun Terakhir
        if ($d->year >= $now->year - 9) {
            if ($isIncome) $chartData['ten_years']['income'][$d->year] += $amount;
            else $chartData['ten_years']['expense'][$d->year] += $amount;
        }
    }

    // 4. Bersihkan Array agar index-nya berurutan untuk JavaScript
    foreach (['monthly', 'yearly', 'five_years', 'ten_years'] as $period) {
        $chartData[$period]['income'] = array_values($chartData[$period]['income']);
        $chartData[$period]['expense'] = array_values($chartData[$period]['expense']);
    }
@endphp

{{-- Load Chart.js CDN (Hanya akan dipanggil satu kali) --}}
@once
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endonce

<div x-data="financialLineChart(@js($chartData))" class="haskon-card bg-white border border-zinc-200 overflow-hidden">
    
    {{-- Header & Dropdown Filter --}}
    <div class="border-b border-zinc-200 bg-white px-5 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-zinc-900 text-white flex items-center justify-center shadow-xs flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                </svg>
            </div>
            <div>
                <h3 class="text-base font-bold text-zinc-900 tracking-tight">Tren Keuangan</h3>
                <p class="text-xs text-zinc-500">Perbandingan arus kas masuk dan keluar</p>
            </div>
        </div>

        {{-- Dropdown Pengubah Sumbu X --}}
        <select 
            x-model="period" 
            @change="updateChart()" 
            class="rounded-lg border-zinc-300 text-sm font-medium text-zinc-700 focus:border-amber-400 focus:ring-amber-400 cursor-pointer shadow-sm"
        >
            <option value="monthly">Bulan Ini (Harian)</option>
            <option value="yearly">Tahun Ini (Bulanan)</option>
            <option value="five_years">5 Tahun Terakhir</option>
            <option value="ten_years">10 Tahun Terakhir</option>
        </select>
    </div>

    {{-- Area Canvas --}}
    <div class="p-5">
        <div class="relative w-full h-[320px]">
            <canvas id="financialChartCanvas"></canvas>
        </div>
    </div>
</div>

{{-- Logika Alpine & Chart.js --}}
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('financialLineChart', (chartData) => ({
            period: 'monthly',
            data: chartData,
            chartInstance: null,

            init() {
                const ctx = document.getElementById('financialChartCanvas').getContext('2d');
                this.chartInstance = new Chart(ctx, {
                    type: 'line',
                    data: this.getChartConfig(),
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    boxWidth: 8,
                                    padding: 20
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(24, 24, 27, 0.9)', 
                                padding: 12,
                                cornerRadius: 8,
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) { label += ': '; }
                                        if (context.parsed.y !== null) {
                                            label += new Intl.NumberFormat('id-ID', {
                                                style: 'currency',
                                                currency: 'IDR',
                                                minimumFractionDigits: 0
                                            }).format(context.parsed.y);
                                        }
                                        return label;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false }
                            },
                            y: {
                                beginAtZero: true,
                                border: { dash: [4, 4] },
                                grid: { color: '#f4f4f5' }, 
                                ticks: {
                                    callback: function(value) {
                                        // Mengubah format panjang (Rp1.000.000) menjadi singkat (1 jt)
                                        return new Intl.NumberFormat('id-ID', {
                                            notation: "compact",
                                            compactDisplay: "short"
                                        }).format(value);
                                    }
                                }
                            }
                        }
                    }
                });
            },

            updateChart() {
                this.chartInstance.data = this.getChartConfig();
                this.chartInstance.update();
            },

            getChartConfig() {
                const currentData = this.data[this.period];
                return {
                    labels: currentData.labels,
                    datasets: [
                        {
                            label: 'Pemasukan',
                            data: currentData.income,
                            borderColor: '#16a34a',
                            backgroundColor: 'rgba(22, 163, 74, 0.1)',
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true,
                            pointRadius: 3,
                            pointHoverRadius: 5
                        },
                        {
                            label: 'Pengeluaran',
                            data: currentData.expense,
                            borderColor: '#e11d48',
                            backgroundColor: 'rgba(225, 29, 72, 0.1)',
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true,
                            pointRadius: 3,
                            pointHoverRadius: 5
                        }
                    ]
                };
            }
        }));
    });
</script>