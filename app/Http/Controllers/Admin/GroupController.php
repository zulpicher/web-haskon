<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::withCount('users', 'tasks')
            ->latest()
            ->paginate(10);

        return view('admin.groups.index', compact('groups'));
    }

    public function create()
    {
        return view('admin.groups.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        Group::create($validated);

        return redirect()
            ->route('admin.groups.index')
            ->with('success', 'Group berhasil dibuat.');
    }

    public function edit(Group $group)
    {
        $group->load('users');

        $availableUsers = User::whereDoesntHave(
            'groups',
            function ($query) use ($group) {
                $query->where('groups.id', $group->id);
            }
        )
            ->orderBy('name')
            ->get();

        return view(
            'admin.groups.edit',
            compact('group', 'availableUsers')
        );
    }

    public function update(Request $request, Group $group)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $group->update($validated);

        return redirect()
            ->route('admin.groups.edit', $group)
            ->with('success', 'Group berhasil diperbarui.');
    }

    public function destroy(Group $group)
    {
        abort_if(
            $group->tasks()->exists(),
            422,
            'Group tidak dapat dihapus karena masih memiliki task.'
        );

        $group->delete();

        return redirect()
            ->route('admin.groups.index')
            ->with('success', 'Group berhasil dihapus.');
    }

    public function addMember(
        Request $request,
        Group $group
    ) {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $group->users()->syncWithoutDetaching([
            $request->user_id
        ]);

        return redirect()
            ->route('admin.groups.edit', $group)
            ->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function removeMember(
        Group $group,
        User $user
    ) {
        $group->users()->detach($user->id);

        return redirect()
            ->route('admin.groups.edit', $group)
            ->with('success', 'Anggota berhasil dikeluarkan dari group.');
    }
}