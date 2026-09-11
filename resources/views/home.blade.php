<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Beranda
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- MODUL --}}
            <div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    {{-- BUKU KAS --}}
                    <a
                        href="{{ route('buku-kas.dashboard') }}"
                        class="block bg-white dark:bg-gray-800 shadow rounded-xl p-6
                               hover:shadow-lg transition"
                    >

                        <div class="flex items-center justify-between mb-4">

                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                Buku Kas
                            </h4>

                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                Buka →
                            </span>

                        </div>

                        <div class="mb-4">

                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Saldo Saat Ini
                            </p>

                            <p class="text-2xl font-bold mt-1
                                {{ $bukuKasSummary['balance'] < 0
                                    ? 'text-red-600'
                                    : 'text-gray-900 dark:text-white' }}">

                                Rp{{ number_format(
                                    $bukuKasSummary['balance'],
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </p>

                        </div>


                        <div class="grid grid-cols-2 gap-4">

                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Pemasukan Bulan Ini
                                </p>

                                <p class="text-sm font-semibold text-green-600 mt-1">
                                    Rp{{ number_format(
                                        $bukuKasSummary['income'],
                                        0,
                                        ',',
                                        '.'
                                    ) }}
                                </p>
                            </div>


                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Pengeluaran Bulan Ini
                                </p>

                                <p class="text-sm font-semibold text-red-600 mt-1">
                                    Rp{{ number_format(
                                        $bukuKasSummary['expense'],
                                        0,
                                        ',',
                                        '.'
                                    ) }}
                                </p>
                            </div>

                        </div>

                    </a>


                    {{-- MANAJEMEN TASK --}}
                    <div
                        class="bg-gray-100 dark:bg-gray-700
                               shadow-inner rounded-xl p-6
                               flex flex-col justify-center
                               text-gray-400 dark:text-gray-500"
                    >

                        <h4 class="text-lg font-semibold">
                            next fitur
                        </h4>

                        <p class="text-sm mt-2">
                            tes 1234567890
                        </p>

                    </div>


                    {{-- ABSENSI --}}
                    <div
                        class="bg-gray-100 dark:bg-gray-700
                               shadow-inner rounded-xl p-6
                               flex flex-col justify-center
                               text-gray-400 dark:text-gray-500"
                    >

                        <h4 class="text-lg font-semibold">
                            next fitur
                        </h4>

                        <p class="text-sm mt-2">
                            tes0987654321
                        </p>

                    </div>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>
