{{-- ========================================================= --}}
{{-- MODAL TAMBAH TRANSAKSI --}}
{{-- ========================================================= --}}

<div
    x-cloak
    x-show="modal === 'add'"
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
        x-show="modal === 'add'"
        x-transition
        class="relative w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl"
    >

        {{-- Header --}}
        <div class="flex items-center justify-between border-b border-haskon-border px-6 py-4">

            <div>
                <h3 class="text-lg font-semibold text-haskon-primary">
                    Tambah Transaksi
                </h3>

                <p class="mt-1 text-sm text-haskon-muted">
                    Tambahkan pemasukan atau pengeluaran.
                </p>
            </div>

            {{-- Close --}}
            <button
                type="button"
                @click="closeModal()"
                class="
                    inline-flex h-9 w-9
                    items-center justify-center
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


        {{-- Form --}}
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
                        class="mb-1.5 block text-sm font-medium text-haskon-text"
                    >
                        Tanggal
                    </label>

                    <input
                        type="date"
                        name="transaction_date"
                        id="add_transaction_date"
                        value="{{ now()->format('Y-m-d') }}"
                        required
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


                {{-- Jenis --}}
                <div>
                    <label
                        for="add_type"
                        class="mb-1.5 block text-sm font-medium text-haskon-text"
                    >
                        Jenis Transaksi
                    </label>

                    <select
                        name="type"
                        id="add_type"
                        required
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
                        class="mb-1.5 block text-sm font-medium text-haskon-text"
                    >
                        Keterangan
                    </label>

                    <textarea
                        name="description"
                        id="add_description"
                        rows="3"
                        required
                        placeholder="Contoh: Pembelian ATK"
                        class="
                            w-full
                            rounded-lg
                            border-haskon-border
                            bg-white
                            text-haskon-text
                            shadow-sm
                            placeholder:text-haskon-muted
                            focus:border-haskon-accent
                            focus:ring-haskon-accent
                        "
                    ></textarea>
                </div>


                {{-- Jumlah --}}
                <div>
                    <label
                        for="add_amount"
                        class="mb-1.5 block text-sm font-medium text-haskon-text"
                    >
                        Jumlah
                    </label>

                    <div class="relative">

                        <span
                            class="
                                absolute
                                inset-y-0
                                left-0
                                flex
                                items-center
                                pl-3
                                text-sm
                                font-medium
                                text-haskon-muted
                            "
                        >
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
                            class="
                                w-full
                                rounded-lg
                                border-haskon-border
                                bg-white
                                pl-10
                                text-haskon-text
                                shadow-sm
                                placeholder:text-haskon-muted
                                focus:border-haskon-accent
                                focus:ring-haskon-accent
                            "
                        >

                    </div>
                </div>

            </div>


            {{-- Footer --}}
            <div class="mt-6 flex justify-end gap-2 border-t border-haskon-border pt-5">

                {{-- Batal --}}
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
                    Batal
                </button>


                {{-- Simpan --}}
                <button
                    type="submit"
                    class="
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
                    Simpan Transaksi
                </button>

            </div>

        </form>

    </div>
</div>
