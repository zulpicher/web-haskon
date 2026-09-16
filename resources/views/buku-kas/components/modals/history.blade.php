{{-- ========================================================= --}}
{{-- MODAL RIWAYAT SEMUA TRANSAKSI --}}
{{-- ========================================================= --}}

<div
    x-cloak
    x-show="modal === 'history'"
    x-transition.opacity
    class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-6"
>
    {{-- Overlay --}}
    <div
        class="absolute inset-0 bg-haskon-primary/50"
        @click="closeModal()"
    ></div>

    {{-- Modal --}}
    <div
    x-show="modal === 'history'"
    x-transition
    class="
        relative
        flex
        max-h-[92vh]
        w-full
        max-w-6xl
        flex-col
        overflow-hidden
        rounded-2xl
        bg-white
        shadow-2xl
    "
>

    {{-- ================================================= --}}
    {{-- HEADER --}}
    {{-- ================================================= --}}

    <div
        class="
            flex-shrink-0
            border-b
            border-haskon-border
            px-5
            py-4
        "
    >

        <div class="flex items-center justify-between gap-4">

            <div>
                <h3 class="text-lg font-semibold text-haskon-primary">
                    Riwayat Transaksi
                </h3>

                <p class="mt-1 text-sm text-haskon-muted">
                    Seluruh transaksi pada buku kas.
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
                    flex-shrink-0
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


        {{-- ================================================= --}}
        {{-- FILTER --}}
        {{-- ================================================= --}}

        <div
            class="
                mt-4
                grid
                grid-cols-1
                gap-3
                sm:grid-cols-2
                lg:grid-cols-5
            "
        >

            {{-- Search --}}
            <div class="lg:col-span-2">

                <label class="sr-only">
                    Cari transaksi
                </label>

                <input
                    type="search"
                    x-model="historySearch"
                    placeholder="Cari keterangan..."
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
                >

            </div>


            {{-- Jenis --}}
            <div>

                <label class="sr-only">
                    Jenis transaksi
                </label>

                <select
                    x-model="historyType"
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


            {{-- Sampai --}}
            <div>

                <label class="sr-only">
                    Tanggal akhir
                </label>

                <input
                    type="date"
                    x-model="historyEndDate"
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

    </div>


    {{-- ================================================= --}}
    {{-- TABLE --}}
    {{-- ================================================= --}}

    <div class="flex-1 overflow-auto">

        @if ($allTransactions->count() > 0)

            <table
                class="
                    min-w-full
                    divide-y
                    divide-haskon-border
                "
            >

                {{-- Table Header --}}
                <thead
                    class="
                        sticky
                        top-0
                        z-10
                        bg-zinc-900
                        text-zinc-200
                    "
                >

                    <tr>

                        <th
                            class="
                                px-5
                                py-3
                                text-left
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-zinc-300
                            "
                        >
                            Tanggal
                        </th>

                        <th
                            class="
                                px-5
                                py-3
                                text-left
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-zinc-300
                            "
                        >
                            Keterangan
                        </th>

                        <th
                            class="
                                px-5
                                py-3
                                text-left
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-zinc-300
                            "
                        >
                            Jenis
                        </th>

                        <th
                            class="
                                px-5
                                py-3
                                text-right
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-zinc-300
                            "
                        >
                            Jumlah
                        </th>

                        <th
                            class="
                                px-5
                                py-3
                                text-right
                                text-xs
                                font-bold
                                uppercase
                                tracking-wider
                                text-zinc-300
                            "
                        >
                            Aksi
                        </th>

                    </tr>

                </thead>


                {{-- Table Body --}}
                <tbody
                    class="
                        divide-y
                        divide-haskon-border
                    "
                >

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
                                'amountFormatted' => 'Rp' . number_format(
                                    $transaction->amount,
                                    0,
                                    ',',
                                    '.'
                                ),
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
                                (historySearch === '' || transactionDescription.includes(historySearch.toLowerCase())) &&
                                (historyType === '' || transactionType === historyType) &&
                                (historyStartDate === '' || transactionDate >= historyStartDate) &&
                                (historyEndDate === '' || transactionDate <= historyEndDate)
                            "
                            class="
                                transition
                                hover:bg-haskon-surface
                            "
                        >

                            {{-- Tanggal --}}
                            <td
                                class="
                                    whitespace-nowrap
                                    px-5
                                    py-4
                                    text-sm
                                    text-haskon-muted
                                "
                            >
                                {{ $transaction->transaction_date->format('d/m/Y') }}
                            </td>


                            {{-- Keterangan --}}
                            <td
                                class="
                                    px-5
                                    py-4
                                    text-sm
                                    text-haskon-text
                                "
                            >
                                {{ $transaction->description }}
                            </td>


                            {{-- Jenis --}}
                            <td
                                class="
                                    whitespace-nowrap
                                    px-5
                                    py-4
                                "
                            >

                                @if ($transaction->type === 'income')

                                    <span
                                        class="
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
                                            text-haskon-success
                                        "
                                    >
                                        Pemasukan
                                    </span>

                                @else

                                    <span
                                        class="
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
                                            text-haskon-danger
                                        "
                                    >
                                        Pengeluaran
                                    </span>

                                @endif

                            </td>


                            {{-- Jumlah --}}
                            <td
                                class="
                                    whitespace-nowrap
                                    px-5
                                    py-4
                                    text-right
                                    text-sm
                                    font-semibold
                                    {{ $transaction->type === 'income'
                                        ? 'text-haskon-success'
                                        : 'text-haskon-danger'
                                    }}
                                "
                            >
                                {{ $transaction->type === 'income' ? '+' : '-' }}
                                Rp{{ number_format($transaction->amount, 0, ',', '.') }}
                            </td>


                            {{-- Aksi --}}
                            <td
                                class="
                                    whitespace-nowrap
                                    px-5
                                    py-4
                                "
                            >

                                <div
                                    class="
                                        flex
                                        items-center
                                        justify-end
                                        gap-1
                                    "
                                >

                                    {{-- Detail --}}
                                    <button
                                        type="button"
                                        @click="openDetail(@js($historyData))"
                                        class="
                                            inline-flex
                                            h-8
                                            w-8
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
                                        "
                                        title="Detail"
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
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                            />
                                        </svg>
                                    </button>


                                    {{-- Edit --}}
                                    <button
                                        type="button"
                                        @click="openEdit(@js($historyData))"
                                        class="
                                            inline-flex
                                            h-8
                                            w-8
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
                                        "
                                        title="Edit"
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
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"
                                            />
                                        </svg>
                                    </button>


                                    {{-- Hapus --}}
                                    <button
                                        type="button"
                                        @click="openDelete(@js($historyData))"
                                        class="
                                            inline-flex
                                            h-8
                                            w-8
                                            items-center
                                            justify-center
                                            rounded-lg
                                            bg-rose-50
                                            text-rose-600
                                            border
                                            border-rose-200
                                            transition
                                            hover:bg-rose-600
                                            hover:text-white
                                            focus:outline-none
                                            focus:ring-2
                                            focus:ring-rose-500
                                        "
                                        title="Hapus"
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
                                    </button>

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @else

            {{-- Empty State --}}
            <div class="py-12 text-center">

                <div
                    class="
                        mx-auto
                        flex
                        h-12
                        w-12
                        items-center
                        justify-center
                        rounded-full
                        bg-haskon-surface
                        text-haskon-muted
                    "
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
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v11a2 2 0 01-2 2z"
                        />
                    </svg>
                </div>

                <p class="mt-3 text-sm text-haskon-muted">
                    Belum ada transaksi.
                </p>

            </div>

        @endif

    </div>


    {{-- ================================================= --}}
    {{-- FOOTER --}}
    {{-- ================================================= --}}

    <div
        class="
            flex
            flex-shrink-0
            items-center
            justify-between
            gap-4
            border-t
            border-haskon-border
            px-5
            py-3
        "
    >

        <p class="text-xs text-haskon-muted">
            Total {{ $allTransactions->count() }} transaksi
        </p>


        {{-- Reset --}}
        <button
            type="button"
            @click="resetHistory()"
            class="
                rounded-lg
                border
                border-haskon-border
                bg-white
                px-3
                py-2
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
            Reset
        </button>

    </div>

</div>
```

</div>
