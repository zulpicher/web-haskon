{{-- resources\views\tasks\index.blade.php --}}
<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-zinc-900 tracking-tight">
                    Task Management
                </h2>
                <p class="text-sm font-medium text-zinc-500 mt-0.5">
                    Kelola, pantau, dan perbarui seluruh task perusahaan.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2.5">
                {{-- Tambah Task --}}
                {{-- NOTE: slot header berada DI LUAR x-data, jadi pakai onclick (bukan @click) seperti di Buku Kas --}}
                <button
                    type="button"
                    onclick="window.dispatchEvent(new CustomEvent('open-add-modal'))"
                    class="inline-flex items-center justify-center px-4 py-2 bg-zinc-900 border border-zinc-800 rounded-lg font-semibold text-sm text-white hover:bg-zinc-800 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:ring-offset-2 transition shadow-xs gap-2"
                >
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Task
                </button>
            </div>
        </div>
    </x-slot>

    {{-- ========================================================= --}}
    {{-- HELPER: mapping status -> label, warna, dan icon --}}
    {{-- ========================================================= --}}
    @php
        $statusMap = [
            'todo' => [
                'label' => 'To Do',
                'badge' => 'bg-zinc-100 text-zinc-700 border-zinc-200',
                'dot'   => 'bg-zinc-500',
                'chip'  => 'bg-zinc-100 text-zinc-600',
                'icon'  => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01',
            ],
            'in_progress' => [
                'label' => 'In Progress',
                'badge' => 'bg-amber-50 text-amber-700 border-amber-200',
                'dot'   => 'bg-amber-500',
                'chip'  => 'bg-amber-100 text-amber-600',
                'icon'  => 'M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z',
            ],
            'completed' => [
                'label' => 'Completed',
                'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                'dot'   => 'bg-emerald-500',
                'chip'  => 'bg-emerald-100 text-emerald-600',
                'icon'  => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
            ],
            'cancelled' => [
                'label' => 'Cancelled',
                'badge' => 'bg-red-50 text-red-700 border-red-200',
                'dot'   => 'bg-red-500',
                'chip'  => 'bg-red-100 text-red-600',
                'icon'  => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
            ],
        ];

        // Fallback kalau ada status lain (misal waiting_review)
        $fallbackStatus = [
            'label' => null,
            'badge' => 'bg-zinc-100 text-zinc-700 border-zinc-200',
            'dot'   => 'bg-zinc-500',
            'chip'  => 'bg-zinc-100 text-zinc-600',
            'icon'  => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
        ];
    @endphp

    {{-- ========================================================= --}}
    {{-- ALPINE APP --}}
    {{-- ========================================================= --}}
    <div
        x-data="taskManager(@js($groups))"
        @open-add-modal.window="openAdd()"
        @keydown.escape.window="closeModal()"
    >
        <div class="py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                {{-- ================================================= --}}
                {{-- WARNING TASK OVERDUE --}}
                {{-- ================================================= --}}
                @if ($overdueTasks > 0)
                    <div class="mb-6 flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl shadow-xs">
                        <div class="p-1 rounded-lg bg-red-100 text-red-700 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M10.29 3.86l-7.82 14a2 2 0 001.74 3h15.58a2 2 0 001.74-3l-7.82-14a2 2 0 00-3.42 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-sm text-red-900">Peringatan Task Terlambat</p>
                            <p class="text-xs text-red-700 mt-0.5">
                                Ada {{ $overdueTasks }} task yang sudah melewati deadline.
                            </p>
                        </div>
                    </div>
                @endif

                {{-- Flash Message --}}
                @if (session('success'))
                    <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800 shadow-xs">
                        <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Validation Error Fallback --}}
                @if ($errors->any())
                    <div class="mb-6 flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800 shadow-xs">
                        <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Terdapat kesalahan pada input form. Silakan ulangi aksi terakhir Anda.
                    </div>
                @endif

                {{-- ================================================= --}}
                {{-- SUMMARY CARDS --}}
                {{-- ================================================= --}}
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">

                    {{-- Total Task (kartu gelap sebagai fokus utama) --}}
                    <div class="haskon-card-dark col-span-2 md:col-span-1 p-5">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-sm font-medium text-zinc-400">Total Task</p>
                                <p class="mt-2 text-3xl font-bold text-white">{{ $totalTasks }}</p>
                            </div>
                            <div class="p-2 rounded-lg bg-amber-400/15 text-amber-400 flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-3 text-xs font-medium text-zinc-500">Seluruh task perusahaan</p>
                    </div>

                    {{-- To Do --}}
                    <div class="haskon-card p-5">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-sm font-medium text-zinc-500">To Do</p>
                                <p class="mt-2 text-3xl font-bold text-haskon-balance">{{ $todoTasks }}</p>
                            </div>
                            <div class="p-2 rounded-lg bg-zinc-100 text-zinc-600 flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $statusMap['todo']['icon'] }}"/>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-3 text-xs font-medium text-zinc-400">Belum dikerjakan</p>
                    </div>

                    {{-- In Progress --}}
                    <div class="haskon-card p-5">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-sm font-medium text-zinc-500">In Progress</p>
                                <p class="mt-2 text-3xl font-bold text-amber-500">{{ $inProgressTasks }}</p>
                            </div>
                            <div class="p-2 rounded-lg bg-amber-100 text-amber-600 flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $statusMap['in_progress']['icon'] }}"/>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-3 text-xs font-medium text-zinc-400">Sedang dikerjakan</p>
                    </div>

                    {{-- Completed --}}
                    <div class="haskon-card p-5">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-sm font-medium text-zinc-500">Completed</p>
                                <p class="mt-2 text-3xl font-bold text-haskon-income">{{ $completedTasks }}</p>
                            </div>
                            <div class="p-2 rounded-lg bg-emerald-100 text-emerald-600 flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $statusMap['completed']['icon'] }}"/>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-3 text-xs font-medium text-zinc-400">Sudah selesai</p>
                    </div>

                    {{-- Overdue --}}
                    <div class="col-span-2 md:col-span-1 bg-red-50/60 border border-red-200 rounded-[0.875rem] p-5 shadow-xs">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-sm font-medium text-red-600">Overdue</p>
                                <p class="mt-2 text-3xl font-bold text-haskon-expense">{{ $overdueTasks }}</p>
                            </div>
                            <div class="p-2 rounded-lg bg-red-100 text-red-600 flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M10.29 3.86l-7.82 14a2 2 0 001.74 3h15.58a2 2 0 001.74-3l-7.82-14a2 2 0 00-3.42 0z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-3 text-xs font-medium text-red-400">Melewati deadline</p>
                    </div>
                </div>

                {{-- ================================================= --}}
                {{-- DAFTAR PEKERJAAN --}}
                {{-- ================================================= --}}
                <div class="mt-6 haskon-card overflow-hidden">

                    {{-- Header card --}}
                    <div class="px-5 py-4 border-b border-zinc-200 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center justify-center w-11 h-11 rounded-xl bg-zinc-900 text-white flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-zinc-900">Daftar Pekerjaan</h3>
                                <p class="text-xs font-medium text-zinc-500 mt-0.5">Seluruh task beserta status dan deadline-nya.</p>
                            </div>
                        </div>

                        <span class="inline-flex items-center px-3.5 py-2 rounded-lg bg-zinc-100 border border-zinc-200 text-sm font-semibold text-zinc-800">
                            {{ $tasks->count() }} task
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-zinc-900 text-xs font-semibold text-zinc-200 uppercase tracking-wider">
                                    <th class="px-5 py-3.5">Task</th>
                                    <th class="px-5 py-3.5">Assignee</th>
                                    <th class="px-5 py-3.5">Status</th>
                                    <th class="px-5 py-3.5">Deadline</th>
                                    <th class="px-5 py-3.5 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100 text-sm">
                                @forelse ($tasks as $task)
                                    @php
                                        $isOverdue = $task->isOverdue();
                                        $status    = $statusMap[$task->status] ?? $fallbackStatus;
                                        $statusLabel = $status['label'] ?? ucfirst(str_replace('_', ' ', $task->status));
                                    @endphp

                                    <tr class="{{ $isOverdue ? 'bg-red-50/30' : '' }} hover:bg-zinc-50/70 transition">

                                        {{-- Task Info --}}
                                        <td class="px-5 py-4">
                                            <div class="flex items-center gap-3">
                                                {{-- Element Chip Dikembalikan ke Sini --}}
                                                <div class="p-2 rounded-lg {{ $status['chip'] }} flex-shrink-0">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $status['icon'] }}"/>
                                                    </svg>
                                                </div>
                                                <div class="min-w-0">
                                                    <div class="font-semibold text-zinc-900 truncate">{{ $task->title }}</div>
                                                    <div class="mt-0.5 inline-flex items-center gap-1 text-xs text-zinc-500">
                                                        <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                                        </svg>
                                                        {{ $task->group->name }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Assignees: avatar inisial (maks 3) + nama --}}
                                        <td class="px-5 py-4">
                                            @if ($task->assignees->isNotEmpty())
                                                <div class="flex items-center gap-2.5">
                                                    <div class="flex -space-x-2">
                                                        @foreach ($task->assignees->take(3) as $assignee)
                                                            <span
                                                                title="{{ $assignee->name }}"
                                                                class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-zinc-900 text-amber-400 text-xs font-bold ring-2 ring-white"
                                                            >
                                                                {{ mb_strtoupper(mb_substr($assignee->name, 0, 1)) }}
                                                            </span>
                                                        @endforeach

                                                        @if ($task->assignees->count() > 3)
                                                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-zinc-100 text-zinc-600 text-[10px] font-bold ring-2 ring-white">
                                                                +{{ $task->assignees->count() - 3 }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <span class="text-zinc-900 font-medium truncate max-w-[10rem]">
                                                        {{ $task->assignees->pluck('name')->join(', ') }}
                                                    </span>
                                                </div>
                                            @else
                                                <span class="text-zinc-400">-</span>
                                            @endif
                                        </td>

                                        {{-- Status --}}
                                        <td class="px-5 py-4">
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md border text-sm font-medium {{ $status['badge'] }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $status['dot'] }}"></span>
                                                {{ $statusLabel }}
                                            </span>
                                        </td>

                                        {{-- Deadline --}}
                                        <td class="px-5 py-4">
                                            @if ($task->due_date)
                                                <div class="inline-flex items-center gap-1.5 {{ $isOverdue ? 'font-semibold text-haskon-expense' : 'text-zinc-700' }}">
                                                    <svg class="w-4 h-4 {{ $isOverdue ? 'text-red-500' : 'text-zinc-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    {{ $task->due_date->format('d M Y') }}
                                                </div>
                                                @if ($isOverdue)
                                                    <div class="mt-1">
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-red-100 text-[11px] font-semibold text-red-600">
                                                            Overdue
                                                        </span>
                                                    </div>
                                                @endif
                                            @else
                                                <span class="text-zinc-400">-</span>
                                            @endif
                                        </td>

                                        {{-- Aksi (icon button) --}}
                                        <td class="px-5 py-4 text-right">
                                            <div class="inline-flex items-center gap-1.5">

                                                {{-- Detail --}}
                                                <button
                                                    type="button"
                                                    @click="openDetail(@js($task))"
                                                    title="Detail"
                                                    aria-label="Detail task"
                                                    class="inline-flex items-center justify-center w-10 h-10 rounded-lg border border-zinc-200 bg-zinc-100 text-zinc-700 hover:bg-zinc-900 hover:border-zinc-900 hover:text-white focus:outline-none focus:ring-2 focus:ring-zinc-400 focus:ring-offset-1 transition"
                                                >
                                                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                </button>

                                                {{-- Edit --}}
                                                <button
                                                    type="button"
                                                    @click="openEdit(@js($task))"
                                                    title="Edit"
                                                    aria-label="Edit task"
                                                    class="inline-flex items-center justify-center w-10 h-10 rounded-lg border border-zinc-200 bg-zinc-100 text-zinc-700 hover:bg-zinc-900 hover:border-zinc-900 hover:text-white focus:outline-none focus:ring-2 focus:ring-zinc-400 focus:ring-offset-1 transition"
                                                >
                                                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </button>

                                                {{-- Hapus --}}
                                                <button
                                                    type="button"
                                                    @click="openDelete(@js($task))"
                                                    title="Hapus"
                                                    aria-label="Hapus task"
                                                    class="inline-flex items-center justify-center w-10 h-10 rounded-lg border border-rose-200 bg-rose-50 text-rose-600 hover:bg-rose-500 hover:border-rose-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-rose-400 focus:ring-offset-1 transition"
                                                >
                                                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-12 text-center">
                                            <div class="mx-auto mb-3 flex items-center justify-center w-12 h-12 rounded-xl bg-zinc-100 text-zinc-400">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $statusMap['todo']['icon'] }}"/>
                                                </svg>
                                            </div>
                                            <p class="font-semibold text-zinc-800">Belum ada task</p>
                                            <p class="text-xs text-zinc-500 mt-1">
                                                Klik <span class="font-semibold text-zinc-700">Tambah Task</span> untuk membuat yang pertama.
                                            </p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- MEMANGGIL KOMPONEN MODAL --}}
        {{-- ========================================================= --}}
        @include('tasks.components.modals.add')
        @include('tasks.components.modals.edit')
        @include('tasks.components.modals.detail')
        @include('tasks.components.modals.delete')

    </div>

</x-app-layout>