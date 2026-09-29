<div x-cloak x-show="modal === 'edit'" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-zinc-900/50" @click="closeModal()"></div>

    <div x-show="modal === 'edit'" x-transition class="relative w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-2xl">
        <div class="flex items-center justify-between border-b border-zinc-200 px-6 py-4">
            <div>
                <h3 class="text-lg font-semibold text-zinc-900">Edit Task</h3>
                <p class="mt-1 text-sm text-zinc-500">Perbarui rincian tugas dan penugasan.</p>
            </div>
            <button type="button" @click="closeModal()" class="text-zinc-400 hover:text-zinc-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form method="POST" :action="editAction" class="p-6 overflow-y-auto max-h-[75vh]">
            @csrf
            @method('PUT')

            <div class="space-y-5">
                {{-- Judul --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-zinc-800">Judul Task</label>
                    <input type="text" name="title" :value="task?.title" required class="w-full rounded-lg border-zinc-300 focus:border-amber-400 focus:ring-amber-400">
                </div>

                <div class="grid grid-cols-2 gap-5">
                    {{-- Group --}}
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-zinc-800">Group</label>
                        <select name="group_id" x-model="editGroup" @change="changeEditGroup()" required class="w-full rounded-lg border-zinc-300 focus:border-amber-400 focus:ring-amber-400">
                            <option value="">Pilih Group</option>
                            <template x-for="group in groups" :key="group.id">
                                <option :value="group.id" x-text="group.name"></option>
                            </template>
                        </select>
                    </div>

                    {{-- Multi Assignee --}}
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-zinc-800">Ditugaskan Kepada</label>
                        <div class="max-h-32 overflow-y-auto rounded-lg border border-zinc-300 p-2 space-y-1">
                            <template x-if="editMembers.length === 0">
                                <span class="text-xs text-zinc-500">Tidak ada anggota</span>
                            </template>
                            <template x-for="user in editMembers" :key="user.id">
                                <label class="flex items-center gap-2 text-sm text-zinc-700 cursor-pointer p-1 hover:bg-zinc-50">
                                    <input type="checkbox" name="assigned_to[]" :value="user.id" x-model="editUsers" class="rounded border-zinc-300 text-zinc-900 focus:ring-amber-400">
                                    <span x-text="user.name"></span>
                                </label>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- Status & Deadline --}}
                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-zinc-800">Status</label>
                        <select name="status" :value="task?.status" class="w-full rounded-lg border-zinc-300 focus:border-amber-400 focus:ring-amber-400">
                            <option value="todo">To Do</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-zinc-800">Prioritas</label>
                        <select name="priority" :value="task?.priority" class="w-full rounded-lg border-zinc-300 focus:border-amber-400 focus:ring-amber-400">
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                            <option value="urgent">Urgent</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3 border-t border-zinc-200 pt-5">
                <button type="button" @click="closeModal()" class="rounded-lg border border-zinc-300 bg-white px-4 py-2 font-semibold text-zinc-700 hover:bg-zinc-50">Batal</button>
                <button type="submit" class="rounded-lg bg-zinc-900 px-4 py-2 font-semibold text-white hover:bg-zinc-800 focus:ring-2 focus:ring-amber-400">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>