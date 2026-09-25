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

                    {{-- Header --}}
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-haskon-dark">
                            Komentar
                        </h3>

                        <p class="mt-1 text-sm text-haskon-muted">
                            Diskusi dan catatan mengenai task.
                        </p>
                    </div>

                    {{-- Add Comment --}}
                    <div class="mb-8 rounded-lg border border-haskon-border bg-gray-50 p-5">

                        <h4 class="text-sm font-bold text-haskon-dark">
                            Tambahkan Komentar
                        </h4>

                        <form
                            method="POST"
                            action="{{ route('tasks.comments.store', $task) }}"
                            enctype="multipart/form-data"
                            class="mt-4"
                        >
                            @csrf

                            <textarea
                                name="comment"
                                rows="4"
                                required
                                maxlength="5000"
                                placeholder="Tulis komentar..."
                                class="block w-full rounded-lg border border-haskon-border bg-white px-4 py-3 text-sm text-haskon-dark shadow-sm focus:border-haskon-accent focus:ring-haskon-accent"
                            >{{ old('comment') }}</textarea>

                            @error('comment')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                            <div class="mt-4">
                                <label
                                    for="attachment"
                                    class="block text-sm font-semibold text-haskon-dark"
                                >
                                    Lampiran
                                </label>

                                <input
                                    id="attachment"
                                    name="attachment"
                                    type="file"
                                    accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx,.txt,.zip"
                                    class="mt-2 block w-full rounded-lg border border-haskon-border bg-white px-3 py-2 text-sm text-haskon-dark shadow-sm file:mr-4 file:rounded-md file:border-0 file:bg-haskon-dark file:px-4 file:py-2 file:font-semibold file:text-white hover:file:opacity-90"
                                >

                                <p class="mt-2 text-xs text-haskon-muted">
                                    Maksimal 10 MB.
                                    Format: JPG, PNG, PDF, DOC, DOCX, XLS, XLSX, TXT, ZIP.
                                </p>

                                @error('attachment')
                                    <p class="mt-2 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="mt-3 flex justify-end">
                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center rounded-lg bg-haskon-dark px-5 py-2.5 text-sm font-semibold text-white transition hover:opacity-90"
                                >
                                    Tambahkan Komentar
                                </button>
                            </div>
                        </form>
                        
                    </div>

                    {{-- Comment List --}}
                    <div>
                        <div class="mb-4 flex items-center justify-between">
                            <h4 class="text-sm font-bold text-haskon-dark">
                                Riwayat Komentar
                            </h4>

                            <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-haskon-dark">
                                {{ $task->comments->count() }}
                            </span>
                        </div>

                        @forelse ($task->comments as $comment)

                            <div class="border-b border-haskon-border py-5 first:pt-0 last:border-b-0">

                                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">

                                    <div class="min-w-0">
                                        <div class="flex flex-wrap items-center gap-2">

                                            <p class="text-sm font-semibold text-haskon-dark">
                                                {{ $comment->user->name }}
                                            </p>

                                            @if ($comment->user_id === auth()->id())
                                                <span class="rounded-full bg-gray-100 px-2 py-0.5 text-[11px] font-medium text-haskon-muted">
                                                    Anda
                                                </span>
                                            @endif

                                        </div>

                                        <p class="mt-1 text-xs text-haskon-muted">
                                            {{ $comment->created_at->format('d M Y, H:i') }}
                                        </p>
                                    </div>

                                    {{-- Delete Comment --}}
                                    @if (auth()->user()->isAdmin() || $comment->user_id === auth()->id())
                                        <form
                                            method="POST"
                                            action="{{ route('tasks.comments.destroy', $comment) }}"
                                            onsubmit="return confirm('Yakin ingin menghapus komentar ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="text-xs font-semibold text-red-600 transition hover:text-red-800"
                                            >
                                                Hapus
                                            </button>
                                        </form>
                                    @endif

                                </div>

                                {{-- Comment Content --}}
                                <p class="mt-4 whitespace-pre-line text-sm leading-6 text-gray-700">
                                    {{ $comment->comment }}
                                </p>

                                {{-- Attachment Placeholder --}}
                                @if ($comment->attachment_name)
                                    <div class="mt-4 rounded-lg border border-haskon-border bg-gray-50 px-4 py-3">
                                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                                            <div class="min-w-0">
                                                <p class="text-xs font-semibold text-haskon-dark">
                                                    Lampiran
                                                </p>

                                                <p class="mt-1 truncate text-sm text-haskon-muted">
                                                    {{ $comment->attachment_name }}
                                                </p>

                                                @if ($comment->attachment_size)
                                                    <p class="mt-1 text-xs text-haskon-muted">
                                                        {{ number_format($comment->attachment_size / 1024, 1) }} KB
                                                    </p>
                                                @endif
                                            </div>

                                            <a
                                                href="{{ route('tasks.comments.attachment', $comment) }}"
                                                class="inline-flex shrink-0 items-center justify-center rounded-lg border border-haskon-border bg-white px-4 py-2 text-xs font-semibold text-haskon-dark transition hover:bg-gray-100"
                                            >
                                                Unduh File
                                            </a>

                                        </div>
                                    </div>
                                @endif

                            </div>

                        @empty

                            <div class="rounded-lg border border-dashed border-haskon-border bg-gray-50 px-6 py-8 text-center">

                                <p class="text-sm font-semibold text-haskon-dark">
                                    Belum ada komentar
                                </p>

                                <p class="mt-1 text-xs text-haskon-muted">
                                    Jadilah yang pertama memberikan komentar pada task ini.
                                </p>

                            </div>

                        @endforelse
                    </div>

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
