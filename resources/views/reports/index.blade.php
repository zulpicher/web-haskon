<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Laporan Buku Kas
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Form laporan --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">

                <form
                    method="GET"
                    action="{{ route('buku-kas.reports.generate') }}"
                    class="space-y-6"
                    x-data="{
                        reportType: '{{ request('report_type', 'monthly') }}'
                    }"
                >

                    {{-- Jenis laporan --}}
                    <div>
                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2">
                            Jenis Laporan
                        </label>

                        <div class="flex flex-col sm:flex-row gap-4 sm:gap-6">

                            <label class="inline-flex items-center cursor-pointer">
                                <input
                                    type="radio"
                                    name="report_type"
                                    value="monthly"
                                    x-model="reportType"
                                    class="text-blue-600 focus:ring-blue-500"
                                >

                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                    Laporan Bulanan
                                </span>
                            </label>

                            <label class="inline-flex items-center cursor-pointer">
                                <input
                                    type="radio"
                                    name="report_type"
                                    value="custom"
                                    x-model="reportType"
                                    class="text-blue-600 focus:ring-blue-500"
                                >

                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                    Periode Custom
                                </span>
                            </label>

                        </div>
                    </div>


                    {{-- Laporan Bulanan --}}
                    <div
                        x-show="reportType === 'monthly'"
                        x-transition
                    >
                        <label
                            for="month"
                            class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2"
                        >
                            Bulan
                        </label>

                        <input
                            type="month"
                            id="month"
                            name="month"
                            value="{{ request('month', now()->format('Y-m')) }}"
                            :disabled="reportType !== 'monthly'"
                            class="border-gray-300 dark:border-gray-700
                                dark:bg-gray-900 dark:text-gray-300
                                rounded-md shadow-sm
                                focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>


                    {{-- Periode Custom --}}
                    <div
                        x-show="reportType === 'custom'"
                        x-transition
                        class="grid grid-cols-1 md:grid-cols-2 gap-4"
                    >

                        <div>
                            <label
                                for="start_date"
                                class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2"
                            >
                                Tanggal Mulai
                            </label>

                            <input
                                type="date"
                                id="start_date"
                                name="start_date"
                                value="{{ request('start_date') }}"
                                :disabled="reportType !== 'custom'"
                                class="border-gray-300 dark:border-gray-700
                                    dark:bg-gray-900 dark:text-gray-300
                                    rounded-md shadow-sm
                                    focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>

                        <div>
                            <label
                                for="end_date"
                                class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2"
                            >
                                Tanggal Akhir
                            </label>

                            <input
                                type="date"
                                id="end_date"
                                name="end_date"
                                value="{{ request('end_date') }}"
                                :disabled="reportType !== 'custom'"
                                class="border-gray-300 dark:border-gray-700
                                    dark:bg-gray-900 dark:text-gray-300
                                    rounded-md shadow-sm
                                    focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>

                    </div>


                    {{-- Tombol --}}
                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700
                            text-white font-semibold
                            px-4 py-2 rounded-lg transition"
                    >
                        Tampilkan Laporan
                    </button>

                </form>

            </div>


            {{-- Hasil laporan --}}
            @isset($report)

                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">

                    @if ($report['is_negative'])
                        <div class="bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300 p-3 rounded-lg mb-6">
                            Saldo akhir periode negatif.
                        </div>
                    @endif


                    {{-- Ringkasan --}}
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="text-sm text-gray-500 dark:text-gray-300">
                                Saldo Awal
                            </div>

                            <div class="font-bold text-lg text-gray-900 dark:text-white">
                                Rp{{ number_format($report['opening_balance'], 0, ',', '.') }}
                            </div>
                        </div>

                        <div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                            <div class="text-sm text-gray-500 dark:text-gray-300">
                                Kas Masuk
                            </div>

                            <div class="font-bold text-lg text-green-600">
                                Rp{{ number_format($report['total_income'], 0, ',', '.') }}
                            </div>
                        </div>

                        <div class="p-4 bg-red-50 dark:bg-red-900/20 rounded-lg">
                            <div class="text-sm text-gray-500 dark:text-gray-300">
                                Kas Keluar
                            </div>

                            <div class="font-bold text-lg text-red-600">
                                Rp{{ number_format($report['total_expense'], 0, ',', '.') }}
                            </div>
                        </div>

                        <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                            <div class="text-sm text-gray-500 dark:text-gray-300">
                                Saldo Akhir
                            </div>

                            <div class="font-bold text-lg text-blue-600">
                                Rp{{ number_format($report['closing_balance'], 0, ',', '.') }}
                            </div>
                        </div>

                    </div>


                    {{-- Periode --}}
                    <div class="mb-4 text-sm text-gray-600 dark:text-gray-300">
                        Periode:

                        <strong>
                            {{ $report['start_date']->format('d/m/Y') }}
                            -
                            {{ $report['end_date']->format('d/m/Y') }}
                        </strong>
                    </div>


                    {{-- Detail transaksi --}}
                    <div class="overflow-x-auto">

                        <table class="w-full text-sm">

                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700 text-left">

                                    <th class="py-3 px-2">
                                        Tanggal
                                    </th>

                                    <th class="py-3 px-2">
                                        Keterangan
                                    </th>

                                    <th class="py-3 px-2 text-right">
                                        Kas Masuk
                                    </th>

                                    <th class="py-3 px-2 text-right">
                                        Kas Keluar
                                    </th>

                                    <th class="py-3 px-2 text-right">
                                        Saldo
                                    </th>

                                </tr>
                            </thead>

                            <tbody>

                                @forelse ($report['rows'] as $row)

                                    <tr class="border-b border-gray-100 dark:border-gray-700">

                                        <td class="py-3 px-2">
                                            {{ $row['date']->format('d/m/Y') }}
                                        </td>

                                        <td class="py-3 px-2">
                                            {{ $row['description'] }}
                                        </td>

                                        <td class="py-3 px-2 text-right text-green-600">
                                            @if ($row['income'] !== null)
                                                Rp{{ number_format($row['income'], 0, ',', '.') }}
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td class="py-3 px-2 text-right text-red-600">
                                            @if ($row['expense'] !== null)
                                                Rp{{ number_format($row['expense'], 0, ',', '.') }}
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td class="py-3 px-2 text-right font-semibold">
                                            Rp{{ number_format($row['balance'], 0, ',', '.') }}
                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td
                                            colspan="5"
                                            class="py-8 text-center text-gray-500"
                                        >
                                            Tidak ada transaksi pada periode ini.
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>
                {{-- Export PDF --}}
                <div class="mt-6">
                    <a
                        href="{{ route('buku-kas.reports.pdf', request()->query()) }}"
                        class="inline-flex items-center
                            bg-red-600 hover:bg-red-700
                            text-white font-semibold
                            px-4 py-2 rounded-lg transition"
                    >
                        Export PDF
                    </a>
                </div>


            @endisset

        </div>
    </div>

</x-app-layout>
