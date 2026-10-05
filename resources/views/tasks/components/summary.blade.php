{{-- resources/views/tasks/components/summary.blade.php --}}
<div class="grid grid-cols-2 md:grid-cols-5 gap-4">

    {{-- Total Task (Di HP tampil sendiri penuh 2 kolom, di PC 1 kolom) --}}
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

    {{-- Overdue (Di HP tampil 1 kolom bersampingan dengan Completed) --}}
    <div class="bg-red-50/60 border border-red-200 rounded-[0.875rem] p-5 shadow-xs">
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