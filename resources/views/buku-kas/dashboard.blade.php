{{-- resources\views\buku-kas\dashboard.blade.php --}}
<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-black leading-tight">
                    Buku Kas
                </h2>
                <p class="text-sm text-gray-500 dark:text-black mt-1">
                    Kelola kondisi dan aktivitas keuangan
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                {{-- Tambah Transaksi --}}
                <button
                    type="button"
                    onclick="window.dispatchEvent(new CustomEvent('open-add-modal'))"
                    class="inline-flex items-center justify-center px-4 py-2.5 bg-green-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Transaksi
                </button>

                {{-- ke reports --}}
                <a
                    href="{{ route('buku-kas.reports.index') }}"
                    class="inline-flex items-center justify-center px-4 py-2.5 bg-yellow-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6m3 6V7m3 10v-4m4 4H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2z"/>
                    </svg>
                    Rekap
                </a>

                {{-- Riwayat --}}
                <button
                    type="button"
                    onclick="window.dispatchEvent(new CustomEvent('open-history-modal'))"
                    class="inline-flex items-center justify-center px-4 py-2.5 bg-gray-700 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition dark:bg-gray-600 dark:hover:bg-gray-500"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
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
        x-data="bukuKas()"
        data-transaction-url="{{ url('/buku-kas/transactions') }}"
        @open-add-modal.window="openAdd()"
        @open-history-modal.window="openHistory()"
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M10.29 3.86l-7.82 14a2 2 0 001.74 3h15.58a2 2 0 001.74-3l-7.82-14a2 2 0 00-3.42 0z"/>
                        </svg>
                        <div>
                            <p class="font-semibold">Peringatan Saldo</p>
                            <p class="text-sm mt-1">Saldo kas saat ini berada dalam kondisi negatif.</p>
                        </div>
                    </div>
                @endif

                {{-- ================================================= --}}
                {{-- MEMANGGIL KOMPONEN UTAMA --}}
                {{-- ================================================= --}}

                {{-- Panggil Summary --}}
                @include('buku-kas.components.summary')

                <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2">
                        {{-- Panggil Recent Transactions --}}
                        @include('buku-kas.components.recent-transactions')
                    </div>
                    <div>
                        {{-- Panggil Financial Activity --}}
                        @include('buku-kas.components.financial-activity')
                    </div>
                </div>

            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- MEMANGGIL KOMPONEN MODAL --}}
        {{-- ========================================================= --}}

        @include('buku-kas.components.modals.add')
        @include('buku-kas.components.modals.edit')
        @include('buku-kas.components.modals.detail')
        @include('buku-kas.components.modals.history')

    </div>

</x-app-layout>
