```blade
<x-app-layout>
    <div class="min-h-screen bg-haskon-surface py-8">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <div class="mb-3 h-1 w-16 bg-haskon-accent"></div>

                    <h1 class="text-2xl font-bold tracking-tight text-haskon-dark">
                        Detail Task
                    </h1>

                    <p class="mt-1 text-sm text-haskon-muted">
                        Informasi lengkap mengenai task.
                    </p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <a
                        href="{{ route('tasks.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-haskon-border bg-white px-4 py-2.5 text-sm font-semibold text-haskon-dark transition hover:bg-gray-50"
                    >
                        Kembali
                    </a>

                    <a
                        href="{{ route('tasks.edit', $task) }}"
                        class="inline-flex items-center justify-center rounded-lg bg-haskon-dark px-4 py-2.5 text-sm font-semibold text-white transition hover:opacity-90"
                    >
                        Edit Task
                    </a>
                </div>
            </div>

            {{-- Flash Message --}}
            @if (session('success'))
                <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Main Task Card --}}
            <div class="haskon-card overflow-hidden">

                {{-- Task Header --}}
                <div class="border-b border-haskon-border p-6 sm:p-8">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">

                        <div class="min-w-0">
                            <div class="mb-3 flex flex-wrap items-center gap-2">
                                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-haskon-dark">
                                    #{{ $task->id }}
                                </span>

                                @php
                                    $statusLabels = [
                                        'todo' => 'To Do',
                                        'in_progress' => 'In Progress',
                                        'completed' => 'Completed',
                                        'cancelled' => 'Cancelled',
                                    ];

                                    $priorityLabels = [
                                        'low' => 'Low',
                                        'medium' => 'Medium',
                                        'high' => 'High',
                                        'urgent' => 'Urgent',
                                    ];
                                @endphp

                                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-haskon-dark">
                                    {{ $statusLabels[$task->status] ?? ucfirst($task->status) }}
                                </span>

                                <span class="rounded-full border border-haskon-accent bg-haskon-accent-soft px-3 py-1 text-xs font-semibold text-haskon-dark">
                                    {{ $priorityLabels[$task->priority] ?? ucfirst($task->priority) }}
                                </span>
                            </div>

                            <h2 class="break-words text-xl font-bold text-haskon-dark sm:text-2xl">
                                {{ $task->title }}
                            </h2>

                            <p class="mt-2 text-sm text-haskon-muted">
                                Dibuat {{ $task->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>

                        {{-- Overdue --}}
                        @if ($task->isOverdue())
                            <span class="inline-flex w-fit items-center rounded-full bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700">
                                Overdue
                            </span>
                        @endif

                    </div>
                </div>

                {{-- Description --}}
                <div class="border-b border-haskon-border p-6 sm:p-8">
                    <h3 class="mb-3 text-sm font-bold uppercase tracking-wide text-haskon-dark">
                        Deskripsi
                    </h3>

                    @if ($task->description)
                        <div class="whitespace-pre-line text-sm leading-7 text-gray-700">
                            {{ $task->description }}
                        </div>
                    @else
                        <p class="text-sm italic text-haskon-muted">
                            Tidak ada deskripsi.
                        </p>
                    @endif
                </div>

                {{-- Task Information --}}
                <div class="grid gap-6 border-b border-haskon-border p-6 sm:grid-cols-2 sm:p-8 lg:grid-cols-4">

                    {{-- Group --}}
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-haskon-muted">
                            Group
                        </p>

                        <p class="mt-2 text-sm font-semibold text-haskon-dark">
                            {{ $task->group->name }}
                        </p>
                    </div>

                    {{-- Assignee --}}
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-haskon-muted">
                            Ditugaskan Kepada
                        </p>

                        <p class="mt-2 text-sm font-semibold text-haskon-dark">
                            {{ $task->assignee->name }}
                        </p>

                        <p class="mt-1 text-xs text-haskon-muted">
                            {{ $task->assignee->email }}
                        </p>
                    </div>

                    {{-- Creator --}}
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-haskon-muted">
                            Dibuat Oleh
                        </p>

                        <p class="mt-2 text-sm font-semibold text-haskon-dark">
                            {{ $task->creator->name }}
                        </p>

                        <p class="mt-1 text-xs text-haskon-muted">
                            {{ $task->creator->email }}
                        </p>
                    </div>

                    {{-- Deadline --}}
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-haskon-muted">
                            Deadline
                        </p>

                        @if ($task->due_date)
                            <p class="mt-2 text-sm font-semibold text-haskon-dark">
                                {{ $task->due_date->format('d M Y') }}
                            </p>

                            @if ($task->isOverdue())
                                <p class="mt-1 text-xs font-semibold text-red-600">
                                    Melewati deadline
                                </p>
                            @else
                                <p class="mt-1 text-xs text-haskon-muted">
                                    Sesuai jadwal
                                </p>
                            @endif
                        @else
                            <p class="mt-2 text-sm text-haskon-muted">
                                Tidak ada deadline
                            </p>
                        @endif
                    </div>

                </div>

                {{-- Completion --}}
                @if ($task->completed_at)
                    <div class="border-b border-haskon-border bg-gray-50 px-6 py-4 sm:px-8">
                        <p class="text-sm text-gray-700">
                            Task diselesaikan pada
                            <span class="font-semibold">
                                {{ $task->completed_at->format('d M Y, H:i') }}
                            </span>
                        </p>
                    </div>
                @endif

                {{-- Comments --}}
                <div class="p-6 sm:p-8">
                    <div class="mb-6 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-haskon-dark">
                                Komentar
                            </h3>

                            <p class="mt-1 text-sm text-haskon-muted">
                                Diskusi dan catatan mengenai task.
                            </p>
                        </div>

                        <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-haskon-dark">
                            {{ $task->comments->count() }}
                        </span>
                    </div>

                    @forelse ($task->comments as $comment)
                        <div class="border-b border-haskon-border py-5 first:pt-0 last:border-b-0">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm font-semibold text-haskon-dark">
                                        {{ $comment->user->name }}
                                    </p>

                                    <p class="mt-1 text-xs text-haskon-muted">
                                        {{ $comment->created_at->format('d M Y, H:i') }}
                                    </p>
                                </div>
                            </div>

                            <p class="mt-3 whitespace-pre-line text-sm leading-6 text-gray-700">
                                {{ $comment->comment }}
                            </p>

                            @if ($comment->attachment_name)
                                <div class="mt-3 rounded-lg border border-haskon-border bg-gray-50 px-4 py-3">
                                    <p class="text-xs font-semibold text-haskon-dark">
                                        Lampiran
                                    </p>

                                    <p class="mt-1 text-xs text-haskon-muted">
                                        {{ $comment->attachment_name }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="rounded-lg border border-dashed border-haskon-border bg-gray-50 px-6 py-8 text-center">
                            <p class="text-sm font-semibold text-haskon-dark">
                                Belum ada komentar
                            </p>

                            <p class="mt-1 text-xs text-haskon-muted">
                                Komentar dapat ditambahkan pada tahap berikutnya.
                            </p>
                        </div>
                    @endforelse
                </div>

                {{-- Bottom Actions --}}
                <div class="flex flex-col-reverse gap-3 border-t border-haskon-border bg-gray-50 p-6 sm:flex-row sm:justify-between sm:p-8">

                    <form
                        method="POST"
                        action="{{ route('tasks.destroy', $task) }}"
                        onsubmit="return confirm('Yakin ingin menghapus task ini?')"
                    >
                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center rounded-lg border border-red-200 bg-white px-4 py-2.5 text-sm font-semibold text-red-700 transition hover:bg-red-50 sm:w-auto"
                        >
                            Hapus Task
                        </button>
                    </form>

                    <div class="flex flex-col gap-3 sm:flex-row">
                        <a
                            href="{{ route('tasks.index') }}"
                            class="inline-flex items-center justify-center rounded-lg border border-haskon-border bg-white px-4 py-2.5 text-sm font-semibold text-haskon-dark transition hover:bg-gray-50"
                        >
                            Kembali ke Task
                        </a>

                        <a
                            href="{{ route('tasks.edit', $task) }}"
                            class="inline-flex items-center justify-center rounded-lg bg-haskon-dark px-4 py-2.5 text-sm font-semibold text-white transition hover:opacity-90"
                        >
                            Edit Task
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
```
