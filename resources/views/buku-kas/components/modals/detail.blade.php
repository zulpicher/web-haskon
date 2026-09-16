{{-- ========================================================= --}}
{{-- MODAL DETAIL TRANSAKSI --}}
{{-- ========================================================= --}}

<div
    x-cloak
    x-show="modal === 'detail'"
    x-transition.opacity
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
>
    {{-- Overlay --}}
    <div
        class="absolute inset-0 bg-haskon-primary/50"
        @click="closeModal()"
    ></div>

    {{-- Modal --}}
    <div
        x-show="modal === 'detail'"
    x-transition
    class="
        relative
        w-full
        max-w-lg
        overflow-hidden
        rounded-2xl
        bg-white
        shadow-2xl
    "
>

    {{-- Header --}}
    <div
        class="
            flex
            items-center
            justify-between
            border-b
            border-haskon-border
            px-6
            py-4
        "
    >

        <div>
            <h3 class="text-lg font-semibold text-haskon-primary">
                Detail Transaksi
            </h3>

            <p class="mt-1 text-sm text-haskon-muted">
                Informasi lengkap transaksi.
            </p>
        </div>


        {{-- Close --}}
        <button
            type="button"
            @click="closeModal()"
            class="
                inline-flex
                h-9
                w-9
                items-center
                justify-center
                rounded-lg
                text-haskon-muted
                transition
                hover:bg-haskon-surface
                hover:text-haskon-primary
                focus:outline-none
                focus:ring-2
                focus:ring-haskon-accent
                focus:ring-offset-1
            "
            aria-label="Tutup modal"
        >
            <svg
                class="h-5 w-5"
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

    </div>


    {{-- Content --}}
    <div class="p-6">

        <div class="space-y-5">

            {{-- Tanggal --}}
            <div>
                <p
                    class="
                        text-xs
                        font-medium
                        uppercase
                        tracking-wide
                        text-haskon-muted
                    "
                >
                    Tanggal
                </p>

                <p
                    class="
                        mt-1.5
                        text-sm
                        font-medium
                        text-haskon-primary
                    "
                    x-text="detail.dateFormatted"
                ></p>
            </div>


            {{-- Jenis --}}
            <div>
                <p
                    class="
                        text-xs
                        font-medium
                        uppercase
                        tracking-wide
                        text-haskon-muted
                    "
                >
                    Jenis
                </p>

                <span
                    class="
                        mt-1.5
                        inline-flex
                        items-center
                        rounded-full
                        border
                        border-haskon-border
                        bg-haskon-surface
                        px-2.5
                        py-1
                        text-xs
                        font-semibold
                    "
                    :class="
                        detail.type === 'income'
                            ? 'text-haskon-success'
                            : 'text-haskon-danger'
                    "
                    x-text="detail.typeLabel"
                ></span>
            </div>


            {{-- Keterangan --}}
            <div>
                <p
                    class="
                        text-xs
                        font-medium
                        uppercase
                        tracking-wide
                        text-haskon-muted
                    "
                >
                    Keterangan
                </p>

                <p
                    class="
                        mt-1.5
                        whitespace-pre-line
                        text-sm
                        leading-relaxed
                        text-haskon-text
                    "
                    x-text="detail.description"
                ></p>
            </div>


            {{-- Jumlah --}}
            <div>

                <p
                    class="
                        text-xs
                        font-medium
                        uppercase
                        tracking-wide
                        text-haskon-muted
                    "
                >
                    Jumlah
                </p>

                <p
                    class="
                        mt-1.5
                        text-2xl
                        font-bold
                    "
                    :class="
                        detail.type === 'income'
                            ? 'text-haskon-success'
                            : 'text-haskon-danger'
                    "
                >
                    <span
                        x-text="detail.type === 'income' ? '+' : '-'"
                    ></span>

                    <span
                        x-text="detail.amountFormatted"
                    ></span>
                </p>

            </div>


            {{-- Timestamp --}}
            <div
                class="
                    border-t
                    border-haskon-border
                    pt-5
                "
            >

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                    {{-- Dibuat --}}
                    <div>
                        <p class="text-xs text-haskon-muted">
                            Dibuat
                        </p>

                        <p
                            class="
                                mt-1
                                text-sm
                                text-haskon-text
                            "
                            x-text="detail.created"
                        ></p>
                    </div>


                    {{-- Diperbarui --}}
                    <div>
                        <p class="text-xs text-haskon-muted">
                            Diperbarui
                        </p>

                        <p
                            class="
                                mt-1
                                text-sm
                                text-haskon-text
                            "
                            x-text="detail.updated"
                        ></p>
                    </div>

                </div>

            </div>

        </div>


        {{-- Footer --}}
        <div
            class="
                mt-6
                flex
                justify-end
                border-t
                border-haskon-border
                pt-5
            "
        >

            <button
                type="button"
                @click="closeModal()"
                class="
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
                Tutup
            </button>

        </div>

    </div>

</div>
```

</div>
