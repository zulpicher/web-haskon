{{-- resources/views/tasks/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-zinc-900 tracking-tight">Task Management</h2>
                <p class="text-sm font-medium text-zinc-500 mt-0.5">Kelola, pantau, dan perbarui seluruh task perusahaan.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2.5">
                <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-add-modal'))" class="inline-flex items-center justify-center px-4 py-2 bg-zinc-900 border border-zinc-800 rounded-lg font-semibold text-sm text-white hover:bg-zinc-800 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:ring-offset-2 transition shadow-xs gap-2">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Task
                </button>
            </div>
        </div>
    </x-slot>

    @php
        $statusMap = [
            'todo' => ['label' => 'To Do', 'badge' => 'bg-zinc-100 text-zinc-700 border-zinc-200', 'dot' => 'bg-zinc-500', 'chip' => 'bg-zinc-100 text-zinc-600', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01'],
            'in_progress' => ['label' => 'In Progress', 'badge' => 'bg-amber-50 text-amber-700 border-amber-200', 'dot' => 'bg-amber-500', 'chip' => 'bg-amber-100 text-amber-600', 'icon' => 'M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z'],
            'completed' => ['label' => 'Completed', 'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'dot' => 'bg-emerald-500', 'chip' => 'bg-emerald-100 text-emerald-600', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
            'cancelled' => ['label' => 'Cancelled', 'badge' => 'bg-red-50 text-red-700 border-red-200', 'dot' => 'bg-red-500', 'chip' => 'bg-red-100 text-red-600', 'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ];
        $fallbackStatus = ['label' => null, 'badge' => 'bg-zinc-100 text-zinc-700 border-zinc-200', 'dot' => 'bg-zinc-500', 'chip' => 'bg-zinc-100 text-zinc-600', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'];
    @endphp

    <div x-data="taskManager(@js($groups))" @open-add-modal.window="openAdd()" @keydown.escape.window="closeModal()">
        <div class="py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                @if ($overdueTasks > 0)
                    <div class="mb-6 flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl shadow-xs">
                        <div class="p-1 rounded-lg bg-red-100 text-red-700 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M10.29 3.86l-7.82 14a2 2 0 001.74 3h15.58a2 2 0 001.74-3l-7.82-14a2 2 0 00-3.42 0z"/></svg>
                        </div>
                        <div>
                            <p class="font-bold text-sm text-red-900">Peringatan Task Terlambat</p>
                            <p class="text-xs text-red-700 mt-0.5">Ada {{ $overdueTasks }} task yang sudah melewati deadline.</p>
                        </div>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800 shadow-xs">
                        <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                @include('tasks.components.summary')
                @include('tasks.components.task-table')

            </div>
        </div>

        @include('tasks.components.modals.add')
        @include('tasks.components.modals.edit')
        @include('tasks.components.modals.detail')
        @include('tasks.components.modals.delete')

    </div>
</x-app-layout>