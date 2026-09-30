<div x-cloak x-show="modal === 'detail'" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-zinc-900/50" @click="closeModal()"></div>

    <div x-show="modal === 'detail'" x-transition class="relative w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-2xl">
        <div class="flex items-center justify-between border-b border-zinc-200 px-6 py-4">
            <div>
                <h3 class="text-lg font-semibold text-zinc-900">Detail Task</h3>
                <p class="mt-1 text-sm text-zinc-500">Informasi ringkas dan diskusi task.</p>
            </div>
            <button type="button" @click="closeModal()" class="text-zinc-400 hover:text-zinc-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="p-6 space-y-5 overflow-y-auto max-h-[70vh]">
            
            {{-- Informasi Utama --}}
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
                    <span class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Status</span>
                    <div class="mt-1">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-zinc-100 text-zinc-800" x-text="task?.status ? task.status.replace('_', ' ').toUpperCase() : '-'"></span>
                    </div>
                </div>
            </div>

            <div class="pt-3 border-t border-zinc-100">
                <span class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Anggota Ditugaskan</span>
                <div class="mt-2 flex flex-wrap gap-1.5">
                    <template x-if="task?.assignees && task.assignees.length > 0">
                        <template x-for="assignee in task.assignees" :key="assignee.id">
                            <span class="inline-flex items-center gap-1 rounded-full bg-zinc-100 px-3 py-1.5 text-xs font-medium text-zinc-800">
                                <svg class="w-3 h-3 text-zinc-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>
                                <span x-text="assignee.name"></span>
                            </span>
                        </template>
                    </template>
                    <template x-if="!task?.assignees || task.assignees.length === 0">
                        <p class="text-sm text-zinc-500">Belum ada penugasan.</p>
                    </template>
                </div>
            </div>

            {{-- ========================================== --}}
            {{-- BAGIAN DISKUSI & KOMENTAR --}}
            {{-- ========================================== --}}
            <div class="pt-5 border-t border-zinc-200 mt-5">
                <h4 class="text-sm font-bold text-zinc-900 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    Diskusi & Komentar
                </h4>

                {{-- Daftar Komentar --}}
                <div class="space-y-3 mb-5 max-h-48 overflow-y-auto pr-2">
                    <template x-if="task?.comments && task.comments.length > 0">
                        <template x-for="comment in task.comments" :key="comment.id">
                            <div class="bg-zinc-50 rounded-xl p-3.5 border border-zinc-100">
                                <div class="flex justify-between items-center mb-1.5">
                                    <span class="text-xs font-bold text-zinc-900" x-text="comment.user?.name"></span>
                                    <span class="text-[10px] font-medium text-zinc-400" x-text="new Date(comment.created_at).toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute:'2-digit'})"></span>
                                </div>
                                <p class="text-sm text-zinc-700 whitespace-pre-line" x-text="comment.comment"></p>
                                
                                {{-- Jika ada file lampiran --}}
                                <template x-if="comment.attachment_path">
                                    <div class="mt-3 flex flex-col gap-2">
                                        {{-- Preview Langsung Khusus Gambar (PNG/JPG) --}}
                                        <template x-if="comment.attachment_mime && comment.attachment_mime.startsWith('image/')">
                                            <div class="rounded-lg border border-zinc-200 overflow-hidden bg-zinc-100 max-w-xs shadow-sm">
                                                <img :src="`/storage/${comment.attachment_path}`" alt="Lampiran Gambar" class="w-full h-auto object-cover max-h-48 hover:opacity-90 transition-opacity cursor-pointer" onclick="window.open(this.src, '_blank')">
                                            </div>
                                        </template>

                                        {{-- Tombol Download Elegan (Tampil untuk semua tipe file) menggunakan URL yang benar --}}
                                        <a :href="`/tasks/comments/${comment.id}/attachment`" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-600 hover:text-amber-700 bg-amber-50 px-2.5 py-1.5 rounded-md border border-amber-100 w-fit transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                            <span x-text="comment.attachment_name"></span>
                                        </a>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </template>
                    
                    <template x-if="!task?.comments || task.comments.length === 0">
                        <div class="text-center py-4 bg-zinc-50/50 rounded-xl border border-dashed border-zinc-200">
                            <p class="text-xs text-zinc-500 font-medium">Belum ada komentar.</p>
                        </div>
                    </template>
                </div>

                {{-- Form Tambah Komentar --}}
                <form method="POST" :action="`/tasks/${task?.id}/comments`" enctype="multipart/form-data">
                    @csrf
                    <textarea name="comment" rows="2" required class="w-full rounded-xl border-zinc-300 focus:border-amber-400 focus:ring-amber-400 text-sm shadow-sm" placeholder="Tulis komentar..."></textarea>
                    
                    <div class="mt-3 flex items-center justify-between">
                        {{-- Input File Custom --}}
                        <input type="file" name="attachment" class="text-xs text-zinc-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-zinc-100 file:text-zinc-700 hover:file:bg-zinc-200 cursor-pointer">
                        
                        <button type="submit" class="bg-zinc-900 text-white text-xs font-semibold px-4 py-2 rounded-lg hover:bg-zinc-800 focus:ring-2 focus:ring-amber-400 transition shadow-sm">
                            Kirim
                        </button>
                    </div>
                </form>
            </div>
            
        </div>

        <div class="border-t border-zinc-200 px-6 py-4 bg-zinc-50 text-right">
            <button type="button" @click="closeModal()" class="rounded-lg border border-zinc-300 bg-white px-5 py-2.5 font-semibold text-sm text-zinc-700 hover:bg-zinc-50 shadow-sm">Tutup Panel</button>
        </div>
    </div>
</div>