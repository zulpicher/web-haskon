{{-- resources\views\buku-kas\dashboard.blade.php --}}
<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Buku Kas
                </h2>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Kelola kondisi dan aktivitas keuangan
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                {{-- Tambah Transaksi --}}
                <button
                    type="button"
                    onclick="window.dispatchEvent(new CustomEvent('open-add-modal'))"
                    class="inline-flex items-center justify-center px-4 py-2.5
                           bg-green-600 border border-transparent rounded-lg
                           font-semibold text-sm text-white
                           hover:bg-green-700
                           focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2
                           transition"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 4v16m8-8H4"/>
                    </svg>

                    Tambah Transaksi
                </button>

                {{-- ke reports --}}
                <a
                    href="{{ route('buku-kas.reports.index') }}"
                    class="inline-flex items-center justify-center px-4 py-2.5
                        bg-green-600 border border-transparent rounded-lg
                        font-semibold text-sm text-white
                        hover:bg-green-700
                        focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2
                        transition"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 17v-6m3 6V7m3 10v-4m4 4H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2z"/>
                    </svg>

                    Rekap
                </a>

                {{-- Riwayat --}}
                <button
                    type="button"
                    onclick="window.dispatchEvent(new CustomEvent('open-history-modal'))"
                    class="inline-flex items-center justify-center px-4 py-2.5
                           bg-gray-700 border border-transparent rounded-lg
                           font-semibold text-sm text-white
                           hover:bg-gray-800
                           focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2
                           transition
                           dark:bg-gray-600 dark:hover:bg-gray-500"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>

                    Riwayat Transaksi
                </button>
            </div>
        </div>
    </x-slot>


    {{-- ========================================================= --}}
    {{-- ALPINE APP --}}
    {{-- ========================================================= --}}
    <div
        x-data="{
            modal: null,

            editId: null,
            editType: '',
            editDate: '',
            editDescription: '',
            editAmount: '',
            editAction: '',

            detail: {},

            historySearch: '',
            historyType: '',
            historyStartDate: '',
            historyEndDate: '',

            openAdd() {
                this.modal = 'add';
            },

            openEdit(transaction) {
                this.editId = transaction.id;
                this.editType = transaction.type;
                this.editDate = transaction.date;
                this.editDescription = transaction.description;
                this.editAmount = transaction.amount;
                this.editAction = '{{ url('/buku-kas/transactions') }}/' + transaction.id;

                this.modal = 'edit';
            },

            openDetail(transaction) {
                this.detail = transaction;
                this.modal = 'detail';
            },

            openHistory() {
                this.modal = 'history';
            },

            closeModal() {
                this.modal = null;
            },

            resetHistory() {
                this.historySearch = '';
                this.historyType = '';
                this.historyStartDate = '';
                this.historyEndDate = '';
            }
        }"
        x-init="
            console.log('ALPINE X-DATA AKTIF');

            window.addEventListener('open-add-modal', () => {
                modal = 'add';
            });

            window.addEventListener('open-history-modal', () => {
                modal = 'history';
            });
        "

        @open-add-modal.window="modal = 'add'"
        @open-history-modal.window="modal = 'history'"
        @keydown.escape.window="closeModal()"
    >



        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                {{-- ================================================= --}}
                {{-- WARNING SALDO NEGATIF --}}
                {{-- ================================================= --}}

                @if ($isNegative)
                    <div class="mb-6 flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl dark:bg-red-900/20 dark:border-red-800 dark:text-red-300">

                        <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M12 9v4m0 4h.01M10.29 3.86l-7.82 14a2 2 0 001.74 3h15.58a2 2 0 001.74-3l-7.82-14a2 2 0 00-3.42 0z"/>
                        </svg>

                        <div>
                            <p class="font-semibold">
                                Peringatan Saldo
                            </p>

                            <p class="text-sm mt-1">
                                Saldo kas saat ini berada dalam kondisi negatif.
                            </p>
                        </div>
                    </div>
                @endif


                {{-- ================================================= --}}
                {{-- FINANCIAL SUMMARY --}}
                {{-- ================================================= --}}

                <div class="mb-8">

                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                            Ringkasan Keuangan
                        </h3>

                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Kondisi keuangan pada bulan {{ now()->translatedFormat('F Y') }}.
                        </p>
                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        {{-- Saldo --}}
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">

                            <div class="flex items-center justify-between">

                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        Saldo Saat Ini
                                    </p>

                                    <p class="mt-2 text-2xl font-bold
                                        {{ $isNegative
                                            ? 'text-red-600 dark:text-red-400'
                                            : 'text-gray-900 dark:text-white' }}">
                                        Rp{{ number_format($currentBalance, 0, ',', '.') }}
                                    </p>
                                </div>

                                <div class="w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center">

                                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-300"
                                         fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V6m0 6v2m0 0v2m0-2c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>

                                </div>

                            </div>

                        </div>


                        {{-- Pemasukan --}}
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">

                            <div class="flex items-center justify-between">

                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        Pemasukan Bulan Ini
                                    </p>

                                    <p class="mt-2 text-2xl font-bold text-green-600 dark:text-green-400">
                                        Rp{{ number_format($monthlyIncome, 0, ',', '.') }}
                                    </p>
                                </div>

                                <div class="w-10 h-10 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center">

                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400"
                                         fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M7 17l10-10M7 7h10v10"/>
                                    </svg>

                                </div>

                            </div>

                        </div>


                        {{-- Pengeluaran --}}
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">

                            <div class="flex items-center justify-between">

                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        Pengeluaran Bulan Ini
                                    </p>

                                    <p class="mt-2 text-2xl font-bold text-red-600 dark:text-red-400">
                                        Rp{{ number_format($monthlyExpense, 0, ',', '.') }}
                                    </p>
                                </div>

                                <div class="w-10 h-10 rounded-lg bg-red-100 dark:bg-red-900/30 flex items-center justify-center">

                                    <svg class="w-5 h-5 text-red-600 dark:text-red-400"
                                         fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M17 7L7 17m10 0H7V7"/>
                                    </svg>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- TRANSAKSI TERBARU --}}
                {{-- ================================================= --}}

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-8">

                    <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">

                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">

                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                    Transaksi Terbaru
                                </h3>

                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    Lima transaksi terakhir pada buku kas.
                                </p>
                            </div>

                            <button
                                type="button"
                                @click="openHistory()"
                                class="text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                            >
                                Lihat Semua →
                            </button>

                        </div>

                    </div>


                    @if ($recentTransactions->count() > 0)

                        <div class="overflow-x-auto">

                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                                <thead class="bg-gray-50 dark:bg-gray-900/40">

                                    <tr>

                                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Tanggal
                                        </th>

                                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Keterangan
                                        </th>

                                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Jenis
                                        </th>

                                        <th class="px-5 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Jumlah
                                        </th>

                                        <th class="px-5 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Aksi
                                        </th>

                                    </tr>

                                </thead>


                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

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
                                            ];
                                        @endphp

                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">

                                            {{-- Tanggal --}}
                                            <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                {{ $transaction->transaction_date->format('d/m/Y') }}
                                            </td>


                                            {{-- Keterangan --}}
                                            <td class="px-5 py-4 text-sm text-gray-800 dark:text-gray-200">
                                                <div class="max-w-xs truncate">
                                                    {{ $transaction->description }}
                                                </div>
                                            </td>


                                            {{-- Jenis --}}
                                            <td class="px-5 py-4 whitespace-nowrap">

                                                @if ($transaction->type === 'income')

                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                        Pemasukan
                                                    </span>

                                                @else

                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                                        Pengeluaran
                                                    </span>

                                                @endif

                                            </td>


                                            {{-- Jumlah --}}
                                            <td class="px-5 py-4 whitespace-nowrap text-sm text-right font-semibold
                                                {{ $transaction->type === 'income'
                                                    ? 'text-green-600 dark:text-green-400'
                                                    : 'text-red-600 dark:text-red-400' }}">

                                                {{ $transaction->type === 'income' ? '+' : '-' }}
                                                Rp{{ number_format($transaction->amount, 0, ',', '.') }}

                                            </td>


                                            {{-- Aksi --}}
                                            <td class="px-5 py-4 whitespace-nowrap">

                                                <div class="flex items-center justify-end gap-1">

                                                    {{-- Detail --}}
                                                    <button
                                                        type="button"
                                                        @click="openDetail(@js($transactionData))"
                                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200 transition"
                                                        title="Detail"
                                                    >
                                                        <svg class="w-4 h-4"
                                                             fill="none"
                                                             stroke="currentColor"
                                                             viewBox="0 0 24 24">
                                                            <path stroke-linecap="round"
                                                                  stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                            <path stroke-linecap="round"
                                                                  stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                        </svg>
                                                    </button>


                                                    {{-- Edit --}}
                                                    <button
                                                        type="button"
                                                        @click="openEdit(@js($transactionData))"
                                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-amber-600 hover:bg-amber-50 dark:text-amber-400 dark:hover:bg-amber-900/20 transition"
                                                        title="Edit"
                                                    >
                                                        <svg class="w-4 h-4"
                                                             fill="none"
                                                             stroke="currentColor"
                                                             viewBox="0 0 24 24">
                                                            <path stroke-linecap="round"
                                                                  stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/>
                                                            <path stroke-linecap="round"
                                                                  stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
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
                                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20 transition"
                                                            title="Hapus"
                                                        >
                                                            <svg class="w-4 h-4"
                                                                 fill="none"
                                                                 stroke="currentColor"
                                                                 viewBox="0 0 24 24">
                                                                <path stroke-linecap="round"
                                                                      stroke-linejoin="round"
                                                                      stroke-width="2"
                                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-7 0h8"/>
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

                        <div class="px-5 py-12 text-center">

                            <div class="w-12 h-12 mx-auto rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-3">

                                <svg class="w-6 h-6 text-gray-400"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M9 14h6m-6-4h6m2 10H7a2 2 0 01-2-2V6a2 2 0 012-2h7l5 5v9a2 2 0 01-2 2z"/>
                                </svg>

                            </div>

                            <p class="text-gray-500 dark:text-gray-400">
                                Belum ada transaksi.
                            </p>

                            <button
                                type="button"
                                @click="openAdd()"
                                class="mt-3 text-sm font-medium text-green-600 hover:text-green-700 dark:text-green-400"
                            >
                                Tambahkan transaksi pertama →
                            </button>

                        </div>

                    @endif

                </div>


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


                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">

                    <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">

                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                            Aktivitas Keuangan
                        </h3>

                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Perbandingan pemasukan dan pengeluaran bulan ini.
                        </p>

                    </div>


                    <div class="p-5">

                        {{-- Pemasukan --}}
                        <div class="mb-5">

                            <div class="flex items-center justify-between mb-2">

                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Pemasukan
                                </span>

                                <span class="text-sm font-semibold text-green-600 dark:text-green-400">
                                    Rp{{ number_format($monthlyIncome, 0, ',', '.') }}
                                </span>

                            </div>

                            <div class="w-full h-2.5 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">

                                <div
                                    class="h-full bg-green-500 rounded-full transition-all duration-500"
                                    style="width: {{ min($incomePercentage, 100) }}%"
                                ></div>

                            </div>

                        </div>


                        {{-- Pengeluaran --}}
                        <div>

                            <div class="flex items-center justify-between mb-2">

                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Pengeluaran
                                </span>

                                <span class="text-sm font-semibold text-red-600 dark:text-red-400">
                                    Rp{{ number_format($monthlyExpense, 0, ',', '.') }}
                                </span>

                            </div>

                            <div class="w-full h-2.5 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">

                                <div
                                    class="h-full bg-red-500 rounded-full transition-all duration-500"
                                    style="width: {{ min($expensePercentage, 100) }}%"
                                ></div>

                            </div>

                        </div>


                        {{-- Selisih --}}
                        <div class="mt-6 pt-5 border-t border-gray-200 dark:border-gray-700">

                            <div class="flex items-center justify-between">

                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                    Selisih Bulan Ini
                                </span>

                                <span class="text-lg font-bold
                                    {{ $monthlyDifference >= 0
                                        ? 'text-green-600 dark:text-green-400'
                                        : 'text-red-600 dark:text-red-400' }}">

                                    {{ $monthlyDifference >= 0 ? '+' : '-' }}
                                    Rp{{ number_format(abs($monthlyDifference), 0, ',', '.') }}

                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>


        {{-- ========================================================= --}}
        {{-- MODAL TAMBAH TRANSAKSI --}}
        {{-- ========================================================= --}}

        <div
            x-cloak
            x-show="modal === 'add'"
            x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
        >

            <div
                class="absolute inset-0 bg-black/50"
                @click="closeModal()"
            ></div>


            <div
                x-show="modal === 'add'"
                x-transition
                class="relative w-full max-w-lg bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden"
            >

                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                            Tambah Transaksi
                        </h3>

                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Tambahkan pemasukan atau pengeluaran.
                        </p>
                    </div>

                    <button
                        type="button"
                        @click="closeModal()"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>

                </div>


                <form
                    method="POST"
                    action="{{ route('buku-kas.transactions.store') }}"
                    class="p-6"
                >

                    @csrf

                    <div class="space-y-5">

                        {{-- Tanggal --}}
                        <div>

                            <label
                                for="add_transaction_date"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5"
                            >
                                Tanggal
                            </label>

                            <input
                                type="date"
                                name="transaction_date"
                                id="add_transaction_date"
                                value="{{ now()->format('Y-m-d') }}"
                                required
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200 focus:border-green-500 focus:ring-green-500"
                            >

                        </div>


                        {{-- Jenis --}}
                        <div>

                            <label
                                for="add_type"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5"
                            >
                                Jenis Transaksi
                            </label>

                            <select
                                name="type"
                                id="add_type"
                                required
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200 focus:border-green-500 focus:ring-green-500"
                            >
                                <option value="income">
                                    Pemasukan
                                </option>

                                <option value="expense">
                                    Pengeluaran
                                </option>
                            </select>

                        </div>


                        {{-- Keterangan --}}
                        <div>

                            <label
                                for="add_description"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5"
                            >
                                Keterangan
                            </label>

                            <textarea
                                name="description"
                                id="add_description"
                                rows="3"
                                required
                                placeholder="Contoh: Pembelian ATK"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200 focus:border-green-500 focus:ring-green-500"
                            ></textarea>

                        </div>


                        {{-- Jumlah --}}
                        <div>

                            <label
                                for="add_amount"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5"
                            >
                                Jumlah
                            </label>

                            <div class="relative">

                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-sm text-gray-500">
                                    Rp
                                </span>

                                <input
                                    type="number"
                                    name="amount"
                                    id="add_amount"
                                    min="1"
                                    step="0.01"
                                    required
                                    placeholder="0"
                                    class="w-full pl-10 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200 focus:border-green-500 focus:ring-green-500"
                                >

                            </div>

                        </div>

                    </div>


                    <div class="mt-6 flex justify-end gap-2">

                        <button
                            type="button"
                            @click="closeModal()"
                            class="px-4 py-2.5 rounded-lg text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                        >
                            Batal
                        </button>

                        <button
                            type="submit"
                            class="px-4 py-2.5 rounded-lg text-sm font-semibold text-white bg-green-600 hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                        >
                            Simpan Transaksi
                        </button>

                    </div>

                </form>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- MODAL DETAIL --}}
        {{-- ========================================================= --}}

        <div
            x-cloak
            x-show="modal === 'detail'"
            x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
        >

            <div
                class="absolute inset-0 bg-black/50"
                @click="closeModal()"
            ></div>


            <div
                x-show="modal === 'detail'"
                x-transition
                class="relative w-full max-w-lg bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden"
            >

                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                            Detail Transaksi
                        </h3>

                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Informasi lengkap transaksi.
                        </p>
                    </div>

                    <button
                        type="button"
                        @click="closeModal()"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>

                </div>


                <div class="p-6">

                    <div class="space-y-4">

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                Tanggal
                            </p>

                            <p
                                class="mt-1 text-sm font-medium text-gray-800 dark:text-gray-200"
                                x-text="detail.dateFormatted"
                            ></p>
                        </div>


                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                Jenis
                            </p>

                            <span
                                class="inline-flex mt-1 px-2.5 py-1 rounded-full text-xs font-semibold"
                                :class="detail.type === 'income'
                                    ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400'
                                    : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400'"
                                x-text="detail.typeLabel"
                            ></span>
                        </div>


                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                Keterangan
                            </p>

                            <p
                                class="mt-1 text-sm text-gray-800 dark:text-gray-200 whitespace-pre-line"
                                x-text="detail.description"
                            ></p>
                        </div>


                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                Jumlah
                            </p>

                            <p
                                class="mt-1 text-xl font-bold"
                                :class="detail.type === 'income'
                                    ? 'text-green-600 dark:text-green-400'
                                    : 'text-red-600 dark:text-red-400'"
                            >
                                <span x-text="detail.type === 'income' ? '+' : '-'"></span>
                                <span x-text="detail.amountFormatted"></span>
                            </p>
                        </div>


                        <div class="pt-4 border-t border-gray-200 dark:border-gray-700">

                            <div class="grid grid-cols-2 gap-4">

                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        Dibuat
                                    </p>

                                    <p
                                        class="mt-1 text-sm text-gray-700 dark:text-gray-300"
                                        x-text="detail.created"
                                    ></p>
                                </div>

                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        Diperbarui
                                    </p>

                                    <p
                                        class="mt-1 text-sm text-gray-700 dark:text-gray-300"
                                        x-text="detail.updated"
                                    ></p>
                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="mt-6 flex justify-end">

                        <button
                            type="button"
                            @click="closeModal()"
                            class="px-4 py-2.5 rounded-lg text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                        >
                            Tutup
                        </button>

                    </div>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- MODAL EDIT --}}
        {{-- ========================================================= --}}

        <div
            x-cloak
            x-show="modal === 'edit'"
            x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
        >

            <div
                class="absolute inset-0 bg-black/50"
                @click="closeModal()"
            ></div>


            <div
                x-show="modal === 'edit'"
                x-transition
                class="relative w-full max-w-lg bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden"
            >

                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                            Edit Transaksi
                        </h3>

                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Perbarui informasi transaksi.
                        </p>
                    </div>

                    <button
                        type="button"
                        @click="closeModal()"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>

                </div>


                <form
                    method="POST"
                    :action="editAction"
                    class="p-6"
                >

                    @csrf
                    @method('PUT')

                    <div class="space-y-5">

                        {{-- Tanggal --}}
                        <div>

                            <label
                                for="edit_transaction_date"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5"
                            >
                                Tanggal
                            </label>

                            <input
                                type="date"
                                name="transaction_date"
                                id="edit_transaction_date"
                                x-model="editDate"
                                required
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200 focus:border-amber-500 focus:ring-amber-500"
                            >

                        </div>


                        {{-- Jenis --}}
                        <div>

                            <label
                                for="edit_type"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5"
                            >
                                Jenis Transaksi
                            </label>

                            <select
                                name="type"
                                id="edit_type"
                                x-model="editType"
                                required
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200 focus:border-amber-500 focus:ring-amber-500"
                            >
                                <option value="income">
                                    Pemasukan
                                </option>

                                <option value="expense">
                                    Pengeluaran
                                </option>
                            </select>

                        </div>


                        {{-- Keterangan --}}
                        <div>

                            <label
                                for="edit_description"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5"
                            >
                                Keterangan
                            </label>

                            <textarea
                                name="description"
                                id="edit_description"
                                rows="3"
                                x-model="editDescription"
                                required
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200 focus:border-amber-500 focus:ring-amber-500"
                            ></textarea>

                        </div>


                        {{-- Jumlah --}}
                        <div>

                            <label
                                for="edit_amount"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5"
                            >
                                Jumlah
                            </label>

                            <div class="relative">

                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-sm text-gray-500">
                                    Rp
                                </span>

                                <input
                                    type="number"
                                    name="amount"
                                    id="edit_amount"
                                    min="1"
                                    step="0.01"
                                    x-model="editAmount"
                                    required
                                    class="w-full pl-10 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200 focus:border-amber-500 focus:ring-amber-500"
                                >

                            </div>

                        </div>

                    </div>


                    <div class="mt-6 flex justify-end gap-2">

                        <button
                            type="button"
                            @click="closeModal()"
                            class="px-4 py-2.5 rounded-lg text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                        >
                            Batal
                        </button>

                        <button
                            type="submit"
                            class="px-4 py-2.5 rounded-lg text-sm font-semibold text-white bg-amber-600 hover:bg-amber-700 focus:ring-2 focus:ring-amber-500 focus:ring-offset-2"
                        >
                            Simpan Perubahan
                        </button>

                    </div>

                </form>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- MODAL RIWAYAT SEMUA TRANSAKSI --}}
        {{-- ========================================================= --}}

        <div
            x-cloak
            x-show="modal === 'history'"
            x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-6"
        >

            <div
                class="absolute inset-0 bg-black/50"
                @click="closeModal()"
            ></div>


            <div
                x-show="modal === 'history'"
                x-transition
                class="relative w-full max-w-6xl max-h-[92vh] bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden flex flex-col"
            >

                {{-- Header --}}
                <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700 flex-shrink-0">

                    <div class="flex items-center justify-between gap-4">

                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                Riwayat Transaksi
                            </h3>

                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Seluruh transaksi pada buku kas.
                            </p>
                        </div>

                        <button
                            type="button"
                            @click="closeModal()"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>

                    </div>


                    {{-- Filter --}}
                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">

                        {{-- Search --}}
                        <div class="lg:col-span-2">

                            <label class="sr-only">
                                Cari transaksi
                            </label>

                            <input
                                type="search"
                                x-model="historySearch"
                                placeholder="Cari keterangan..."
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200 focus:border-gray-500 focus:ring-gray-500"
                            >

                        </div>


                        {{-- Jenis --}}
                        <div>

                            <label class="sr-only">
                                Jenis transaksi
                            </label>

                            <select
                                x-model="historyType"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200 focus:border-gray-500 focus:ring-gray-500"
                            >
                                <option value="">
                                    Semua Jenis
                                </option>

                                <option value="income">
                                    Pemasukan
                                </option>

                                <option value="expense">
                                    Pengeluaran
                                </option>

                            </select>

                        </div>


                        {{-- Dari --}}
                        <div>

                            <label class="sr-only">
                                Tanggal mulai
                            </label>

                            <input
                                type="date"
                                x-model="historyStartDate"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200 focus:border-gray-500 focus:ring-gray-500"
                            >

                        </div>


                        {{-- Sampai --}}
                        <div>

                            <label class="sr-only">
                                Tanggal akhir
                            </label>

                            <input
                                type="date"
                                x-model="historyEndDate"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200 focus:border-gray-500 focus:ring-gray-500"
                            >

                        </div>

                    </div>

                </div>


                {{-- Table --}}
                <div class="overflow-auto flex-1">

                    @if ($allTransactions->count() > 0)

                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                            <thead class="sticky top-0 bg-gray-50 dark:bg-gray-900 z-10">

                                <tr>

                                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Tanggal
                                    </th>

                                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Keterangan
                                    </th>

                                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Jenis
                                    </th>

                                    <th class="px-5 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Jumlah
                                    </th>

                                    <th class="px-5 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Aksi
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                                @foreach ($allTransactions as $transaction)

                                    @php
                                        $historyData = [
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
                                        ];
                                    @endphp

                                    <tr
                                        x-data="{
                                            transactionDate: '{{ $transaction->transaction_date->format('Y-m-d') }}',
                                            transactionType: '{{ $transaction->type }}',
                                            transactionDescription: @js(strtolower($transaction->description))
                                        }"

                                        x-show="
                                            (historySearch === '' ||
                                                transactionDescription.includes(historySearch.toLowerCase()))
                                            &&
                                            (historyType === '' ||
                                                transactionType === historyType)
                                            &&
                                            (historyStartDate === '' ||
                                                transactionDate >= historyStartDate)
                                            &&
                                            (historyEndDate === '' ||
                                                transactionDate <= historyEndDate)
                                        "

                                        class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition"
                                    >

                                        {{-- Tanggal --}}
                                        <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                            {{ $transaction->transaction_date->format('d/m/Y') }}
                                        </td>


                                        {{-- Keterangan --}}
                                        <td class="px-5 py-4 text-sm text-gray-800 dark:text-gray-200">
                                            {{ $transaction->description }}
                                        </td>


                                        {{-- Jenis --}}
                                        <td class="px-5 py-4 whitespace-nowrap">

                                            @if ($transaction->type === 'income')

                                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                    Pemasukan
                                                </span>

                                            @else

                                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                                    Pengeluaran
                                                </span>

                                            @endif

                                        </td>


                                        {{-- Jumlah --}}
                                        <td class="px-5 py-4 whitespace-nowrap text-sm text-right font-semibold
                                            {{ $transaction->type === 'income'
                                                ? 'text-green-600 dark:text-green-400'
                                                : 'text-red-600 dark:text-red-400' }}">

                                            {{ $transaction->type === 'income' ? '+' : '-' }}
                                            Rp{{ number_format($transaction->amount, 0, ',', '.') }}

                                        </td>


                                        {{-- Aksi --}}
                                        <td class="px-5 py-4 whitespace-nowrap">

                                            <div class="flex items-center justify-end gap-1">

                                                <button
                                                    type="button"
                                                    @click="openDetail(@js($historyData))"
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200 transition"
                                                    title="Detail"
                                                >
                                                    <svg class="w-4 h-4"
                                                         fill="none"
                                                         stroke="currentColor"
                                                         viewBox="0 0 24 24">
                                                        <path stroke-linecap="round"
                                                              stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round"
                                                              stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                </button>


                                                <button
                                                    type="button"
                                                    @click="openEdit(@js($historyData))"
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-amber-600 hover:bg-amber-50 dark:text-amber-400 dark:hover:bg-amber-900/20 transition"
                                                    title="Edit"
                                                >
                                                    <svg class="w-4 h-4"
                                                         fill="none"
                                                         stroke="currentColor"
                                                         viewBox="0 0 24 24">
                                                        <path stroke-linecap="round"
                                                              stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/>
                                                        <path stroke-linecap="round"
                                                              stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                                    </svg>
                                                </button>


                                                <form
                                                    method="POST"
                                                    action="{{ route('buku-kas.transactions.destroy', $transaction) }}"
                                                    onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20 transition"
                                                        title="Hapus"
                                                    >
                                                        <svg class="w-4 h-4"
                                                             fill="none"
                                                             stroke="currentColor"
                                                             viewBox="0 0 24 24">
                                                            <path stroke-linecap="round"
                                                                  stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-7 0h8"/>
                                                        </svg>
                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    @else

                        <div class="py-12 text-center">

                            <p class="text-gray-500 dark:text-gray-400">
                                Belum ada transaksi.
                            </p>

                        </div>

                    @endif

                </div>


                {{-- Footer --}}
                <div class="px-5 py-3 border-t border-gray-200 dark:border-gray-700 flex items-center justify-between flex-shrink-0">

                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Total {{ $allTransactions->count() }} transaksi
                    </p>

                    <button
                        type="button"
                        @click="resetHistory()"
                        class="px-3 py-2 text-sm font-medium rounded-lg
                            bg-gray-100 text-gray-700
                            hover:bg-gray-200
                            dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                    >
                        Reset
                    </button>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- ALPINE CLOAK --}}
    {{-- ========================================================= --}}

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

</x-app-layout>
