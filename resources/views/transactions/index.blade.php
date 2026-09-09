<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Transaksi
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-4">
                        <h1 class="text-xl font-semibold">
                            Daftar Transaksi
                        </h1>

                        <a
                            href="{{ route('transactions.create') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded"
                        >
                            + Tambah
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form
                        method="GET"
                        class="flex flex-wrap gap-2 mb-4"
                    >

                        <select
                            name="type"
                            class="border rounded p-2"
                        >
                            <option value="">
                                Semua Jenis
                            </option>

                            <option
                                value="income"
                                @selected(request('type') === 'income')
                            >
                                Kas Masuk
                            </option>

                            <option
                                value="expense"
                                @selected(request('type') === 'expense')
                            >
                                Kas Keluar
                            </option>
                        </select>

                        <input
                            type="date"
                            name="start_date"
                            value="{{ request('start_date') }}"
                            class="border rounded p-2"
                        >

                        <input
                            type="date"
                            name="end_date"
                            value="{{ request('end_date') }}"
                            class="border rounded p-2"
                        >

                        <input
                            type="text"
                            name="search"
                            placeholder="Cari keterangan"
                            value="{{ request('search') }}"
                            class="border rounded p-2"
                        >

                        <button
                            type="submit"
                            class="bg-gray-200 px-3 py-2 rounded"
                        >
                            Filter
                        </button>

                    </form>

                    <div class="overflow-x-auto">

                        <table class="w-full text-sm border-collapse">

                            <thead>
                                <tr class="text-left border-b">
                                    <th class="py-2">No</th>
                                    <th>Tanggal</th>
                                    <th>Jenis</th>
                                    <th>Keterangan</th>
                                    <th>Nominal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse ($transactions as $i => $t)

                                    <tr class="border-b">

                                        <td class="py-2">
                                            {{ $transactions->firstItem() + $i }}
                                        </td>

                                        <td>
                                            {{ $t->transaction_date->format('d/m/Y') }}
                                        </td>

                                        <td>
                                            {{ $t->type === 'income'
                                                ? 'Kas Masuk'
                                                : 'Kas Keluar' }}
                                        </td>

                                        <td>
                                            {{ $t->description }}
                                        </td>

                                        <td>
                                            Rp{{ number_format($t->amount, 0, ',', '.') }}
                                        </td>

                                        <td class="space-x-2">

                                            <a
                                                href="{{ route('transactions.show', $t) }}"
                                                class="text-gray-600"
                                            >
                                                Detail
                                            </a>

                                            <a
                                                href="{{ route('transactions.edit', $t) }}"
                                                class="text-blue-600"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                method="POST"
                                                action="{{ route('transactions.destroy', $t) }}"
                                                class="inline"
                                                onsubmit="return confirm('Hapus transaksi ini?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="text-red-600"
                                                >
                                                    Hapus
                                                </button>
                                            </form>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td
                                            colspan="6"
                                            class="text-center py-6 text-gray-500"
                                        >
                                            Belum ada transaksi.
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                    <div class="mt-4">
                        {{ $transactions->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>

</x-app-layout>
