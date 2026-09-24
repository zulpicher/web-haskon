<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="text-xl font-semibold leading-tight text-haskon-dark">
                    Task Management
                </h2>

                <p class="mt-1 text-sm text-haskon-muted">
                    Kelola, pantau, dan perbarui seluruh task perusahaan.
                </p>
            </div>

            <a
                href="{{ route('tasks.create') }}"
                class="inline-flex items-center justify-center rounded-lg
                       bg-haskon-dark px-4 py-2.5 text-sm font-semibold
                       text-white transition hover:bg-black
                       focus:outline-none focus:ring-2
                       focus:ring-haskon-accent focus:ring-offset-2"
            >
                <svg
                    class="mr-2 h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 4v16m8-8H4"
                    />
                </svg>

                Tambah Task
            </a>

        </div>

    </x-slot>


    <div class="min-h-screen bg-haskon-surface">

        <div class="mx-auto max-w-7xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">


            {{-- ===================================================== --}}
            {{-- FLASH MESSAGE --}}
            {{-- ===================================================== --}}

            @if (session('success'))

                <div
                    class="rounded-lg border border-green-200 bg-green-50
                           px-4 py-3 text-sm text-green-800"
                >
                    {{ session('success') }}
                </div>

            @endif


            {{-- ===================================================== --}}
            {{-- SUMMARY --}}
            {{-- ===================================================== --}}

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">

                {{-- Total --}}

                <div class="haskon-card p-5">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-sm font-medium text-haskon-muted">
                                Total Task
                            </p>

                            <p class="mt-2 text-2xl font-bold text-haskon-dark">
                                {{ $totalTasks }}
                            </p>
                        </div>

                        <div class="rounded-lg bg-gray-100 p-2.5 text-haskon-dark">

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2
                                       M9 5a3 3 0 006 0
                                       M9 5h6"
                                />
                            </svg>

                        </div>

                    </div>

                </div>


                {{-- To Do --}}

                <div class="haskon-card p-5">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-sm font-medium text-haskon-muted">
                                To Do
                            </p>

                            <p class="mt-2 text-2xl font-bold text-haskon-dark">
                                {{ $todoTasks }}
                            </p>
                        </div>

                        <div class="rounded-lg bg-gray-100 p-2.5 text-haskon-dark">

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2
                                       M9 5a3 3 0 006 0"
                                />
                            </svg>

                        </div>

                    </div>

                </div>


                {{-- In Progress --}}

                <div class="haskon-card p-5">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-sm font-medium text-haskon-muted">
                                In Progress
                            </p>

                            <p class="mt-2 text-2xl font-bold text-haskon-dark">
                                {{ $inProgressTasks }}
                            </p>
                        </div>

                        <div class="rounded-lg bg-gray-100 p-2.5 text-haskon-dark">

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 6v6l4 2"
                                />

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="9"
                                />
                            </svg>

                        </div>

                    </div>

                </div>


                {{-- Completed --}}

                <div class="haskon-card p-5">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-sm font-medium text-haskon-muted">
                                Completed
                            </p>

                            <p class="mt-2 text-2xl font-bold text-haskon-dark">
                                {{ $completedTasks }}
                            </p>
                        </div>

                        <div class="rounded-lg bg-gray-100 p-2.5 text-haskon-dark">

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>

                        </div>

                    </div>

                </div>


                {{-- Overdue --}}

                <div class="haskon-card border-red-200 p-5">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-sm font-medium text-haskon-muted">
                                Overdue
                            </p>

                            <p class="mt-2 text-2xl font-bold text-red-700">
                                {{ $overdueTasks }}
                            </p>
                        </div>

                        <div class="rounded-lg bg-red-50 p-2.5 text-red-700">

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 9v4
                                       m0 4h.01
                                       M10.29 3.86l-7.82 13.5A2 2 0 004.2 20h15.6
                                       a2 2 0 001.73-2.64l-7.82-13.5a2 2 0 00-3.42 0z"
                                />
                            </svg>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- FILTER --}}
            {{-- ===================================================== --}}

            <div class="haskon-card p-5">

                <div class="mb-4">

                    <h3 class="text-base font-semibold text-haskon-dark">
                        Filter Task
                    </h3>

                    <p class="mt-1 text-sm text-haskon-muted">
                        Gunakan filter untuk menemukan task tertentu.
                    </p>

                </div>


                <form
                    method="GET"
                    action="{{ route('tasks.index') }}"
                    class="grid grid-cols-1 gap-4 md:grid-cols-4"
                >

                    {{-- Status --}}

                    <div>

                        <label
                            for="status"
                            class="mb-1.5 block text-sm font-medium text-haskon-dark"
                        >
                            Status
                        </label>

                        <select
                            id="status"
                            name="status"
                            class="w-full rounded-lg border-haskon-border
                                   text-sm shadow-sm
                                   focus:border-haskon-accent
                                   focus:ring-haskon-accent"
                        >
                            <option value="">
                                Semua Status
                            </option>

                            <option
                                value="todo"
                                @selected(request('status') === 'todo')
                            >
                                To Do
                            </option>

                            <option
                                value="in_progress"
                                @selected(request('status') === 'in_progress')
                            >
                                In Progress
                            </option>

                            <option
                                value="completed"
                                @selected(request('status') === 'completed')
                            >
                                Completed
                            </option>

                            <option
                                value="cancelled"
                                @selected(request('status') === 'cancelled')
                            >
                                Cancelled
                            </option>

                        </select>

                    </div>


                    {{-- Priority --}}

                    <div>

                        <label
                            for="priority"
                            class="mb-1.5 block text-sm font-medium text-haskon-dark"
                        >
                            Prioritas
                        </label>

                        <select
                            id="priority"
                            name="priority"
                            class="w-full rounded-lg border-haskon-border
                                   text-sm shadow-sm
                                   focus:border-haskon-accent
                                   focus:ring-haskon-accent"
                        >
                            <option value="">
                                Semua Prioritas
                            </option>

                            <option
                                value="low"
                                @selected(request('priority') === 'low')
                            >
                                Low
                            </option>

                            <option
                                value="medium"
                                @selected(request('priority') === 'medium')
                            >
                                Medium
                            </option>

                            <option
                                value="high"
                                @selected(request('priority') === 'high')
                            >
                                High
                            </option>

                            <option
                                value="urgent"
                                @selected(request('priority') === 'urgent')
                            >
                                Urgent
                            </option>

                        </select>

                    </div>


                    {{-- Group --}}

                    <div>

                        <label
                            for="group_id"
                            class="mb-1.5 block text-sm font-medium text-haskon-dark"
                        >
                            Group
                        </label>

                        <select
                            id="group_id"
                            name="group_id"
                            class="w-full rounded-lg border-haskon-border
                                   text-sm shadow-sm
                                   focus:border-haskon-accent
                                   focus:ring-haskon-accent"
                        >
                            <option value="">
                                Semua Group
                            </option>

                            @foreach ($groups as $group)

                                <option
                                    value="{{ $group->id }}"
                                    @selected((string) request('group_id') === (string) $group->id)
                                >
                                    {{ $group->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Buttons --}}

                    <div class="flex items-end gap-2">

                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center
                                   rounded-lg bg-haskon-dark px-4 py-2.5
                                   text-sm font-semibold text-white
                                   transition hover:bg-black
                                   focus:outline-none focus:ring-2
                                   focus:ring-haskon-accent
                                   focus:ring-offset-2"
                        >
                            Terapkan
                        </button>

                        <a
                            href="{{ route('tasks.index') }}"
                            class="inline-flex items-center justify-center
                                   rounded-lg border border-haskon-border
                                   bg-white px-4 py-2.5 text-sm font-semibold
                                   text-haskon-dark transition hover:bg-gray-50"
                        >
                            Reset
                        </a>

                    </div>

                </form>

            </div>


            {{-- ===================================================== --}}
            {{-- TASK LIST --}}
            {{-- ===================================================== --}}

            <div class="haskon-card overflow-hidden">

                <div class="flex flex-col gap-3 border-b border-haskon-border
                            px-5 py-4 sm:flex-row sm:items-center
                            sm:justify-between">

                    <div>

                        <h3 class="text-base font-semibold text-haskon-dark">
                            Daftar Task
                        </h3>

                        <p class="mt-1 text-sm text-haskon-muted">
                            Menampilkan
                            {{ $tasks->firstItem() ?? 0 }}
                            –
                            {{ $tasks->lastItem() ?? 0 }}
                            dari
                            {{ $tasks->total() }}
                            task.
                        </p>

                    </div>

                </div>


                {{-- Desktop Table --}}

                <div class="hidden overflow-x-auto md:block">

                    <table class="min-w-full divide-y divide-haskon-border">

                        <thead class="bg-gray-50">

                            <tr>

                                <th
                                    class="px-5 py-3 text-left text-xs font-semibold
                                           uppercase tracking-wider text-haskon-muted"
                                >
                                    Task
                                </th>

                                <th
                                    class="px-5 py-3 text-left text-xs font-semibold
                                           uppercase tracking-wider text-haskon-muted"
                                >
                                    Group
                                </th>

                                <th
                                    class="px-5 py-3 text-left text-xs font-semibold
                                           uppercase tracking-wider text-haskon-muted"
                                >
                                    Assignee
                                </th>

                                <th
                                    class="px-5 py-3 text-left text-xs font-semibold
                                           uppercase tracking-wider text-haskon-muted"
                                >
                                    Status
                                </th>

                                <th
                                    class="px-5 py-3 text-left text-xs font-semibold
                                           uppercase tracking-wider text-haskon-muted"
                                >
                                    Prioritas
                                </th>

                                <th
                                    class="px-5 py-3 text-left text-xs font-semibold
                                           uppercase tracking-wider text-haskon-muted"
                                >
                                    Deadline
                                </th>

                                <th
                                    class="px-5 py-3 text-right text-xs font-semibold
                                           uppercase tracking-wider text-haskon-muted"
                                >
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-haskon-border bg-white">

                            @forelse ($tasks as $task)

                                @php
                                    $statusLabels = [
                                        'todo' => 'To Do',
                                        'in_progress' => 'In Progress',
                                        'completed' => 'Completed',
                                        'cancelled' => 'Cancelled',
                                    ];

                                    $statusClasses = [
                                        'todo' => 'bg-gray-100 text-gray-700',
                                        'in_progress' => 'bg-blue-50 text-blue-700',
                                        'completed' => 'bg-green-50 text-green-700',
                                        'cancelled' => 'bg-red-50 text-red-700',
                                    ];

                                    $priorityLabels = [
                                        'low' => 'Low',
                                        'medium' => 'Medium',
                                        'high' => 'High',
                                        'urgent' => 'Urgent',
                                    ];

                                    $priorityClasses = [
                                        'low' => 'bg-gray-100 text-gray-700',
                                        'medium' => 'bg-blue-50 text-blue-700',
                                        'high' => 'bg-orange-50 text-orange-700',
                                        'urgent' => 'bg-red-50 text-red-700',
                                    ];

                                    $isOverdue =
                                        $task->due_date !== null
                                        && $task->due_date->isPast()
                                        && ! in_array(
                                            $task->status,
                                            ['completed', 'cancelled']
                                        );
                                @endphp


                                <tr class="transition hover:bg-gray-50">

                                    {{-- Task --}}

                                    <td class="px-5 py-4">

                                        <div class="max-w-xs">

                                            <a
                                                href="{{ route('tasks.show', $task) }}"
                                                class="font-semibold text-haskon-dark
                                                       hover:text-haskon-accent"
                                            >
                                                {{ $task->title }}
                                            </a>

                                            @if ($task->description)

                                                <p
                                                    class="mt-1 truncate text-sm
                                                           text-haskon-muted"
                                                >
                                                    {{ $task->description }}
                                                </p>

                                            @endif

                                        </div>

                                    </td>


                                    {{-- Group --}}

                                    <td class="whitespace-nowrap px-5 py-4 text-sm text-haskon-dark">

                                        {{ $task->group->name }}

                                    </td>


                                    {{-- Assignee --}}

                                    <td class="whitespace-nowrap px-5 py-4">

                                        <div class="text-sm font-medium text-haskon-dark">
                                            {{ $task->assignee->name }}
                                        </div>

                                        <div class="text-xs text-haskon-muted">
                                            {{ $task->creator->name }}
                                            · pembuat
                                        </div>

                                    </td>


                                    {{-- Status --}}

                                    <td class="whitespace-nowrap px-5 py-4">

                                        <span
                                            class="inline-flex rounded-full px-2.5 py-1
                                                   text-xs font-semibold
                                                   {{ $statusClasses[$task->status] ?? 'bg-gray-100 text-gray-700' }}"
                                        >
                                            {{ $statusLabels[$task->status] ?? $task->status }}
                                        </span>

                                    </td>


                                    {{-- Priority --}}

                                    <td class="whitespace-nowrap px-5 py-4">

                                        <span
                                            class="inline-flex rounded-full px-2.5 py-1
                                                   text-xs font-semibold
                                                   {{ $priorityClasses[$task->priority] ?? 'bg-gray-100 text-gray-700' }}"
                                        >
                                            {{ $priorityLabels[$task->priority] ?? $task->priority }}
                                        </span>

                                    </td>


                                    {{-- Deadline --}}

                                    <td class="whitespace-nowrap px-5 py-4">

                                        @if ($task->due_date)

                                            <div class="text-sm
                                                {{ $isOverdue
                                                    ? 'font-semibold text-red-700'
                                                    : 'text-haskon-dark' }}"
                                            >
                                                {{ $task->due_date->format('d M Y') }}
                                            </div>

                                            @if ($isOverdue)

                                                <span class="text-xs font-medium text-red-600">
                                                    Overdue
                                                </span>

                                            @elseif ($task->status === 'completed')

                                                <span class="text-xs text-green-600">
                                                    Selesai
                                                </span>

                                            @endif

                                        @else

                                            <span class="text-sm text-haskon-muted">
                                                Tidak ada deadline
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Actions --}}

                                    <td class="whitespace-nowrap px-5 py-4 text-right">

                                        <div class="inline-flex items-center gap-2">

                                            <a
                                                href="{{ route('tasks.show', $task) }}"
                                                class="text-sm font-medium text-haskon-dark
                                                       hover:text-haskon-accent"
                                            >
                                                Detail
                                            </a>

                                            <a
                                                href="{{ route('tasks.edit', $task) }}"
                                                class="text-sm font-medium text-haskon-muted
                                                       hover:text-haskon-dark"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                method="POST"
                                                action="{{ route('tasks.destroy', $task) }}"
                                                onsubmit="return confirm('Hapus task ini?')"
                                                class="inline"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="text-sm font-medium text-red-600
                                                           hover:text-red-800"
                                                >
                                                    Hapus
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="7"
                                        class="px-5 py-12 text-center"
                                    >

                                        <div class="mx-auto max-w-md">

                                            <div
                                                class="mx-auto flex h-12 w-12
                                                       items-center justify-center
                                                       rounded-full bg-gray-100"
                                            >
                                                <svg
                                                    class="h-6 w-6 text-haskon-muted"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2
                                                           M9 5a3 3 0 006 0"
                                                    />
                                                </svg>
                                            </div>

                                            <h4 class="mt-4 text-sm font-semibold text-haskon-dark">
                                                Belum ada task
                                            </h4>

                                            <p class="mt-1 text-sm text-haskon-muted">
                                                Belum ada task yang sesuai dengan filter.
                                            </p>

                                            <a
                                                href="{{ route('tasks.create') }}"
                                                class="mt-4 inline-flex items-center
                                                       rounded-lg bg-haskon-dark
                                                       px-4 py-2 text-sm font-semibold
                                                       text-white hover:bg-black"
                                            >
                                                Tambah Task
                                            </a>

                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- Mobile Cards --}}

                <div class="space-y-3 p-4 md:hidden">

                    @forelse ($tasks as $task)

                        @php
                            $statusLabels = [
                                'todo' => 'To Do',
                                'in_progress' => 'In Progress',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ];

                            $statusClasses = [
                                'todo' => 'bg-gray-100 text-gray-700',
                                'in_progress' => 'bg-blue-50 text-blue-700',
                                'completed' => 'bg-green-50 text-green-700',
                                'cancelled' => 'bg-red-50 text-red-700',
                            ];

                            $priorityLabels = [
                                'low' => 'Low',
                                'medium' => 'Medium',
                                'high' => 'High',
                                'urgent' => 'Urgent',
                            ];

                            $priorityClasses = [
                                'low' => 'bg-gray-100 text-gray-700',
                                'medium' => 'bg-blue-50 text-blue-700',
                                'high' => 'bg-orange-50 text-orange-700',
                                'urgent' => 'bg-red-50 text-red-700',
                            ];

                            $isOverdue =
                                $task->due_date !== null
                                && $task->due_date->isPast()
                                && ! in_array(
                                    $task->status,
                                    ['completed', 'cancelled']
                                );
                        @endphp


                        <div class="rounded-xl border border-haskon-border bg-white p-4">

                            <div class="flex items-start justify-between gap-3">

                                <div class="min-w-0">

                                    <a
                                        href="{{ route('tasks.show', $task) }}"
                                        class="font-semibold text-haskon-dark
                                               hover:text-haskon-accent"
                                    >
                                        {{ $task->title }}
                                    </a>

                                    <p class="mt-1 text-xs text-haskon-muted">
                                        {{ $task->group->name }}
                                    </p>

                                </div>

                                <span
                                    class="shrink-0 rounded-full px-2.5 py-1
                                           text-xs font-semibold
                                           {{ $statusClasses[$task->status] ?? 'bg-gray-100 text-gray-700' }}"
                                >
                                    {{ $statusLabels[$task->status] ?? $task->status }}
                                </span>

                            </div>


                            <div class="mt-4 grid grid-cols-2 gap-3 text-sm">

                                <div>

                                    <p class="text-xs text-haskon-muted">
                                        Assignee
                                    </p>

                                    <p class="mt-1 font-medium text-haskon-dark">
                                        {{ $task->assignee->name }}
                                    </p>

                                </div>


                                <div>

                                    <p class="text-xs text-haskon-muted">
                                        Prioritas
                                    </p>

                                    <span
                                        class="mt-1 inline-flex rounded-full px-2 py-1
                                               text-xs font-semibold
                                               {{ $priorityClasses[$task->priority] ?? 'bg-gray-100 text-gray-700' }}"
                                    >
                                        {{ $priorityLabels[$task->priority] ?? $task->priority }}
                                    </span>

                                </div>


                                <div>

                                    <p class="text-xs text-haskon-muted">
                                        Deadline
                                    </p>

                                    @if ($task->due_date)

                                        <p
                                            class="mt-1 text-sm
                                                {{ $isOverdue
                                                    ? 'font-semibold text-red-700'
                                                    : 'text-haskon-dark' }}"
                                        >
                                            {{ $task->due_date->format('d M Y') }}
                                        </p>

                                        @if ($isOverdue)

                                            <p class="text-xs text-red-600">
                                                Overdue
                                            </p>

                                        @endif

                                    @else

                                        <p class="mt-1 text-sm text-haskon-muted">
                                            Tidak ada deadline
                                        </p>

                                    @endif

                                </div>


                                <div>

                                    <p class="text-xs text-haskon-muted">
                                        Pembuat
                                    </p>

                                    <p class="mt-1 font-medium text-haskon-dark">
                                        {{ $task->creator->name }}
                                    </p>

                                </div>

                            </div>


                            <div
                                class="mt-4 flex items-center justify-end gap-3
                                       border-t border-haskon-border pt-3"
                            >

                                <a
                                    href="{{ route('tasks.show', $task) }}"
                                    class="text-sm font-medium text-haskon-dark
                                           hover:text-haskon-accent"
                                >
                                    Detail
                                </a>

                                <a
                                    href="{{ route('tasks.edit', $task) }}"
                                    class="text-sm font-medium text-haskon-muted
                                           hover:text-haskon-dark"
                                >
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('tasks.destroy', $task) }}"
                                    onsubmit="return confirm('Hapus task ini?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="text-sm font-medium text-red-600
                                               hover:text-red-800"
                                    >
                                        Hapus
                                    </button>

                                </form>

                            </div>

                        </div>

                    @empty

                        <div class="py-10 text-center">

                            <p class="text-sm text-haskon-muted">
                                Belum ada task yang sesuai dengan filter.
                            </p>

                        </div>

                    @endforelse

                </div>


                {{-- Pagination --}}

                @if ($tasks->hasPages())

                    <div
                        class="border-t border-haskon-border px-5 py-4"
                    >
                        {{ $tasks->links() }}
                    </div>

                @endif

            </div>

        </div>

    </div>

</x-app-layout>