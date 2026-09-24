<x-app-layout>
    <div class="min-h-screen bg-haskon-surface py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <div class="mb-3 h-1 w-16 bg-haskon-accent"></div>

                    <h1 class="text-2xl font-bold tracking-tight text-haskon-dark">
                        Edit Task
                    </h1>

                    <p class="mt-1 text-sm text-haskon-muted">
                        Perbarui informasi task yang dipilih.
                    </p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <a
                        href="{{ route('tasks.show', $task) }}"
                        class="inline-flex items-center justify-center rounded-lg border border-haskon-border bg-white px-4 py-2.5 text-sm font-semibold text-haskon-dark transition hover:bg-gray-50"
                    >
                        Kembali
                    </a>
                </div>
            </div>

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4">
                    <div class="font-semibold text-red-800">
                        Terdapat kesalahan pada form:
                    </div>

                    <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form --}}
            <div class="haskon-card p-6 sm:p-8">

                <form
                    method="POST"
                    action="{{ route('tasks.update', $task) }}"
                    x-data="{
                        groups: @js(
                            $groups->map(fn ($group) => [
                                'id' => $group->id,
                                'name' => $group->name,
                                'users' => $group->users->map(fn ($user) => [
                                    'id' => $user->id,
                                    'name' => $user->name,
                                ])->values(),
                            ])->values()
                        ),

                        selectedGroup: @js(old('group_id', $task->group_id)),
                        selectedUser: @js(old('assigned_to', $task->assigned_to)),

                        get members() {
                            const group = this.groups.find(
                                group => String(group.id) === String(this.selectedGroup)
                            );

                            return group ? group.users : [];
                        },

                        changeGroup() {
                            const exists = this.members.some(
                                user => String(user.id) === String(this.selectedUser)
                            );

                            if (!exists) {
                                this.selectedUser = '';
                            }
                        }
                    }"
                    class="space-y-6"
                >
                    @csrf
                    @method('PUT')

                    {{-- Judul --}}
                    <div>
                        <label
                            for="title"
                            class="block text-sm font-semibold text-haskon-dark"
                        >
                            Judul Task
                        </label>

                        <input
                            id="title"
                            name="title"
                            type="text"
                            value="{{ old('title', $task->title) }}"
                            required
                            maxlength="255"
                            class="mt-2 block w-full rounded-lg border border-haskon-border bg-white px-4 py-3 text-sm text-haskon-dark shadow-sm focus:border-haskon-accent focus:ring-haskon-accent"
                        >

                        @error('title')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label
                            for="description"
                            class="block text-sm font-semibold text-haskon-dark"
                        >
                            Deskripsi
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="5"
                            class="mt-2 block w-full rounded-lg border border-haskon-border bg-white px-4 py-3 text-sm text-haskon-dark shadow-sm focus:border-haskon-accent focus:ring-haskon-accent"
                        >{{ old('description', $task->description) }}</textarea>

                        @error('description')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Group & Assignment --}}
                    <div class="grid gap-6 md:grid-cols-2">

                        {{-- Group --}}
                        <div>
                            <label
                                for="group_id"
                                class="block text-sm font-semibold text-haskon-dark"
                            >
                                Group
                            </label>

                            <select
                                id="group_id"
                                name="group_id"
                                x-model="selectedGroup"
                                @change="changeGroup()"
                                required
                                class="mt-2 block w-full rounded-lg border border-haskon-border bg-white px-4 py-3 text-sm text-haskon-dark shadow-sm focus:border-haskon-accent focus:ring-haskon-accent"
                            >
                                <option value="">
                                    Pilih group
                                </option>

                                @foreach ($groups as $group)
                                    <option value="{{ $group->id }}">
                                        {{ $group->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('group_id')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Assignment --}}
                        <div>
                            <label
                                for="assigned_to"
                                class="block text-sm font-semibold text-haskon-dark"
                            >
                                Ditugaskan Kepada
                            </label>

                            <select
                                id="assigned_to"
                                name="assigned_to"
                                x-model="selectedUser"
                                required
                                :disabled="!selectedGroup || members.length === 0"
                                class="mt-2 block w-full rounded-lg border border-haskon-border bg-white px-4 py-3 text-sm text-haskon-dark shadow-sm disabled:cursor-not-allowed disabled:bg-gray-100 focus:border-haskon-accent focus:ring-haskon-accent"
                            >
                                <option value="">
                                    Pilih anggota
                                </option>

                                <template
                                    x-for="user in members"
                                    :key="user.id"
                                >
                                    <option
                                        :value="user.id"
                                        x-text="user.name"
                                    ></option>
                                </template>
                            </select>

                            <p
                                x-show="!selectedGroup"
                                x-cloak
                                class="mt-2 text-xs text-haskon-muted"
                            >
                                Pilih group terlebih dahulu.
                            </p>

                            <p
                                x-show="selectedGroup && members.length === 0"
                                x-cloak
                                class="mt-2 text-xs text-red-600"
                            >
                                Group ini belum memiliki anggota.
                            </p>

                            <p
                                x-show="selectedGroup && members.length > 0"
                                x-cloak
                                class="mt-2 text-xs text-haskon-muted"
                            >
                                Pilih anggota yang akan bertanggung jawab atas task ini.
                            </p>

                            @error('assigned_to')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>

                    {{-- Status & Priority --}}
                    <div class="grid gap-6 md:grid-cols-2">

                        {{-- Status --}}
                        <div>
                            <label
                                for="status"
                                class="block text-sm font-semibold text-haskon-dark"
                            >
                                Status
                            </label>

                            <select
                                id="status"
                                name="status"
                                class="mt-2 block w-full rounded-lg border border-haskon-border bg-white px-4 py-3 text-sm text-haskon-dark shadow-sm focus:border-haskon-accent focus:ring-haskon-accent"
                            >
                                <option
                                    value="todo"
                                    @selected(old('status', $task->status) === 'todo')
                                >
                                    To Do
                                </option>

                                <option
                                    value="in_progress"
                                    @selected(old('status', $task->status) === 'in_progress')
                                >
                                    In Progress
                                </option>

                                <option
                                    value="completed"
                                    @selected(old('status', $task->status) === 'completed')
                                >
                                    Completed
                                </option>

                                <option
                                    value="cancelled"
                                    @selected(old('status', $task->status) === 'cancelled')
                                >
                                    Cancelled
                                </option>
                            </select>

                            @error('status')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Priority --}}
                        <div>
                            <label
                                for="priority"
                                class="block text-sm font-semibold text-haskon-dark"
                            >
                                Prioritas
                            </label>

                            <select
                                id="priority"
                                name="priority"
                                required
                                class="mt-2 block w-full rounded-lg border border-haskon-border bg-white px-4 py-3 text-sm text-haskon-dark shadow-sm focus:border-haskon-accent focus:ring-haskon-accent"
                            >
                                <option
                                    value="low"
                                    @selected(old('priority', $task->priority) === 'low')
                                >
                                    Low
                                </option>

                                <option
                                    value="medium"
                                    @selected(old('priority', $task->priority) === 'medium')
                                >
                                    Medium
                                </option>

                                <option
                                    value="high"
                                    @selected(old('priority', $task->priority) === 'high')
                                >
                                    High
                                </option>

                                <option
                                    value="urgent"
                                    @selected(old('priority', $task->priority) === 'urgent')
                                >
                                    Urgent
                                </option>
                            </select>

                            @error('priority')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>

                    {{-- Deadline --}}
                    <div>
                        <label
                            for="due_date"
                            class="block text-sm font-semibold text-haskon-dark"
                        >
                            Deadline
                        </label>

                        <input
                            id="due_date"
                            name="due_date"
                            type="date"
                            value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}"
                            class="mt-2 block w-full rounded-lg border border-haskon-border bg-white px-4 py-3 text-sm text-haskon-dark shadow-sm focus:border-haskon-accent focus:ring-haskon-accent"
                        >

                        <p class="mt-2 text-xs text-haskon-muted">
                            Kosongkan jika task tidak memiliki deadline.
                        </p>

                        @error('due_date')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Actions --}}
                    <div class="flex flex-col-reverse gap-3 border-t border-haskon-border pt-6 sm:flex-row sm:justify-between">

                        <a
                            href="{{ route('tasks.show', $task) }}"
                            class="inline-flex items-center justify-center rounded-lg border border-haskon-border bg-white px-5 py-3 text-sm font-semibold text-haskon-dark transition hover:bg-gray-50"
                        >
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-haskon-dark px-5 py-3 text-sm font-semibold text-white transition hover:opacity-90"
                        >
                            Simpan Perubahan
                        </button>

                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>