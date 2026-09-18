<x-app-layout>

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 tracking-tight">
                    Beranda
                </h1>
                <p class="mt-0.5 text-sm font-medium text-zinc-500">
                    Selamat datang kembali, <span class="text-zinc-800 font-semibold">{{ Auth::user()->name }}</span>
                </p>
            </div>

            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-zinc-900 text-white shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Sistem Aktif
                </span>
            </div>
        </div>
    </x-slot>


    {{-- ========================================================= --}}
    {{-- CONTENT --}}
    {{-- ========================================================= --}}
    <div class="py-4">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ================================================= --}}
            {{-- MODULES --}}
            {{-- ================================================= --}}
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">


                {{-- ================================================= --}}
                {{-- BUKU KAS --}}
                {{-- ================================================= --}}
                <a
                    href="{{ route('buku-kas.dashboard') }}"
                    class="group block haskon-card border border-zinc-200 hover:border-zinc-900 transition duration-200 hover:-translate-y-1 hover:shadow-lg bg-white overflow-hidden relative"
                >
                    <div class="h-1 bg-zinc-900 w-full"></div>

                    <div class="p-6">
                        {{-- Title & Icon --}}
                        <div class="flex items-start justify-between gap-4">

                            <div class="flex items-start gap-4">
                                {{-- Dark Icon Badge --}}
                                <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-zinc-900 text-amber-400 flex items-center justify-center shadow-xs border border-zinc-800">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>

                                <div>
                                    <h3 class="text-lg font-bold text-zinc-900 group-hover:text-zinc-950 transition">
                                        Buku Kas
                                    </h3>

                                    <p class="mt-0.5 text-sm text-zinc-500">
                                        Kelola pemasukan, pengeluaran, dan kondisi kas.
                                    </p>
                                </div>
                            </div>

                            <div class="w-8 h-8 rounded-lg bg-zinc-100 flex items-center justify-center text-zinc-400 group-hover:bg-zinc-900 group-hover:text-white transition">
                                <svg
                                    class="w-4 h-4 group-hover:translate-x-0.5 transition"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 5l7 7-7 7"
                                    />
                                </svg>
                            </div>

                        </div>


                        {{-- Summary Container --}}
                        <div class="mt-6 p-4 rounded-xl bg-zinc-50 border border-zinc-100">

                            <p class="text-xs font-semibold uppercase tracking-wider text-zinc-500">
                                Saldo saat ini
                            </p>

                            <p class="mt-1 text-2xl font-black text-zinc-900">
                                Rp {{ number_format($bukuKasSummary['balance'], 0, ',', '.') }}
                            </p>

                            <div class="mt-3 pt-3 border-t border-zinc-200/80 flex items-center justify-between text-xs">

                                <span class="font-medium text-emerald-700 flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    Masuk:
                                    <strong>
                                        Rp {{ number_format($bukuKasSummary['income'], 0, ',', '.') }}
                                    </strong>
                                </span>

                                <span class="font-medium text-rose-700 flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                    Keluar:
                                    <strong>
                                        Rp {{ number_format($bukuKasSummary['expense'], 0, ',', '.') }}
                                    </strong>
                                </span>

                            </div>

                        </div>

                    </div>

                </a>


                {{-- ================================================= --}}
                {{-- TASK MANAGEMENT --}}
                {{-- ================================================= --}}
                <div class="haskon-card border border-zinc-200 bg-white overflow-hidden relative">

                    <div class="p-6">

                        <div class="flex items-start gap-4">
                            {{-- Dark Icon Badge --}}
                            <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-zinc-900 text-zinc-300 flex items-center justify-center shadow-xs border border-zinc-800">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                            </div>

                            <div>
                                <h3 class="text-lg font-bold text-zinc-900">
                                    Task Management
                                </h3>

                                <p class="mt-0.5 text-sm text-zinc-500">
                                    Kelola pekerjaan, tugas, dan aktivitas tim.
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 pt-5 border-t border-zinc-100 flex items-center justify-between">
                            <span class="text-xs text-zinc-400">Status Modul</span>
                            <span
                                class="
                                    inline-flex items-center
                                    px-3 py-1
                                    rounded-full
                                    text-xs font-semibold
                                    bg-zinc-100
                                    text-zinc-600
                                    border border-zinc-200
                                "
                            >
                                Segera hadir
                            </span>
                        </div>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- ABSENSI --}}
                {{-- ================================================= --}}
                <div class="haskon-card border border-zinc-200 bg-white overflow-hidden relative">

                    <div class="p-6">

                        <div class="flex items-start gap-4">
                            {{-- Dark Icon Badge --}}
                            <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-zinc-900 text-zinc-300 flex items-center justify-center shadow-xs border border-zinc-800">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>

                            <div>
                                <h3 class="text-lg font-bold text-zinc-900">
                                    tesdlu
                                </h3>

                                <p class="mt-0.5 text-sm text-zinc-500">
                                    tes0987asdasd.
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 pt-5 border-t border-zinc-100 flex items-center justify-between">
                            <span class="text-xs text-zinc-400">Status Modul</span>
                            <span
                                class="
                                    inline-flex items-center
                                    px-3 py-1
                                    rounded-full
                                    text-xs font-semibold
                                    bg-zinc-100
                                    text-zinc-600
                                    border border-zinc-200
                                "
                            >
                                Segera hadir
                            </span>
                        </div>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- INVENTORY --}}
                {{-- ================================================= --}}
                <div class="haskon-card border border-zinc-200 bg-white overflow-hidden relative">

                    <div class="p-6">

                        <div class="flex items-start gap-4">
                            {{-- Dark Icon Badge --}}
                            <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-zinc-900 text-zinc-300 flex items-center justify-center shadow-xs border border-zinc-800">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>

                            <div>
                                <h3 class="text-lg font-bold text-zinc-900">
                                    tes123
                                </h3>

                                <p class="mt-0.5 text-sm text-zinc-500">
                                    tes12345.
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 pt-5 border-t border-zinc-100 flex items-center justify-between">
                            <span class="text-xs text-zinc-400">Status Modul</span>
                            <span
                                class="
                                    inline-flex items-center
                                    px-3 py-1
                                    rounded-full
                                    text-xs font-semibold
                                    bg-zinc-100
                                    text-zinc-600
                                    border border-zinc-200
                                "
                            >
                                Segera hadir
                            </span>
                        </div>

                    </div>

                </div>


            </div>

        </div>

    </div>

</x-app-layout>
