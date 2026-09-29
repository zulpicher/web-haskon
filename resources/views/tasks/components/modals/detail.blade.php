<div x-cloak x-show="modal === 'detail'" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-zinc-900/50" @click="closeModal()"></div>

    <div x-show="modal === 'detail'" x-transition class="relative w-full max-w-xl overflow-hidden rounded-2xl bg-white shadow-2xl">
        <div class="flex items-center justify-between border-b border-zinc-200 px-6 py-4">
            <div>
                <h3 class="text-lg font-semibold text-zinc-900">Detail Task</h3>
                <p class="mt-1 text-sm text-zinc-500">Informasi ringkas mengenai tugas yang dipilih.</p>
            </div>
            <button type="button" @click="closeModal()" class="text-zinc-400 hover:text-zinc-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="p-6 space-y-5 overflow-y-auto max-h-[75vh]">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Judul Task</span>
                <h4 class="text-xl font-bold text-zinc-900 mt-1" x-text="task?.title"></h4>
            </div>

            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Deskripsi</span>
                <p class="text-sm text-zinc-700 mt-1 whitespace-pre-line" x-text="task?.description || 'Tidak ada deskripsi.'"></p>
            </div>

            <div class="grid grid-cols-2 gap-4 pt-3 border-t border-zinc-100">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Group</span>
                    <p class="text-sm font-medium text-zinc-900 mt-1" x-text="task?.group?.name || '-'"></p>
                </div>
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Pembuat</span>
                    <p class="text-sm font-medium text-zinc-900 mt-1" x-text="task?.creator?.name || '-'"></p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 pt-3 border-t border-zinc-100">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Status</span>
                    <div class="mt-1">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-zinc-100 text-zinc-800" x-text="task?.status ? task.status.replace('_', ' ').toUpperCase() : '-'"></span>
                    </div>
                </div>
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Prioritas</span>
                    <div class="mt-1">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800" x-text="task?.priority ? task.priority.toUpperCase() : '-'"></span>
                    </div>
                </div>
            </div>

            <div class="pt-3 border-t border-zinc-100">
                <span class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Anggota Ditugaskan</span>
                <div class="mt-2 flex flex-wrap gap-1.5">
                    <template x-if="task?.assignees && task.assignees.length > 0">
                        <template x-for="assignee in task.assignees" :key="assignee.id">
                            <span class="inline-flex items-center rounded-full bg-zinc-100 px-3 py-1 text-xs font-medium text-zinc-800" x-text="assignee.name"></span>
                        </template>
                    </template>
                    <template x-if="!task?.assignees || task.assignees.length === 0">
                        <p class="text-sm text-zinc-500">Belum ada penugasan.</p>
                    </template>
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center border-t border-zinc-200 px-6 py-4 bg-zinc-50">
            <template x-if="task?.id">
                <a :href="'/tasks/' + task.id" class="text-sm font-semibold text-amber-600 hover:text-amber-700 inline-flex items-center gap-1">
                    Halaman Diskusi & Komentar →
                </a>
            </template>
            <button type="button" @click="closeModal()" class="rounded-lg border border-zinc-300 bg-white px-4 py-2 font-semibold text-zinc-700 hover:bg-zinc-50">Tutup</button>
        </div>
    </div>
</div>