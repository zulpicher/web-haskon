<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Transaksi
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <div class="space-y-4">

                    <div>
                        <span class="font-semibold">
                            Tanggal:
                        </span>

                        {{ $transaction->transaction_date->format('d/m/Y') }}
                    </div>

                    <div>
                        <span class="font-semibold">
                            Jenis:
                        </span>

                        {{ $transaction->type === 'income'
                            ? 'Kas Masuk'
                            : 'Kas Keluar' }}
                    </div>

                    <div>
                        <span class="font-semibold">
                            Keterangan:
                        </span>

                        {{ $transaction->description }}
                    </div>

                    <div>
                        <span class="font-semibold">
                            Nominal:
                        </span>

                        Rp{{ number_format($transaction->amount, 0, ',', '.') }}
                    </div>

                    <div>
                        <span class="font-semibold">
                            Dibuat:
                        </span>

                        {{ $transaction->created_at->format('d/m/Y H:i') }}
                    </div>

                    <div>
                        <span class="font-semibold">
                            Diperbarui:
                        </span>

                        {{ $transaction->updated_at->format('d/m/Y H:i') }}
                    </div>

                </div>

                <div class="mt-6 flex gap-2">

                    <a
                        href="{{ route('transactions.edit', $transaction) }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded"
                    >
                        Edit
                    </a>

                    <a
                        href="{{ route('transactions.index') }}"
                        class="bg-gray-200 px-4 py-2 rounded"
                    >
                        Kembali
                    </a>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>
