<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold text-haskon-dark">
                Kelola Group
            </h2>

            <p class="mt-1 text-sm text-haskon-muted">
                Kelola informasi dan anggota group.
            </p>
        </div>
    </x-slot>

    <div class="min-h-screen bg-haskon-surface py-8">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            {{-- Back --}}
            <div class="mb-6">
                <a
                    href="{{ route('admin.groups.index') }}"
                    class="text-sm font-medium text-haskon-muted transition hover:text-haskon-dark"
                >
                    ← Kembali ke Group
                </a>
            </div>

            {{-- Success --}}
            @if (session('success'))
                <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Group information --}}
            <div class="haskon-card mb-6 p-6 sm:p-8">

                <div class="mb-8">
                    <div class="mb-3 h-px w-12 bg-haskon-accent"></div>

                    <h1 class="text-xl font-semibold text-haskon-dark">
                        Informasi Group
                    </h1>

                    <p class="mt-1 text-sm text-haskon-muted">
                        Perbarui informasi dasar group.
                    </p>
                </div>

                <form
                    action="{{ route('admin.groups.update', $group) }}"
                    method="POST"
                    class="space-y-6"
                >
                    @csrf
                    @method('PUT')

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
                            value="{{ old('name', $group->name) }}"
                            required
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
                            rows="4"
                            class="block w-full rounded-lg border-haskon-border bg-white text-sm text-haskon-dark shadow-sm focus:border-haskon-accent focus:ring-haskon-accent"
                        >{{ old('description', $group->description) }}</textarea>

                        @error('description')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex justify-end border-t border-haskon-border pt-6">
                        <button
                            type="submit"
                            class="rounded-lg bg-haskon-dark px-5 py-2.5 text-sm font-medium text-white transition hover:bg-black"
                        >
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>

            {{-- Members --}}
            <div class="haskon-card p-6 sm:p-8">

                <div class="mb-8">
                    <div class="mb-3 h-px w-12 bg-haskon-accent"></div>

                    <h2 class="text-xl font-semibold text-haskon-dark">
                        Anggota Group
                    </h2>

                    <p class="mt-1 text-sm text-haskon-muted">
                        {{ $group->users->count() }} anggota terdaftar
                        dalam group ini.
                    </p>
                </div>

                {{-- Add member --}}
                @if ($availableUsers->count())
                    <div class="mb-8 rounded-lg border border-haskon-border bg-haskon-surface p-5">

                        <h3 class="mb-4 text-sm font-semibold text-haskon-dark">
                            Tambah Anggota
                        </h3>

                        <form
                            action="{{ route('admin.groups.members.add', $group) }}"
                            method="POST"
                            class="flex flex-col gap-3 sm:flex-row"
                        >
                            @csrf

                            <select
                                name="user_id"
                                required
                                class="block flex-1 rounded-lg border-haskon-border bg-white text-sm text-haskon-dark shadow-sm focus:border-haskon-accent focus:ring-haskon-accent"
                            >
                                <option value="">
                                    Pilih user
                                </option>

                                @foreach ($availableUsers as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }} — {{ $user->email }}
                                    </option>
                                @endforeach
                            </select>

                            <button
                                type="submit"
                                class="rounded-lg bg-haskon-dark px-5 py-2.5 text-sm font-medium text-white transition hover:bg-black"
                            >
                                Tambah
                            </button>
                        </form>

                        @error('user_id')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                @endif

                {{-- Member list --}}
                @if ($group->users->count())
                    <div class="overflow-hidden rounded-lg border border-haskon-border">
                        <div class="divide-y divide-haskon-border">

                            @foreach ($group->users as $user)
                                <div class="flex flex-col gap-4 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">

                                    <div class="flex items-center gap-4">

                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-haskon-dark text-sm font-semibold text-white">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>

                                        <div>
                                            <p class="font-medium text-haskon-dark">
                                                {{ $user->name }}
                                            </p>

                                            <p class="text-sm text-haskon-muted">
                                                {{ $user->email }}
                                            </p>
                                        </div>

                                    </div>

                                    <div class="flex items-center gap-3">

                                        <span class="rounded-full bg-haskon-surface px-3 py-1 text-xs font-medium uppercase text-haskon-muted">
                                            {{ $user->role }}
                                        </span>

                                        <form
                                            action="{{ route('admin.groups.members.remove', [$group, $user]) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin mengeluarkan user ini dari group?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="rounded-lg border border-red-200 px-3 py-2 text-sm font-medium text-red-700 transition hover:bg-red-50"
                                            >
                                                Keluarkan
                                            </button>
                                        </form>

                                    </div>

                                </div>
                            @endforeach

                        </div>
                    </div>
                @else
                    <div class="rounded-lg border border-dashed border-haskon-border px-6 py-10 text-center">
                        <p class="text-sm font-medium text-haskon-dark">
                            Belum ada anggota
                        </p>

                        <p class="mt-1 text-sm text-haskon-muted">
                            Tambahkan user untuk menjadi anggota group.
                        </p>
                    </div>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>