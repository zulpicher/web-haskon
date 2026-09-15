{{-- ================================================= --}}
{{-- TRANSAKSI TERBARU --}}
{{-- ================================================= --}}

<div class="mb-8 haskon-card overflow-hidden">
    {{-- Header Card --}}
    <div class="border-b border-haskon-border px-5 py-4">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-lg font-semibold text-haskon-primary">
                    Transaksi Terbaru
                </h3>
                <p class="mt-1 text-sm text-haskon-muted">
                    Lima transaksi terakhir pada buku kas.
                </p>
            </div>
            <button
                type="button"
                @click="openHistory()"
                class="text-sm font-semibold text-haskon-muted transition hover:text-haskon-primary"
            >
                Lihat Semua →
            </button>
        </div>
    </div>

    @if ($recentTransactions->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-haskon-border">
                <thead class="bg-haskon-surface">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-haskon-muted">
                            Tanggal
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-haskon-muted">
                            Keterangan
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-haskon-muted">
                            Jenis
                        </th>
                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-haskon-muted">
                            Jumlah
                        </th>
                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-haskon-muted">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-haskon-border">
                    @foreach ($recentTransactions as $transaction)
                        @php
                            $transactionData = [
                                'id' => $transaction->id,
                                'date' => $transaction->transaction_date->format('Y-m-d'),
                                'dateFormatted' => $transaction->transaction_date->format('d/m/Y'),
                                'type' => $transaction->type,
                                'typeLabel' => $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran',
                                'description' => $transaction->description,
                                'amount' => (string) $transaction->amount,
                                'amountFormatted' => 'Rp' . number_format($transaction->amount, 0, ',', '.'),
                                'created' => $transaction->created_at->format('d/m/Y H:i'),
                                'updated' => $transaction->updated_at->format('d/m/Y H:i'),
                            ];
                        @endphp

                        <tr class="transition hover:bg-haskon-surface">
                            {{-- Tanggal --}}
                            <td class="whitespace-nowrap px-5 py-4 text-sm text-haskon-muted">
                                {{ $transaction->transaction_date->format('d/m/Y') }}
                            </td>

                            {{-- Keterangan --}}
                            <td class="px-5 py-4 text-sm font-medium text-haskon-text">
                                <div class="max-w-xs truncate">
                                    {{ $transaction->description }}
                                </div>
                            </td>

                            {{-- Jenis --}}
                            <td class="whitespace-nowrap px-5 py-4">
                                @if ($transaction->type === 'income')
                                    <span class="inline-flex items-center rounded-full border border-haskon-border bg-haskon-success px-2.5 py-1 text-xs font-semibold text-haskon-inverted">
                                        Pemasukan
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full border border-haskon-border bg-haskon-danger px-2.5 py-1 text-xs font-semibold text-haskon-inverted">
                                        Pengeluaran
                                    </span>
                                @endif
                            </td>

                            {{-- Jumlah --}}
                            <td class="whitespace-nowrap px-5 py-4 text-right text-sm font-semibold {{ $transaction->type === 'income' ? 'text-haskon-success' : 'text-haskon-danger' }}">
                                {{ $transaction->type === 'income' ? '+' : '-' }}
                                Rp{{ number_format($transaction->amount, 0, ',', '.') }}
                            </td>

                            {{-- Aksi --}}
                            <td class="whitespace-nowrap px-5 py-4">
                                <div class="flex items-center justify-end gap-1">
                                    {{-- Detail --}}
                                    <button
                                        type="button"
                                        @click="openDetail(@js($transactionData))"
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-haskon-muted transition hover:bg-haskon-surface hover:text-haskon-primary"
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
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-haskon-muted transition hover:bg-haskon-surface hover:text-haskon-primary"
                                        title="Edit"
                                    >
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </button>

                                    {{-- Hapus --}}
                                    <form
                                        method="POST"
                                        action="{{ route('buku-kas.transactions.destroy', $transaction) }}"
                                        onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-haskon-danger transition hover:bg-haskon-surface"
                                            title="Hapus"
                                        >
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-7 0h8" />
                                            </svg>
                                        </button>
                                    </form>
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
            <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-haskon-surface text-haskon-muted">
                <svg class="h-6 w-6 text-haskon-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14h6m-6-4h6m2 10H7a2 2 0 01-2-2V6a2 2 0 012-2h7l5 5v9a2 2 0 01-2 2z" />
                </svg>
            </div>
            <p class="text-sm text-haskon-muted">
                Belum ada transaksi.
            </p>
            <button
                type="button"
                @click="openAdd()"
                class="mt-3 text-sm font-semibold text-haskon-primary transition hover:text-haskon-muted"
            >
                Tambahkan transaksi pertama →
            </button>
        </div>
    @endif
</div>
