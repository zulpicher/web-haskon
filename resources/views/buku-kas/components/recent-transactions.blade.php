{{-- ================================================= --}}
{{-- TRANSAKSI TERBARU --}}
{{-- ================================================= --}}

<div class="haskon-card bg-white border border-zinc-200 overflow-hidden">
    {{-- Header Card --}}
    <div class="border-b border-zinc-200 bg-white px-5 py-4">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-zinc-900 text-white flex items-center justify-center shadow-xs flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-zinc-900 tracking-tight">
                        Transaksi Terbaru
                    </h3>
                    <p class="text-xs text-zinc-500">
                        Lima transaksi terakhir pada buku kas
                    </p>
                </div>
            </div>

            <button
                type="button"
                @click="openHistory()"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-zinc-100 hover:bg-zinc-900 hover:text-white text-zinc-800 border border-zinc-200 transition duration-150"
            >
                Lihat Semua
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>

    @if ($recentTransactions->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200">
                <thead class="bg-zinc-900 text-zinc-200">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-zinc-300">
                            Tanggal
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-zinc-300">
                            Keterangan
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-zinc-300">
                            Jenis
                        </th>
                        <th class="px-5 py-3 text-right text-xs font-bold uppercase tracking-wider text-zinc-300">
                            Jumlah
                        </th>
                        <th class="px-5 py-3 text-right text-xs font-bold uppercase tracking-wider text-zinc-300">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-zinc-200 bg-white">
                    @foreach ($recentTransactions as $transaction)
                        @php
                            $transactionData = [
                                'id' => $transaction->id,

                                'date' => $transaction->transaction_date->format('Y-m-d'),

                                'dateFormatted' => $transaction->transaction_date->format('d/m/Y'),

                                'type' => $transaction->type,

                                'typeLabel' => $transaction->type === 'income'
                                    ? 'Pemasukan'
                                    : 'Pengeluaran',

                                'description' => $transaction->description,

                                'amount' => (string) $transaction->amount,

                                'amountFormatted' => 'Rp' . number_format($transaction->amount, 0, ',', '.'),

                                'created' => $transaction->created_at->format('d/m/Y H:i'),

                                'updated' => $transaction->updated_at->format('d/m/Y H:i'),

                                // URL untuk hapus
                                'deleteUrl' => route('buku-kas.transactions.destroy', $transaction),
                            ];
                        @endphp

                        <tr class="transition hover:bg-zinc-50/80">
                            {{-- Tanggal --}}
                            <td class="whitespace-nowrap px-5 py-3.5 text-xs font-medium text-zinc-600">
                                {{ $transaction->transaction_date->format('d/m/Y') }}
                            </td>

                            {{-- Keterangan --}}
                            <td class="px-5 py-3.5 text-sm font-semibold text-zinc-900">
                                <div class="max-w-xs truncate">
                                    {{ $transaction->description }}
                                </div>
                            </td>

                            {{-- Jenis --}}
                            <td class="whitespace-nowrap px-5 py-3.5">
                                @if ($transaction->type === 'income')
                                    <span class="inline-flex items-center gap-1 rounded-md bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Pemasukan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-md bg-rose-50 px-2.5 py-1 text-xs font-bold text-rose-700 border border-rose-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        Pengeluaran
                                    </span>
                                @endif
                            </td>

                            {{-- Jumlah --}}
                            <td class="whitespace-nowrap px-5 py-3.5 text-right text-sm font-bold {{ $transaction->type === 'income' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $transaction->type === 'income' ? '+' : '-' }}
                                Rp{{ number_format($transaction->amount, 0, ',', '.') }}
                            </td>

                            {{-- Aksi --}}
                            <td class="whitespace-nowrap px-5 py-3.5">
                                <div class="flex items-center justify-end gap-1.5">
                                    {{-- Detail --}}
                                    <button
                                        type="button"
                                        @click="openDetail(@js($transactionData))"
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-zinc-100 text-zinc-700 hover:bg-zinc-900 hover:text-white border border-zinc-200 transition duration-150"
                                        title="Detail"
                                    >
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>

                                    {{-- Edit --}}
                                    <button
                                        type="button"
                                        @click="openEdit(@js($transactionData))"
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-zinc-100 text-zinc-700 hover:bg-zinc-900 hover:text-white border border-zinc-200 transition duration-150"
                                        title="Edit"
                                    >
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </button>

                                    {{-- Hapus --}}
                                    <button
                                        type="button"
                                        @click="openDelete(@js($transactionData))"
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white border border-rose-200 transition duration-150"
                                        title="Hapus"
                                    >
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-7 0h8" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        {{-- Empty State --}}
        <div class="px-5 py-12 text-center">
            <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-zinc-100 text-zinc-500 border border-zinc-200">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14h6m-6-4h6m2 10H7a2 2 0 01-2-2V6a2 2 0 012-2h7l5 5v9a2 2 0 01-2 2z" />
                </svg>
            </div>
            <p class="text-sm font-medium text-zinc-600">
                Belum ada transaksi.
            </p>
            <button
                type="button"
                @click="openAdd()"
                class="mt-3 inline-flex items-center gap-1 text-sm font-semibold text-zinc-900 hover:text-amber-600 transition"
            >
                Tambahkan transaksi pertama →
            </button>
        </div>
    @endif
</div>
