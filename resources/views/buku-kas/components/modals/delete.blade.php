{{-- ========================================================= --}}
{{-- MODAL KONFIRMASI HAPUS TRANSAKSI --}}
{{-- ========================================================= --}}

<div
    x-cloak
    x-show="modal === 'delete'"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    role="dialog"
    aria-modal="true"
>
    {{-- Backdrop --}}
    <div
        class="fixed inset-0 bg-zinc-950/60 backdrop-blur-sm"
        @click="closeModal()"
        aria-hidden="true"
    ></div>

    {{-- Modal Box --}}
    <div
        x-show="modal === 'delete'"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="relative z-10 w-full max-w-md overflow-hidden rounded-2xl border border-zinc-200 bg-white p-6 shadow-2xl"
        @keydown.escape.window="closeModal()"
    >
        {{-- Tombol Close --}}
        <button
            type="button"
            @click="closeModal()"
            class="absolute right-4 top-4 inline-flex h-8 w-8 items-center justify-center rounded-lg text-zinc-400 transition hover:bg-zinc-100 hover:text-zinc-600"
        >
            <svg
                class="h-4 w-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"
                />
            </svg>
        </button>

        <div class="flex items-start gap-4">

            {{-- Icon --}}
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border border-rose-100 bg-rose-50 text-rose-600">

                <svg
                    class="h-6 w-6"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-7 0h8"
                    />
                </svg>

            </div>

            <div class="flex-1">

                <h3 class="text-lg font-bold text-zinc-900">
                    Hapus Transaksi?
                </h3>

                <p class="mt-1 text-xs leading-relaxed text-zinc-500">
                    Data transaksi ini akan dihapus dari sistem pembukuan kas Haskon.
                    Tindakan ini tidak dapat dibatalkan.
                </p>

            </div>

        </div>


        {{-- Preview Transaksi --}}
        <div class="mt-4 rounded-xl border border-zinc-200 bg-zinc-50 p-3.5">

            <div class="mb-1 flex items-center justify-between text-xs text-zinc-500">

                <span
                    class="font-medium"
                    x-text="deleteDateFormatted"
                ></span>

                <span
                    class="rounded px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wider"
                    :class="deleteType === 'income'
                        ? 'bg-emerald-100 text-emerald-800'
                        : 'bg-rose-100 text-rose-800'"
                    x-text="deleteType === 'income'
                        ? 'Pemasukan'
                        : 'Pengeluaran'"
                ></span>

            </div>


            <div
                class="truncate text-sm font-semibold text-zinc-900"
                x-text="deleteDescription"
            ></div>


            <div
                class="mt-1 text-base font-extrabold text-zinc-900"
                x-text="deleteAmountFormatted"
            ></div>

        </div>


        {{-- Action --}}
        <form
            :action="deleteAction"
            method="POST"
            class="mt-6 flex items-center justify-end gap-3"
        >
            @csrf
            @method('DELETE')

            <button
                type="button"
                @click="closeModal()"
                class="inline-flex items-center justify-center rounded-xl border border-zinc-300 bg-white px-4 py-2.5 text-xs font-semibold text-zinc-700 transition hover:bg-zinc-50 focus:outline-none focus:ring-2 focus:ring-zinc-900 focus:ring-offset-2"
            >
                Batal
            </button>


            <button
                type="submit"
                class="inline-flex cursor-pointer items-center justify-center gap-1.5 rounded-xl bg-rose-600 px-4 py-2.5 text-xs font-semibold text-white shadow-sm transition hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2"
            >
                <svg
                    class="h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-7 0h8"
                    />
                </svg>

                Ya, Hapus Sekarang
            </button>

        </form>

    </div>
</div>
