<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-haskon-dark">
                    Manajemen Group
                </h2>

                <p class="mt-1 text-sm text-haskon-muted">
                    Kelola group dan anggota dalam sistem HASKON.
                </p>
            </div>

            <a
                href="{{ route('admin.groups.create') }}"
                class="inline-flex items-center rounded-lg bg-haskon-dark px-4 py-2 text-sm font-medium text-white transition hover:bg-black"
            >
                + Tambah Group
            </a>
        </div>
    </x-slot>

    <div class="min-h-screen bg-haskon-surface py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Flash message --}}
            @if (session('success'))
                <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error --}}
            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    <ul class="list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Page heading --}}
            <div class="mb-6">
                <div class="mb-3 h-px w-16 bg-haskon-accent"></div>

                <h1 class="text-2xl font-semibold text-haskon-dark">
                    Group
                </h1>

                <p class="mt-1 text-sm text-haskon-muted">
                    Daftar group yang tersedia dalam perusahaan.
                </p>
            </div>

            {{-- Group table --}}
            <div class="haskon-card overflow-hidden">

                @if ($groups->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-haskon-border">
                            <thead class="bg-haskon-surface">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-haskon-muted"
                                    >
                                        Group
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-haskon-muted"
                                    >
                                        Deskripsi
                                    </th>

                                    <th
                                        class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-haskon-muted"
                                    >
                                        Anggota
                                    </th>

                                    <th
                                        class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-haskon-muted"
                                    >
                                        Task
                                    </th>

                                    <th
                                        class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-haskon-muted"
                                    >
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-haskon-border bg-white">
                                @foreach ($groups as $group)
                                    <tr class="transition hover:bg-haskon-surface">

                                        {{-- Group --}}
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <div class="font-medium text-haskon-dark">
                                                {{ $group->name }}
                                            </div>

                                            <div class="mt-1 text-xs text-haskon-muted">
                                                Dibuat
                                                {{ $group->created_at->format('d M Y') }}
                                            </div>
                                        </td>

                                        {{-- Description --}}
                                        <td class="max-w-md px-6 py-4">
                                            <p class="truncate text-sm text-haskon-muted">
                                                {{ $group->description ?: 'Tidak ada deskripsi.' }}
                                            </p>
                                        </td>

                                        {{-- Users --}}
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex min-w-10 items-center justify-center rounded-full bg-haskon-surface px-3 py-1 text-sm font-medium text-haskon-dark">
                                                {{ $group->users_count }}
                                            </span>
                                        </td>

                                        {{-- Tasks --}}
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex min-w-10 items-center justify-center rounded-full bg-haskon-surface px-3 py-1 text-sm font-medium text-haskon-dark">
                                                {{ $group->tasks_count }}
                                            </span>
                                        </td>

                                        {{-- Actions --}}
                                        <td class="whitespace-nowrap px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">

                                                <a
                                                    href="{{ route('admin.groups.edit', $group) }}"
                                                    class="rounded-lg border border-haskon-border px-3 py-2 text-sm font-medium text-haskon-dark transition hover:border-haskon-dark hover:bg-haskon-surface"
                                                >
                                                    Kelola
                                                </a>

                                                <form
                                                    action="{{ route('admin.groups.destroy', $group) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus group ini?')"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="rounded-lg border border-red-200 px-3 py-2 text-sm font-medium text-red-700 transition hover:bg-red-50"
                                                    >
                                                        Hapus
                                                    </button>
                                                </form>

                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if ($groups->hasPages())
                        <div class="border-t border-haskon-border px-6 py-4">
                            {{ $groups->links() }}
                        </div>
                    @endif

                @else
                    {{-- Empty state --}}
                    <div class="px-6 py-16 text-center">
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-haskon-surface text-xl font-semibold text-haskon-dark">
                            G
                        </div>

                        <h3 class="mt-4 text-lg font-semibold text-haskon-dark">
                            Belum ada group
                        </h3>

                        <p class="mx-auto mt-2 max-w-md text-sm text-haskon-muted">
                            Buat group pertama untuk mulai mengatur anggota
                            dan task dalam HASKON.
                        </p>

                        <a
                            href="{{ route('admin.groups.create') }}"
                            class="mt-5 inline-flex rounded-lg bg-haskon-dark px-4 py-2 text-sm font-medium text-white transition hover:bg-black"
                        >
                            Tambah Group
                        </a>
                    </div>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>