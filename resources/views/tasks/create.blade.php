<x-app-layout>
    <div class="min-h-screen bg-haskon-surface py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8">
                <div class="mb-3 h-1 w-16 bg-haskon-accent"></div>

                <h1 class="text-2xl font-bold tracking-tight text-haskon-dark">
                    Tambah Task
                </h1>

                <p class="mt-1 text-sm text-haskon-muted">
                    Buat task baru dan tentukan anggota yang bertanggung jawab.
                </p>
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
                    action="{{ route('tasks.store') }}"
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

                        selectedGroup: @js(old('group_id', '')),
                        selectedAssignees: @js(array_map('intval', (array) old('assigned_to', []))),

                        get selectedGroupUsers() {
                            const group = this.groups.find(
                                group => String(group.id) === String(this.selectedGroup)
                            );

                            return group ? group.users : [];
                        },

                        isUserSelected(userId) {
                            return this.selectedAssignees.includes(Number(userId));
                        },

                        changeGroup() {
                            this.selectedAssignees = [];
                        }
                    }"
                    class="space-y-6"
                >
                    @csrf

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
                            value="{{ old('title') }}"
                            required
                            autofocus
                            maxlength="255"
                            placeholder="Contoh: Setup Server Development"
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
                            placeholder="Jelaskan detail task..."
                            class="mt-2 block w-full rounded-lg border border-haskon-border bg-white px-4 py-3 text-sm text-haskon-dark shadow-sm focus:border-haskon-accent focus:ring-haskon-accent"
                        >{{ old('description') }}</textarea>

                        @error('description')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

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

                    {{-- Ditugaskan Kepada (Checkbox List) --}}
                    <div>
                        <label class="block text-sm font-semibold text-haskon-dark">
                            Ditugaskan kepada
                        </label>

                        <p class="mt-1 text-xs text-gray-500">
                            Pilih satu atau lebih anggota dari group yang dipilih.
                        </p>

                        <div
                            class="mt-3 rounded-lg border border-gray-200 bg-gray-50 p-3"
                            x-show="selectedGroupUsers.length > 0"
                            x-cloak
                        >
                            <div class="space-y-2">
                                <template
                                    x-for="user in selectedGroupUsers"
                                    :key="user.id"
                                >
                                    <label
                                        class="flex cursor-pointer items-center gap-3 rounded-lg border border-gray-200 bg-white p-3 transition hover:border-gray-400"
                                        :class="isUserSelected(user.id)
                                            ? 'border-black bg-gray-50'
                                            : ''"
                                    >
                                        <input
                                            type="checkbox"
                                            name="assigned_to[]"
                                            :value="user.id"
                                            x-model="selectedAssignees"
                                            class="h-4 w-4 rounded border-gray-300 text-black focus:ring-black"
                                        >

                                        <div class="flex-1">
                                            <div
                                                class="text-sm font-medium text-gray-900"
                                                x-text="user.name"
                                            ></div>

                                            <div class="text-xs text-gray-500">
                                                Anggota group
                                            </div>
                                        </div>

                                        <span
                                            x-show="isUserSelected(user.id)"
                                            class="text-xs font-medium text-gray-700"
                                        >
                                            Dipilih
                                        </span>
                                    </label>
                                </template>
                            </div>
                        </div>

                        <div
                            x-show="selectedGroupUsers.length === 0"
                            x-cloak
                            class="mt-3 rounded-lg border border-dashed border-gray-300 bg-gray-50 p-4 text-sm text-gray-500"
                        >
                            Pilih group terlebih dahulu untuk melihat anggota.
                        </div>

                        <div
                            x-show="selectedAssignees.length > 0"
                            x-cloak
                            class="mt-2 text-xs text-gray-600"
                        >
                            <span x-text="selectedAssignees.length"></span>
                            anggota dipilih.
                        </div>

                        @error('assigned_to')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                        @error('assigned_to.*')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
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
                                    @selected(old('status', 'todo') === 'todo')
                                >
                                    To Do
                                </option>

                                <option
                                    value="in_progress"
                                    @selected(old('status') === 'in_progress')
                                >
                                    In Progress
                                </option>

                                <option
                                    value="completed"
                                    @selected(old('status') === 'completed')
                                >
                                    Completed
                                </option>

                                <option
                                    value="cancelled"
                                    @selected(old('status') === 'cancelled')
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
                                    @selected(old('priority') === 'low')
                                >
                                    Low
                                </option>

                                <option
                                    value="medium"
                                    @selected(old('priority', 'medium') === 'medium')
                                >
                                    Medium
                                </option>

                                <option
                                    value="high"
                                    @selected(old('priority') === 'high')
                                >
                                    High
                                </option>

                                <option
                                    value="urgent"
                                    @selected(old('priority') === 'urgent')
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
                            value="{{ old('due_date') }}"
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
                    <div class="flex flex-col-reverse gap-3 border-t border-haskon-border pt-6 sm:flex-row sm:justify-end">

                        <a
                            href="{{ route('tasks.index') }}"
                            class="inline-flex items-center justify-center rounded-lg border border-haskon-border bg-white px-5 py-3 text-sm font-semibold text-haskon-dark transition hover:bg-gray-50"
                        >
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-haskon-dark px-5 py-3 text-sm font-semibold text-white transition hover:opacity-90"
                        >
                            Simpan Task
                        </button>

                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>