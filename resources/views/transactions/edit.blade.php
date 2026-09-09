<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Transaksi
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <form
                    method="POST"
                    action="{{ route('transactions.update', $transaction) }}"
                    class="space-y-4"
                >

                    @csrf
                    @method('PUT')

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
                                @selected(old('type', $transaction->type) === 'income')
                            >
                                Kas Masuk
                            </option>

                            <option
                                value="expense"
                                @selected(old('type', $transaction->type) === 'expense')
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
                            value="{{ old('transaction_date', $transaction->transaction_date->format('Y-m-d')) }}"
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
                            value="{{ old('description', $transaction->description) }}"
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
                            value="{{ old('amount', $transaction->amount) }}"
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
                            Update
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
