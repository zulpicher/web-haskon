{{-- ================================================= --}}
{{-- FINANCIAL SUMMARY --}}
{{-- ================================================= --}}

<div class="mb-6">
    <div class="mb-4 flex items-center justify-between">
        <div>
            <h3 class="text-lg font-bold text-zinc-900 tracking-tight">
                Ringkasan Keuangan
            </h3>

            <p class="mt-0.5 text-xs font-medium text-zinc-500">
                Kondisi dan arus kas per bulan {{ now()->translatedFormat('F Y') }}.
            </p>
        </div>

        <span class="text-xs font-semibold px-3 py-1 rounded-md bg-zinc-200/80 text-zinc-700">
            {{ now()->translatedFormat('d M Y') }}
        </span>
    </div>


    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        {{-- Saldo (Dark Accent Card) --}}
        <div class="relative overflow-hidden rounded-xl bg-zinc-900 text-white p-5 shadow-sm border border-zinc-800">
            <div class="absolute -right-6 -bottom-6 w-28 h-28 bg-amber-400/10 rounded-full blur-xl pointer-events-none"></div>

            <div class="flex items-center justify-between relative z-10">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">
                        Saldo Saat Ini
                    </p>

                    <p class="mt-2 text-2xl font-black {{ $isNegative ? 'text-red-400' : 'text-white' }}">
                        Rp{{ number_format($currentBalance, 0, ',', '.') }}
                    </p>

                    <div class="mt-2 flex items-center gap-1.5 text-xs text-zinc-400">
                        <span class="w-1.5 h-1.5 rounded-full {{ $isNegative ? 'bg-red-400' : 'bg-emerald-400' }}"></span>
                        <span>Status: {{ $isNegative ? 'Defisit' : 'Surplus / Aman' }}</span>
                    </div>
                </div>

                {{-- Dark Icon Badge with Gold Accent --}}
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-zinc-800 text-amber-400 border border-zinc-700 shadow-inner flex-shrink-0">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Pemasukan --}}
        <div class="haskon-card p-5 bg-white border border-zinc-200 relative overflow-hidden">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-zinc-500">
                        Pemasukan Bulan Ini
                    </p>

                    <p class="mt-2 text-2xl font-black text-emerald-600">
                        Rp{{ number_format($monthlyIncome, 0, ',', '.') }}
                    </p>

                    <p class="mt-2 text-xs text-zinc-400">
                        Total penerimaan dana periode ini
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-200/80 shadow-xs flex-shrink-0">
                    <svg
                        class="h-6 w-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2.5"
                            d="M7 17l10-10M7 7h10v10"
                        />
                    </svg>
                </div>

            </div>
        </div>

        {{-- Pengeluaran --}}
        <div class="haskon-card p-5 bg-white border border-zinc-200 relative overflow-hidden">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-zinc-500">
                        Pengeluaran Bulan Ini
                    </p>

                    <p class="mt-2 text-2xl font-black text-rose-600">
                        Rp{{ number_format($monthlyExpense, 0, ',', '.') }}
                    </p>

                    <p class="mt-2 text-xs text-zinc-400">
                        Total pengeluaran dana periode ini
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-rose-50 text-rose-600 border border-rose-200/80 shadow-xs flex-shrink-0">
                    <svg
                        class="h-6 w-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2.5"
                            d="M17 7L7 17m10 0H7V7"
                        />
                    </svg>
                </div>

            </div>
        </div>

    </div>
</div>
