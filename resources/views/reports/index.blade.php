{{-- ========================================================= --}}
{{-- HALAMAN LAPORAN BUKU KAS --}}
{{-- ========================================================= --}}

<x-app-layout>
{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}

<x-slot name="header">

    <div>
        <h2 class="text-xl font-semibold leading-tight text-haskon-primary">
            Laporan Buku Kas
        </h2>

        <p class="mt-1 text-sm text-haskon-muted">
            Buat dan lihat laporan aktivitas keuangan berdasarkan periode.
        </p>
    </div>

</x-slot>


{{-- ========================================================= --}}
{{-- CONTENT --}}
{{-- ========================================================= --}}

<div class="py-6">

    <div class="mx-auto max-w-6xl space-y-6 px-4 sm:px-6 lg:px-8">


        {{-- ================================================= --}}
        {{-- FORM LAPORAN --}}
        {{-- ================================================= --}}

        <div class="haskon-card overflow-hidden">

            {{-- Header Form --}}
            <div
                class="
                    border-b
                    border-haskon-border
                    px-6
                    py-5
                "
            >
                <h3 class="text-lg font-semibold text-haskon-primary">
                    Parameter Laporan
                </h3>

                <p class="mt-1 text-sm text-haskon-muted">
                    Tentukan jenis dan periode laporan yang ingin ditampilkan.
                </p>
            </div>


            {{-- Form --}}
            <form
                method="GET"
                action="{{ route('buku-kas.reports.generate') }}"
                class="p-6"
                x-data="{
                    reportType: '{{ request('report_type', 'monthly') }}'
                }"
            >

                <div class="space-y-6">


                    {{-- ================================================= --}}
                    {{-- JENIS LAPORAN --}}
                    {{-- ================================================= --}}

                    <div>

                        <label
                            class="
                                mb-3
                                block
                                text-sm
                                font-medium
                                text-haskon-text
                            "
                        >
                            Jenis Laporan
                        </label>


                        <div
                            class="
                                flex
                                flex-col
                                gap-3
                                sm:flex-row
                                sm:gap-6
                            "
                        >

                            {{-- Bulanan --}}
                            <label
                                class="
                                    inline-flex
                                    cursor-pointer
                                    items-center
                                    rounded-lg
                                    border
                                    border-haskon-border
                                    px-4
                                    py-3
                                    transition
                                    hover:bg-haskon-surface
                                "
                            >

                                <input
                                    type="radio"
                                    name="report_type"
                                    value="monthly"
                                    x-model="reportType"
                                    class="
                                        border-haskon-border
                                        text-haskon-primary
                                        focus:ring-haskon-accent
                                    "
                                >

                                <span
                                    class="
                                        ml-3
                                        text-sm
                                        font-medium
                                        text-haskon-text
                                    "
                                >
                                    Laporan Bulanan
                                </span>

                            </label>


                            {{-- Custom --}}
                            <label
                                class="
                                    inline-flex
                                    cursor-pointer
                                    items-center
                                    rounded-lg
                                    border
                                    border-haskon-border
                                    px-4
                                    py-3
                                    transition
                                    hover:bg-haskon-surface
                                "
                            >

                                <input
                                    type="radio"
                                    name="report_type"
                                    value="custom"
                                    x-model="reportType"
                                    class="
                                        border-haskon-border
                                        text-haskon-primary
                                        focus:ring-haskon-accent
                                    "
                                >

                                <span
                                    class="
                                        ml-3
                                        text-sm
                                        font-medium
                                        text-haskon-text
                                    "
                                >
                                    Periode Custom
                                </span>

                            </label>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- LAPORAN BULANAN --}}
                    {{-- ================================================= --}}

                    <div
                        x-show="reportType === 'monthly'"
                        x-transition
                    >

                        <label
                            for="month"
                            class="
                                mb-1.5
                                block
                                text-sm
                                font-medium
                                text-haskon-text
                            "
                        >
                            Bulan
                        </label>

                        <input
                            type="month"
                            id="month"
                            name="month"
                            value="{{ request('month', now()->format('Y-m')) }}"
                            :disabled="reportType !== 'monthly'"
                            class="
                                w-full
                                rounded-lg
                                border-haskon-border
                                bg-white
                                text-haskon-text
                                shadow-sm
                                focus:border-haskon-accent
                                focus:ring-haskon-accent
                                sm:max-w-sm
                            "
                        >

                    </div>


                    {{-- ================================================= --}}
                    {{-- PERIODE CUSTOM --}}
                    {{-- ================================================= --}}

                    <div
                        x-show="reportType === 'custom'"
                        x-transition
                        class="
                            grid
                            grid-cols-1
                            gap-4
                            md:grid-cols-2
                        "
                    >

                        {{-- Tanggal Mulai --}}
                        <div>

                            <label
                                for="start_date"
                                class="
                                    mb-1.5
                                    block
                                    text-sm
                                    font-medium
                                    text-haskon-text
                                "
                            >
                                Tanggal Mulai
                            </label>

                            <input
                                type="date"
                                id="start_date"
                                name="start_date"
                                value="{{ request('start_date') }}"
                                :disabled="reportType !== 'custom'"
                                class="
                                    w-full
                                    rounded-lg
                                    border-haskon-border
                                    bg-white
                                    text-haskon-text
                                    shadow-sm
                                    focus:border-haskon-accent
                                    focus:ring-haskon-accent
                                "
                            >

                        </div>


                        {{-- Tanggal Akhir --}}
                        <div>

                            <label
                                for="end_date"
                                class="
                                    mb-1.5
                                    block
                                    text-sm
                                    font-medium
                                    text-haskon-text
                                "
                            >
                                Tanggal Akhir
                            </label>

                            <input
                                type="date"
                                id="end_date"
                                name="end_date"
                                value="{{ request('end_date') }}"
                                :disabled="reportType !== 'custom'"
                                class="
                                    w-full
                                    rounded-lg
                                    border-haskon-border
                                    bg-white
                                    text-haskon-text
                                    shadow-sm
                                    focus:border-haskon-accent
                                    focus:ring-haskon-accent
                                "
                            >

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- ACTION BUTTONS --}}
                    {{-- ================================================= --}}

                    <div
                        class="
                            flex
                            flex-wrap
                            items-center
                            gap-3
                            border-t
                            border-haskon-border
                            pt-5
                        "
                    >

                        {{-- Tampilkan Laporan --}}
                        <button
                            type="submit"
                            class="
                                inline-flex
                                items-center
                                justify-center
                                rounded-lg
                                bg-haskon-primary
                                px-4
                                py-2.5
                                text-sm
                                font-semibold
                                text-haskon-inverted
                                transition
                                hover:bg-haskon-dark
                                focus:outline-none
                                focus:ring-2
                                focus:ring-haskon-accent
                                focus:ring-offset-2
                            "
                        >
                            <svg
                                class="mr-2 h-4 w-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21 21l-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0z"
                                />
                            </svg>

                            Tampilkan Laporan
                        </button>


                        {{-- Kembali --}}
                        <a
                            href="{{ route('buku-kas.dashboard') }}"
                            class="
                                inline-flex
                                items-center
                                justify-center
                                rounded-lg
                                border
                                border-haskon-border
                                bg-white
                                px-4
                                py-2.5
                                text-sm
                                font-semibold
                                text-haskon-text
                                transition
                                hover:bg-haskon-surface
                                focus:outline-none
                                focus:ring-2
                                focus:ring-haskon-accent
                                focus:ring-offset-1
                            "
                        >
                            <svg
                                class="mr-2 h-4 w-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"
                                />
                            </svg>

                            Kembali ke Buku Kas
                        </a>

                    </div>

                </div>

            </form>

        </div>


        {{-- ========================================================= --}}
        {{-- HASIL LAPORAN --}}
        {{-- ========================================================= --}}

        @isset($report)

            <div class="haskon-card overflow-hidden">


                {{-- ================================================= --}}
                {{-- REPORT HEADER --}}
                {{-- ================================================= --}}

                <div
                    class="
                        border-b
                        border-haskon-border
                        px-6
                        py-5
                    "
                >

                    <div
                        class="
                            flex
                            flex-col
                            gap-2
                            sm:flex-row
                            sm:items-center
                            sm:justify-between
                        "
                    >

                        <div>

                            <h3 class="text-lg font-semibold text-haskon-primary">
                                Hasil Laporan
                            </h3>

                            <p class="mt-1 text-sm text-haskon-muted">
                                Ringkasan dan detail transaksi pada periode yang dipilih.
                            </p>

                        </div>


                        {{-- Periode --}}
                        <div
                            class="
                                inline-flex
                                items-center
                                rounded-lg
                                bg-haskon-surface
                                px-3
                                py-2
                                text-sm
                                font-medium
                                text-haskon-text
                            "
                        >
                            {{ $report['start_date']->format('d/m/Y') }}
                            <span class="mx-2 text-haskon-muted">—</span>
                            {{ $report['end_date']->format('d/m/Y') }}
                        </div>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- NEGATIVE BALANCE WARNING --}}
                {{-- ================================================= --}}

                @if ($report['is_negative'])

                    <div
                        class="
                            mx-6
                            mt-6
                            flex
                            items-start
                            gap-3
                            rounded-lg
                            border
                            border-red-200
                            bg-red-50
                            px-4
                            py-3
                            text-red-800
                        "
                    >

                        <svg
                            class="mt-0.5 h-5 w-5 flex-shrink-0"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 9v4m0 4h.01M10.29 3.86l-7.82 14a2 2 0 001.74 3h15.58a2 2 0 001.74-3l-7.82-14a2 2 0 00-3.42 0z"
                            />
                        </svg>

                        <div>

                            <p class="text-sm font-semibold">
                                Saldo akhir periode negatif.
                            </p>

                            <p class="mt-1 text-xs text-red-700">
                                Periksa kembali aktivitas pemasukan dan pengeluaran pada periode ini.
                            </p>

                        </div>

                    </div>

                @endif


                {{-- ================================================= --}}
                {{-- SUMMARY --}}
                {{-- ================================================= --}}

                <div
                    class="
                        grid
                        grid-cols-1
                        gap-4
                        px-6
                        py-6
                        md:grid-cols-2
                        xl:grid-cols-4
                    "
                >

                    {{-- Saldo Awal --}}
                    <div class="haskon-card bg-haskon-surface p-4">

                        <p class="text-sm text-haskon-muted">
                            Saldo Awal
                        </p>

                        <p class="mt-2 text-xl font-bold text-haskon-primary">
                            Rp{{ number_format($report['opening_balance'], 0, ',', '.') }}
                        </p>

                    </div>


                    {{-- Kas Masuk --}}
                    <div class="haskon-card bg-haskon-surface p-4">

                        <p class="text-sm text-haskon-muted">
                            Kas Masuk
                        </p>

                        <p class="mt-2 text-xl font-bold text-haskon-success">
                            Rp{{ number_format($report['total_income'], 0, ',', '.') }}
                        </p>

                    </div>


                    {{-- Kas Keluar --}}
                    <div class="haskon-card bg-haskon-surface p-4">

                        <p class="text-sm text-haskon-muted">
                            Kas Keluar
                        </p>

                        <p class="mt-2 text-xl font-bold text-haskon-danger">
                            Rp{{ number_format($report['total_expense'], 0, ',', '.') }}
                        </p>

                    </div>


                    {{-- Saldo Akhir --}}
                    <div class="relative overflow-hidden haskon-card bg-haskon-surface p-4">

                        <p class="text-sm text-haskon-muted">
                            Saldo Akhir
                        </p>

                        <p
                            class="
                                mt-2
                                text-xl
                                font-bold
                                {{ $report['is_negative']
                                    ? 'text-haskon-danger'
                                    : 'text-haskon-primary'
                                }}
                            "
                        >
                            Rp{{ number_format($report['closing_balance'], 0, ',', '.') }}
                        </p>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- DETAIL TRANSAKSI --}}
                {{-- ================================================= --}}

                <div class="px-6 pb-6">

                    <div
                        class="
                            overflow-hidden
                            rounded-xl
                            border
                            border-haskon-border
                        "
                    >

                        <div class="overflow-x-auto">

                            <table class="min-w-full divide-y divide-haskon-border">

                                {{-- Header --}}
                                <thead class="bg-haskon-surface">

                                    <tr>

                                        <th
                                            class="
                                                whitespace-nowrap
                                                px-4
                                                py-3
                                                text-left
                                                text-xs
                                                font-semibold
                                                uppercase
                                                tracking-wider
                                                text-haskon-muted
                                            "
                                        >
                                            Tanggal
                                        </th>

                                        <th
                                            class="
                                                px-4
                                                py-3
                                                text-left
                                                text-xs
                                                font-semibold
                                                uppercase
                                                tracking-wider
                                                text-haskon-muted
                                            "
                                        >
                                            Keterangan
                                        </th>

                                        <th
                                            class="
                                                whitespace-nowrap
                                                px-4
                                                py-3
                                                text-right
                                                text-xs
                                                font-semibold
                                                uppercase
                                                tracking-wider
                                                text-haskon-muted
                                            "
                                        >
                                            Kas Masuk
                                        </th>

                                        <th
                                            class="
                                                whitespace-nowrap
                                                px-4
                                                py-3
                                                text-right
                                                text-xs
                                                font-semibold
                                                uppercase
                                                tracking-wider
                                                text-haskon-muted
                                            "
                                        >
                                            Kas Keluar
                                        </th>

                                        <th
                                            class="
                                                whitespace-nowrap
                                                px-4
                                                py-3
                                                text-right
                                                text-xs
                                                font-semibold
                                                uppercase
                                                tracking-wider
                                                text-haskon-muted
                                            "
                                        >
                                            Saldo
                                        </th>

                                    </tr>

                                </thead>


                                {{-- Body --}}
                                <tbody
                                    class="
                                        divide-y
                                        divide-haskon-border
                                        bg-white
                                    "
                                >

                                    @forelse ($report['rows'] as $row)

                                        <tr class="transition hover:bg-haskon-surface">

                                            {{-- Tanggal --}}
                                            <td
                                                class="
                                                    whitespace-nowrap
                                                    px-4
                                                    py-3
                                                    text-sm
                                                    text-haskon-muted
                                                "
                                            >
                                                {{ $row['date']->format('d/m/Y') }}
                                            </td>


                                            {{-- Keterangan --}}
                                            <td
                                                class="
                                                    px-4
                                                    py-3
                                                    text-sm
                                                    text-haskon-text
                                                "
                                            >
                                                {{ $row['description'] }}
                                            </td>


                                            {{-- Kas Masuk --}}
                                            <td
                                                class="
                                                    whitespace-nowrap
                                                    px-4
                                                    py-3
                                                    text-right
                                                    text-sm
                                                    font-medium
                                                    text-haskon-success
                                                "
                                            >
                                                @if ($row['income'] !== null)
                                                    Rp{{ number_format($row['income'], 0, ',', '.') }}
                                                @else
                                                    <span class="text-haskon-muted">-</span>
                                                @endif
                                            </td>


                                            {{-- Kas Keluar --}}
                                            <td
                                                class="
                                                    whitespace-nowrap
                                                    px-4
                                                    py-3
                                                    text-right
                                                    text-sm
                                                    font-medium
                                                    text-haskon-danger
                                                "
                                            >
                                                @if ($row['expense'] !== null)
                                                    Rp{{ number_format($row['expense'], 0, ',', '.') }}
                                                @else
                                                    <span class="text-haskon-muted">-</span>
                                                @endif
                                            </td>


                                            {{-- Saldo --}}
                                            <td
                                                class="
                                                    whitespace-nowrap
                                                    px-4
                                                    py-3
                                                    text-right
                                                    text-sm
                                                    font-semibold
                                                    text-haskon-primary
                                                "
                                            >
                                                Rp{{ number_format($row['balance'], 0, ',', '.') }}
                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td
                                                colspan="5"
                                                class="
                                                    px-4
                                                    py-10
                                                    text-center
                                                    text-sm
                                                    text-haskon-muted
                                                "
                                            >
                                                Tidak ada transaksi pada periode ini.
                                            </td>

                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- EXPORT --}}
                {{-- ================================================= --}}

                <div
                    class="
                        flex
                        flex-wrap
                        items-center
                        gap-3
                        border-t
                        border-haskon-border
                        px-6
                        py-5
                    "
                >

                    <span class="mr-2 text-sm font-medium text-haskon-muted">
                        Export laporan:
                    </span>


                    {{-- PDF --}}
                    <a
                        href="{{ route('buku-kas.reports.pdf', request()->query()) }}"
                        class="
                            inline-flex
                            items-center
                            justify-center
                            rounded-lg
                            border
                            border-haskon-border
                            bg-white
                            px-4
                            py-2.5
                            text-sm
                            font-semibold
                            text-haskon-text
                            transition
                            hover:bg-haskon-surface
                            focus:outline-none
                            focus:ring-2
                            focus:ring-haskon-accent
                            focus:ring-offset-1
                        "
                    >
                        <svg
                            class="mr-2 h-4 w-4 text-haskon-danger"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M7 18h10M7 14h10M9 10h6M5 4h10l4 4v12H5V4z"
                            />
                        </svg>

                        Export PDF
                    </a>


                    {{-- Excel --}}
                    <a
                        href="{{ route('buku-kas.reports.excel', request()->query()) }}"
                        class="
                            inline-flex
                            items-center
                            justify-center
                            rounded-lg
                            border
                            border-haskon-border
                            bg-white
                            px-4
                            py-2.5
                            text-sm
                            font-semibold
                            text-haskon-text
                            transition
                            hover:bg-haskon-surface
                            focus:outline-none
                            focus:ring-2
                            focus:ring-haskon-accent
                            focus:ring-offset-1
                        "
                    >
                        <svg
                            class="mr-2 h-4 w-4 text-haskon-success"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 4h16v16H4zM8 8l3 3m0 0l3-3m-3 3v6"
                            />
                        </svg>

                        Export Excel
                    </a>

                </div>

            </div>

        @endisset

    </div>

</div>

</x-app-layout>
