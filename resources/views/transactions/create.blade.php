<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Transaksi
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <form
                    method="POST"
                    action="{{ route('transactions.store') }}"
                    class="space-y-4"
                >

                    @csrf

                    <div>
                        <label class="block mb-1">
                            Jenis Transaksi
                        </label>

                        <select
                            name="type"
                            class="w-full border rounded p-2"
                        >
                            <option
                                value="income"
                                @selected(old('type') === 'income')
                            >
                                Kas Masuk
                            </option>

                            <option
                                value="expense"
                                @selected(old('type') === 'expense')
                            >
                                Kas Keluar
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1">
                            Tanggal
                        </label>

                        <input
                            type="date"
                            name="transaction_date"
                            value="{{ old('transaction_date') }}"
                            class="w-full border rounded p-2"
                        >
                    </div>

                    <div>
                        <label class="block mb-1">
                            Keterangan
                        </label>

                        <input
                            type="text"
                            name="description"
                            value="{{ old('description') }}"
                            class="w-full border rounded p-2"
                        >
                    </div>

                    <div>
                        <label class="block mb-1">
                            Nominal
                        </label>

                        <input
                            type="number"
                            name="amount"
                            value="{{ old('amount') }}"
                            min="0"
                            step="0.01"
                            class="w-full border rounded p-2"
                        >
                    </div>

                    @if ($errors->any())
                        <div class="text-red-600 text-sm">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="flex gap-2">

                        <button
                            type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded"
                        >
                            Simpan
                        </button>

                        <a
                            href="{{ route('transactions.index') }}"
                            class="bg-gray-200 px-4 py-2 rounded"
                        >
                            Batal
                        </a>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>
