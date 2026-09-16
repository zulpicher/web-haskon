{{-- ================================================= --}}
{{-- FINANCIAL ACTIVITY --}}
{{-- ================================================= --}}

@php
    $monthlyDifference = $monthlyIncome - $monthlyExpense;

    $totalMonthlyActivity = $monthlyIncome + $monthlyExpense;

    $incomePercentage = $totalMonthlyActivity > 0
        ? ($monthlyIncome / $totalMonthlyActivity) * 100
        : 0;

    $expensePercentage = $totalMonthlyActivity > 0
        ? ($monthlyExpense / $totalMonthlyActivity) * 100
        : 0;
@endphp

<div class="haskon-card bg-white border border-zinc-200 overflow-hidden">

    {{-- Header --}}
    <div class="border-b border-zinc-200 bg-white px-5 py-4">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-zinc-900 text-white flex items-center justify-center shadow-xs flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                </svg>
            </div>
            <div>
                <h3 class="text-base font-bold text-zinc-900 tracking-tight">
                    Aktivitas Keuangan
                </h3>
                <p class="text-xs text-zinc-500">
                    Rasio pemasukan vs pengeluaran bulan ini
                </p>
            </div>
        </div>
    </div>


    {{-- Content --}}
    <div class="p-5">

        {{-- Donut Chart --}}
        <div class="flex justify-center">

            <div class="relative h-52 w-52">

                @if ($totalMonthlyActivity > 0)

                    <div
                        class="absolute inset-0 rounded-full shadow-xs"
                        style="
                            background: conic-gradient(
                                #16a34a 0% {{ $incomePercentage }}%,
                                #e11d48 {{ $incomePercentage }}% 100%
                            );
                        "
                    ></div>

                    {{-- Donut Hole --}}
                    <div
                        class="
                            absolute
                            inset-7
                            flex
                            flex-col
                            items-center
                            justify-center
                            rounded-full
                            bg-zinc-50
                            border
                            border-zinc-200
                            text-center
                            shadow-inner
                        "
                    >
                        <span class="text-[11px] font-semibold uppercase tracking-wider text-zinc-400">
                            Total Arus
                        </span>

                        <span class="mt-0.5 text-base font-black text-zinc-900">
                            Rp{{ number_format($totalMonthlyActivity, 0, ',', '.') }}
                        </span>
                    </div>

                @else

                    {{-- Empty Chart --}}
                    <div
                        class="
                            absolute
                            inset-0
                            rounded-full
                            border-[18px]
                            border-zinc-100
                        "
                    ></div>

                    <div
                        class="
                            absolute
                            inset-7
                            flex
                            flex-col
                            items-center
                            justify-center
                            rounded-full
                            bg-zinc-50
                            border
                            border-zinc-200
                            text-center
                        "
                    >
                        <span class="text-xs font-medium text-zinc-400">
                            Belum ada
                        </span>

                        <span class="mt-0.5 text-sm font-bold text-zinc-700">
                            Aktivitas
                        </span>
                    </div>

                @endif

            </div>

        </div>


        {{-- Legend --}}
        <div class="mt-6 space-y-3">

            {{-- Pemasukan --}}
            <div class="flex items-center justify-between p-2.5 rounded-lg bg-zinc-50 border border-zinc-100">

                <div class="flex items-center gap-2.5">

                    <span
                        class="
                            h-3 w-3
                            flex-shrink-0
                            rounded-full
                            bg-emerald-600
                        "
                    ></span>

                    <div>
                        <p class="text-xs font-bold text-zinc-800">
                            Pemasukan
                        </p>

                        <p class="text-[11px] text-zinc-400">
                            {{ number_format($incomePercentage, 1, ',', '.') }}%
                        </p>
                    </div>

                </div>

                <span class="text-xs font-bold text-emerald-700">
                    Rp{{ number_format($monthlyIncome, 0, ',', '.') }}
                </span>

            </div>


            {{-- Pengeluaran --}}
            <div class="flex items-center justify-between p-2.5 rounded-lg bg-zinc-50 border border-zinc-100">

                <div class="flex items-center gap-2.5">

                    <span
                        class="
                            h-3 w-3
                            flex-shrink-0
                            rounded-full
                            bg-rose-600
                        "
                    ></span>

                    <div>
                        <p class="text-xs font-bold text-zinc-800">
                            Pengeluaran
                        </p>

                        <p class="text-[11px] text-zinc-400">
                            {{ number_format($expensePercentage, 1, ',', '.') }}%
                        </p>
                    </div>

                </div>

                <span class="text-xs font-bold text-rose-700">
                    Rp{{ number_format($monthlyExpense, 0, ',', '.') }}
                </span>

            </div>

        </div>


        {{-- Selisih --}}
        <div class="mt-5 border-t border-zinc-200 pt-4">

            <div class="flex items-center justify-between p-3 rounded-xl bg-zinc-50 border border-zinc-200/80">

                <span class="text-xs font-semibold uppercase tracking-wider text-zinc-500">
                    Selisih Kas
                </span>

                <span
                    class="
                        text-sm
                        font-black
                        {{ $monthlyDifference >= 0
                            ? 'text-emerald-700'
                            : 'text-rose-700'
                        }}
                    "
                >
                    {{ $monthlyDifference >= 0 ? '+' : '-' }}
                    Rp{{ number_format(abs($monthlyDifference), 0, ',', '.') }}
                </span>

            </div>

        </div>

    </div>

</div>
