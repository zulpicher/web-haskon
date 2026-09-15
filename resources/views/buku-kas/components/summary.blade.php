{{-- ================================================= --}}
{{-- FINANCIAL SUMMARY --}}
{{-- ================================================= --}}

<div class="mb-8">
    <div class="mb-4">
        <h3 class="text-lg font-semibold text-haskon-primary">
            Ringkasan Keuangan
        </h3>

        <p class="mt-1 text-sm text-haskon-muted">
            Kondisi keuangan pada bulan {{ now()->translatedFormat('F Y') }}.
        </p>
    </div>


    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        {{-- Saldo --}}
        <div class="relative overflow-hidden haskon-card p-5">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-haskon-muted">
                        Saldo Saat Ini
                    </p>

                    <p class="mt-2 text-2xl font-bold {{ $isNegative ? 'text-haskon-danger' : 'text-haskon-primary' }}">
                        Rp{{ number_format($currentBalance, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Pemasukan --}}
        <div class="haskon-card p-5">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-haskon-muted">
                        Pemasukan Bulan Ini
                    </p>

                    <p class="mt-2 text-2xl font-bold text-haskon-success">
                        Rp{{ number_format($monthlyIncome, 0, ',', '.') }}
                    </p>
                </div>

                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-haskon-success text-haskon-inverted">
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M7 17l10-10M7 7h10v10"
                        />
                    </svg>
                </div>

            </div>
        </div>

        {{-- Pengeluaran --}}
        <div class="haskon-card p-5">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-haskon-muted">
                        Pengeluaran Bulan Ini
                    </p>

                    <p class="mt-2 text-2xl font-bold text-haskon-danger">
                        Rp{{ number_format($monthlyExpense, 0, ',', '.') }}
                    </p>
                </div>

                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-haskon-danger text-haskon-inverted">
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M17 7L7 17m10 0H7V7"
                        />
                    </svg>
                </div>

            </div>
        </div>

    </div>
</div>
