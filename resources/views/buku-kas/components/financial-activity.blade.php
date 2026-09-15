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

<div class="haskon-card overflow-hidden">

    {{-- Header --}}
    <div class="border-b border-haskon-border px-5 py-4">
        <h3 class="text-lg font-semibold text-haskon-primary">
            Aktivitas Keuangan
        </h3>

        <p class="mt-1 text-sm text-haskon-muted">
            Perbandingan pemasukan dan pengeluaran bulan ini.
        </p>
    </div>


    {{-- Content --}}
    <div class="p-5">

        {{-- Donut Chart --}}
        <div class="flex justify-center">

            <div class="relative h-52 w-52">

                @if ($totalMonthlyActivity > 0)

                    <div
                        class="absolute inset-0 rounded-full"
                        style="
                            background: conic-gradient(
                                #2b8a3e 0% {{ $incomePercentage }}%,
                                #c92a2a {{ $incomePercentage }}% 100%
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
                            bg-white
                            text-center
                        "
                    >
                        <span class="text-xs font-medium text-haskon-muted">
                            Total Aktivitas
                        </span>

                        <span class="mt-1 text-lg font-bold text-haskon-primary">
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
                            border-[20px]
                            border-haskon-surface
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
                            bg-white
                            text-center
                        "
                    >
                        <span class="text-xs font-medium text-haskon-muted">
                            Belum ada
                        </span>

                        <span class="mt-1 text-sm font-semibold text-haskon-primary">
                            Aktivitas
                        </span>
                    </div>

                @endif

            </div>

        </div>


        {{-- Legend --}}
        <div class="mt-6 space-y-4">

            {{-- Pemasukan --}}
            <div class="flex items-center justify-between">

                <div class="flex items-center gap-3">

                    <span
                        class="
                            h-3 w-3
                            flex-shrink-0
                            rounded-full
                            bg-haskon-success
                        "
                    ></span>

                    <div>
                        <p class="text-sm font-medium text-haskon-text">
                            Pemasukan
                        </p>

                        <p class="text-xs text-haskon-muted">
                            {{ number_format($incomePercentage, 1, ',', '.') }}%
                        </p>
                    </div>

                </div>

                <span class="text-sm font-semibold text-haskon-success">
                    Rp{{ number_format($monthlyIncome, 0, ',', '.') }}
                </span>

            </div>


            {{-- Pengeluaran --}}
            <div class="flex items-center justify-between">

                <div class="flex items-center gap-3">

                    <span
                        class="
                            h-3 w-3
                            flex-shrink-0
                            rounded-full
                            bg-haskon-danger
                        "
                    ></span>

                    <div>
                        <p class="text-sm font-medium text-haskon-text">
                            Pengeluaran
                        </p>

                        <p class="text-xs text-haskon-muted">
                            {{ number_format($expensePercentage, 1, ',', '.') }}%
                        </p>
                    </div>

                </div>

                <span class="text-sm font-semibold text-haskon-danger">
                    Rp{{ number_format($monthlyExpense, 0, ',', '.') }}
                </span>

            </div>

        </div>


        {{-- Selisih --}}
        <div class="mt-6 border-t border-haskon-border pt-5">

            <div class="flex items-center justify-between">

                <span class="text-sm font-medium text-haskon-muted">
                    Selisih Bulan Ini
                </span>

                <span
                    class="
                        text-lg
                        font-bold
                        {{ $monthlyDifference >= 0
                            ? 'text-haskon-success'
                            : 'text-haskon-danger'
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
