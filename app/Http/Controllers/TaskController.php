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
            'assignees',
            'group',
            'comments.user',
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
        // Mengurutkan berdasarkan status (yang belum selesai di atas)
        // LALU diurutkan berdasarkan prioritas (urgent paling atas)
        $tasks = $query
            ->orderByRaw("FIELD(status, 'in_progress', 'todo', 'completed', 'cancelled')")
            ->orderByRaw("FIELD(priority, 'urgent', 'high', 'medium', 'low')")
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $groups = Group::with('users:id,name')->orderBy('name')->get();

        // Summary seluruh task
        $totalTasks = Task::count();
        $todoTasks = Task::where('status', 'todo')->count();
        $inProgressTasks = Task::where('status', 'in_progress')->count();
        $completedTasks = Task::where('status', 'completed')->count();

        // Perhitungan Overdue yang presisi (H+1 dari due_date)
        $overdueTasks = Task::whereNotNull('due_date')
            ->whereDate('due_date', '<', today())
            ->whereNotIn('status', ['completed', 'cancelled'])
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

    public function store(TaskRequest $request)
    {
        $validated = $request->validated();

        $group = Group::with('users:id,name')
            ->findOrFail($validated['group_id']);

        $groupUserIds = $group->users
            ->pluck('id')
            ->map(fn ($id) => (int) $id);

        $assignedUserIds = collect($validated['assigned_to'])
            ->map(fn ($id) => (int) $id);

        $invalidUsers = $assignedUserIds->diff($groupUserIds);

        abort_if(
            $invalidUsers->isNotEmpty(),
            422,
            'Semua user yang ditugaskan harus menjadi anggota group.'
        );

        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'created_by' => $request->user()->id,
            'group_id' => $validated['group_id'],
            'status' => $validated['status'] ?? 'todo',
            'priority' => $validated['priority'],
            'due_date' => $validated['due_date'] ?? null,
        ]);

        $task->assignees()->sync($assignedUserIds);

        return redirect()
            ->route('tasks.index', $task)
            ->with('success', 'Task berhasil dibuat.');
    }


    public function update(TaskRequest $request, Task $task)
    {
        $validated = $request->validated();

        $group = Group::with('users:id,name')
            ->findOrFail($validated['group_id']);

        $groupUserIds = $group->users
            ->pluck('id')
            ->map(fn ($id) => (int) $id);

        $assignedUserIds = collect($validated['assigned_to'])
            ->map(fn ($id) => (int) $id);

        $invalidUsers = $assignedUserIds->diff($groupUserIds);

        abort_if(
            $invalidUsers->isNotEmpty(),
            422,
            'Semua user yang ditugaskan harus menjadi anggota group.'
        );

        $completedAt = null;

        if (($validated['status'] ?? null) === 'completed') {
            $completedAt = $task->completed_at ?? now();
        }

        $task->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'group_id' => $validated['group_id'],
            'status' => $validated['status'] ?? $task->status,
            'priority' => $validated['priority'],
            'due_date' => $validated['due_date'] ?? null,
            'completed_at' => $completedAt,
        ]);

        $task->assignees()->sync($assignedUserIds);

        return redirect()
            ->route('tasks.index', $task)
            ->with('success', 'Task berhasil diperbarui.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task berhasil dihapus.');
    }

    public function updateStatus(Request $request, Task $task)
    {
        // Otorisasi: Hanya Admin atau user yang ditugaskan (Assignee) yang bisa mengubah
        abort_unless(
            $request->user()->isAdmin() || $task->assignees->contains('id', $request->user()->id),
            403,
            'Anda tidak memiliki izin untuk mengubah status task ini.'
        );

        $validated = $request->validate([
            'status' => 'required|in:todo,in_progress,completed,cancelled'
        ]);

        $completedAt = $validated['status'] === 'completed' ? now() : null;

        $task->update([
            'status' => $validated['status'],
            'completed_at' => $completedAt,
        ]);

        return redirect()->back()->with('success', 'Status task berhasil diperbarui.');
    }
}