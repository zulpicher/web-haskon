<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold text-haskon-dark">
                Tambah Group
            </h2>

            <p class="mt-1 text-sm text-haskon-muted">
                Buat group baru untuk mengorganisasi anggota dan task.
            </p>
        </div>
    </x-slot>

    <div class="min-h-screen bg-haskon-surface py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">

            {{-- Back --}}
            <div class="mb-6">
                <a
                    href="{{ route('admin.groups.index') }}"
                    class="text-sm font-medium text-haskon-muted transition hover:text-haskon-dark"
                >
                    ← Kembali ke Group
                </a>
            </div>

            {{-- Form card --}}
            <div class="haskon-card p-6 sm:p-8">

                <div class="mb-8">
                    <div class="mb-3 h-px w-12 bg-haskon-accent"></div>

                    <h1 class="text-xl font-semibold text-haskon-dark">
                        Informasi Group
                    </h1>

                    <p class="mt-1 text-sm text-haskon-muted">
                        Isi informasi dasar group yang akan dibuat.
                    </p>
                </div>

                <form
                    action="{{ route('admin.groups.store') }}"
                    method="POST"
                    class="space-y-6"
                >
                    @csrf

                    {{-- Name --}}
                    <div>
                        <label
                            for="name"
                            class="mb-2 block text-sm font-medium text-haskon-dark"
                        >
                            Nama Group
                        </label>

                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            placeholder="Contoh: IT Development"
                            class="block w-full rounded-lg border-haskon-border bg-white text-sm text-haskon-dark shadow-sm focus:border-haskon-accent focus:ring-haskon-accent"
                        >

                        @error('name')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label
                            for="description"
                            class="mb-2 block text-sm font-medium text-haskon-dark"
                        >
                            Deskripsi
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="5"
                            placeholder="Jelaskan fungsi atau tujuan group..."
                            class="block w-full rounded-lg border-haskon-border bg-white text-sm text-haskon-dark shadow-sm focus:border-haskon-accent focus:ring-haskon-accent"
                        >{{ old('description') }}</textarea>

                        @error('description')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center justify-end gap-3 border-t border-haskon-border pt-6">

                        <a
                            href="{{ route('admin.groups.index') }}"
                            class="rounded-lg border border-haskon-border px-4 py-2.5 text-sm font-medium text-haskon-dark transition hover:bg-haskon-surface"
                        >
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="rounded-lg bg-haskon-dark px-5 py-2.5 text-sm font-medium text-white transition hover:bg-black"
                        >
                            Simpan Group
                        </button>

                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>