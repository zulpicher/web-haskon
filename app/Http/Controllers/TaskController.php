<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Group;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function index(Request $request)
    {
        $query = Task::with([
            'creator',
            'assignee',
            'group',
        ]);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('group_id')) {
            $query->where('group_id', $request->group_id);
        }

        $tasks = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $groups = Group::orderBy('name')->get();

        // Summary seluruh task
        $totalTasks = Task::count();

        $todoTasks = Task::where('status', 'todo')->count();

        $inProgressTasks = Task::where(
            'status',
            'in_progress'
        )->count();

        $completedTasks = Task::where(
            'status',
            'completed'
        )->count();

        $overdueTasks = Task::whereNotNull('due_date')
            ->whereDate('due_date', '<', now()->toDateString())
            ->whereNotIn('status', [
                'completed',
                'cancelled',
            ])
            ->count();

        return view('tasks.index', compact(
            'tasks',
            'groups',
            'totalTasks',
            'todoTasks',
            'inProgressTasks',
            'completedTasks',
            'overdueTasks'
        ));
    }

    public function create()
    {
        $groups = Group::with('users')
            ->orderBy('name')
            ->get();

        return view('tasks.create', compact('groups'));
    }

    public function store(TaskRequest $request)
    {
        $validated = $request->validated();

        $group = Group::with('users:id,name')
            ->findOrFail($validated['group_id']);

        abort_unless(
            $group->users->contains(
                'id',
                $validated['assigned_to']
            ),
            422,
            'User yang ditugaskan harus menjadi anggota group.'
        );

        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'created_by' => $request->user()->id,
            'assigned_to' => $validated['assigned_to'],
            'group_id' => $validated['group_id'],
            'status' => $validated['status'] ?? 'todo',
            'priority' => $validated['priority'],
            'due_date' => $validated['due_date'] ?? null,
        ]);

        return redirect()
            ->route('tasks.show', $task)
            ->with('success', 'Task berhasil dibuat.');
    }

    public function show(Task $task) 
    {
        $task->load([
            'creator',
            'assignee',
            'group',
            'comments.user',
        ]);

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $groups = Group::with('users')
            ->orderBy('name')
            ->get();

        return view('tasks.edit', compact(
            'task',
            'groups'
        ));
    }

    public function update(
        TaskRequest $request,
        Task $task
    ) {
        $validated = $request->validated();

        $group = Group::with('users')
            ->findOrFail($validated['group_id']);

        abort_unless(
            $group->users->contains(
                'id',
                $validated['assigned_to']
            ),
            422,
            'User yang ditugaskan harus menjadi anggota group.'
        );

        $completedAt = null;

        if (($validated['status'] ?? null) === 'completed') {
            $completedAt = $task->completed_at
                ?? now();
        }

        $task->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'assigned_to' => $validated['assigned_to'],
            'group_id' => $validated['group_id'],
            'status' => $validated['status'] ?? $task->status,
            'priority' => $validated['priority'],
            'due_date' => $validated['due_date'] ?? null,
            'completed_at' => $completedAt,
        ]);

        return redirect()
            ->route('tasks.show', $task)
            ->with('success', 'Task berhasil diperbarui.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task berhasil dihapus.');
    }
}