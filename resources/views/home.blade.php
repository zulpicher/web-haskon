<x-app-layout>

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}
    <x-slot name="header">
        <div>

            <h1 class="mt-1 text-2xl font-bold text-haskon-accent">
                Beranda
            </h1>
            <p class="text-sm font-medium text-haskon-primary">
                  Selamat datang kembali, {{ Auth::user()->name }}
            </p>

        </div>
    </x-slot>


    {{-- ========================================================= --}}
    {{-- CONTENT --}}
    {{-- ========================================================= --}}
    <div class="py-8">

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
                    class="group block haskon-card overflow-hidden transition duration-200 hover:-translate-y-0.5 hover:shadow-md"
                >

                    <div class="p-6">
                        {{-- Title --}}
                        <div class="flex items-start justify-between gap-4">

                            <div>
                                <h3 class="text-lg font-bold text-haskon-primary">
                                    Buku Kas
                                </h3>

                                <p class="mt-1 text-sm text-haskon-muted">
                                    Kelola pemasukan, pengeluaran, dan kondisi kas.
                                </p>
                            </div>

                            <svg
                                class="w-5 h-5 flex-shrink-0 text-haskon-muted group-hover:text-haskon-accent group-hover:translate-x-1 transition"
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


                        {{-- Summary --}}
                        <div class="mt-6 pt-5 border-t border-haskon-border">

                            <p class="text-xs font-medium uppercase tracking-wide text-haskon-muted">
                                Saldo saat ini
                            </p>

                            <p class="mt-1 text-2xl font-bold text-haskon-primary">
                                Rp {{ number_format($bukuKasSummary['balance'], 0, ',', '.') }}
                            </p>

                            <div class="mt-4 flex items-center gap-4 text-xs">

                                <span class="text-haskon-success">
                                    Masuk:
                                    <strong>
                                        Rp {{ number_format($bukuKasSummary['income'], 0, ',', '.') }}
                                    </strong>
                                </span>

                                <span class="text-haskon-danger">
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
                <div class="haskon-card overflow-hidden">

                    <div class="p-6">

                        <h3 class="text-lg font-bold text-haskon-primary">
                            Task Management
                        </h3>

                        <p class="mt-1 text-sm text-haskon-muted">
                            Kelola pekerjaan, tugas, dan aktivitas tim.
                        </p>

                        <div class="mt-6 pt-5 border-t border-haskon-border">
                            <span
                                class="
                                    inline-flex items-center
                                    px-2.5 py-1
                                    rounded-full
                                    text-xs font-semibold
                                    bg-haskon-surface
                                    text-haskon-muted
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
                <div class="haskon-card overflow-hidden">

                    <div class="p-6">

                        <h3 class="text-lg font-bold text-haskon-primary">
                            Absensi
                        </h3>

                        <p class="mt-1 text-sm text-haskon-muted">
                            Kelola kehadiran dan aktivitas karyawan.
                        </p>

                        <div class="mt-6 pt-5 border-t border-haskon-border">
                            <span
                                class="
                                    inline-flex items-center
                                    px-2.5 py-1
                                    rounded-full
                                    text-xs font-semibold
                                    bg-haskon-surface
                                    text-haskon-muted
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
                <div class="haskon-card overflow-hidden">

                    <div class="p-6">

                        <h3 class="text-lg font-bold text-haskon-primary">
                            Inventory
                        </h3>

                        <p class="mt-1 text-sm text-haskon-muted">
                            Kelola stok, aset, dan inventaris perusahaan.
                        </p>

                        <div class="mt-6 pt-5 border-t border-haskon-border">
                            <span
                                class="
                                    inline-flex items-center
                                    px-2.5 py-1
                                    rounded-full
                                    text-xs font-semibold
                                    bg-haskon-surface
                                    text-haskon-muted
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
