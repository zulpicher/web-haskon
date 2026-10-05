{{-- resources/views/tasks/components/task-table.blade.php --}}
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
                                <div class="min-w-0">
                                    <div class="font-semibold text-zinc-900 truncate">{{ $task->title }}</div>
                                    <div class="mt-1 flex flex-wrap items-center gap-2">
                                        <span class="inline-flex items-center gap-1 text-xs font-medium text-zinc-500">
                                            <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                            {{ $task->group->name }}
                                        </span>
                                        @php
                                            $pColor = match($task->priority) {
                                                'urgent' => 'text-rose-700 bg-rose-100 border-rose-200',
                                                'high'   => 'text-orange-700 bg-orange-100 border-orange-200',
                                                'medium' => 'text-amber-700 bg-amber-100 border-amber-200',
                                                'low'    => 'text-emerald-700 bg-emerald-100 border-emerald-200',
                                                default  => 'text-zinc-700 bg-zinc-100 border-zinc-200'
                                            };
                                        @endphp
                                        <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider border {{ $pColor }}">
                                            
                                            {{ $task->priority }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        {{-- Assignees --}}
                        <td class="px-5 py-4">
                            @if ($task->assignees->isNotEmpty())
                                <div class="flex items-center gap-2.5">
                                    <div class="flex -space-x-2">
                                        @foreach ($task->assignees->take(3) as $assignee)
                                            <span title="{{ $assignee->name }}" class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-zinc-900 text-amber-400 text-xs font-bold ring-2 ring-white">
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
                            @if (auth()->user()->isAdmin() || $task->assignees->contains('id', auth()->id()))
                                {{-- Jika Admin atau Assignee: Tampilkan Dropdown Interaktif --}}
                                <form action="{{ route('tasks.status.update', $task->id) }}" method="POST" class="m-0">
                                    @csrf
                                    @method('PATCH')
                                    <div class="relative inline-flex items-center group/status">
                                        <select name="status" onchange="this.form.submit()" class="appearance-none pl-3 pr-8 py-1 rounded-md border text-sm font-medium {{ $status['badge'] }} focus:ring-2 focus:ring-amber-400 cursor-pointer outline-none transition-colors relative z-10 w-36">
                                            <option value="todo" {{ $task->status === 'todo' ? 'selected' : '' }}>To Do</option>
                                            <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="completed" {{ $task->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ $task->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                </form>
                            @else
                                {{-- Jika bukan pengemban tugas: Tampilkan Badge Statis (Tidak bisa di-klik) --}}
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md border text-sm font-medium {{ $status['badge'] }} opacity-90 cursor-not-allowed" title="Hanya penanggung jawab task atau Admin yang dapat mengubah status ini.">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $status['dot'] }}"></span>
                                    {{ $statusLabel }}
                                </span>
                            @endif
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
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-red-100 text-[11px] font-semibold text-red-600">Overdue</span>
                                    </div>
                                @endif
                            @else
                                <span class="text-zinc-400">Tidak ada Deadline</span>
                            @endif
                        </td>
                        {{-- Aksi --}}
                        <td class="px-5 py-4 text-right">
                            <div class="inline-flex items-center gap-1.5">
                                <button type="button" @click="openDetail(@js($task))" title="Detail" class="inline-flex items-center justify-center w-10 h-10 rounded-lg border border-zinc-200 bg-zinc-100 text-zinc-700 hover:bg-zinc-900 hover:border-zinc-900 hover:text-white transition">
                                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                                <button type="button" @click="openEdit(@js($task))" title="Edit" class="inline-flex items-center justify-center w-10 h-10 rounded-lg border border-zinc-200 bg-zinc-100 text-zinc-700 hover:bg-zinc-900 hover:border-zinc-900 hover:text-white transition">
                                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button type="button" @click="openDelete(@js($task))" title="Hapus" class="inline-flex items-center justify-center w-10 h-10 rounded-lg border border-rose-200 bg-rose-50 text-rose-600 hover:bg-rose-500 hover:border-rose-500 hover:text-white transition">
                                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-12 text-center">
                            <div class="mx-auto mb-3 flex items-center justify-center w-12 h-12 rounded-xl bg-zinc-100 text-zinc-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $statusMap['todo']['icon'] }}"/></svg>
                            </div>
                            <p class="font-semibold text-zinc-800">Belum ada task</p>
                            <p class="text-xs text-zinc-500 mt-1">Klik <span class="font-semibold text-zinc-700">Tambah Task</span> untuk membuat yang pertama.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>