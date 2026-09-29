<div x-cloak x-show="modal === 'delete'" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-zinc-900/50" @click="closeModal()"></div>

    <div x-show="modal === 'delete'" x-transition class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl text-center">
        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-red-100 mb-4">
            <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        
        <h3 class="text-lg font-bold text-zinc-900">Hapus Task?</h3>
        <p class="mt-2 text-sm text-zinc-500">Apakah Anda yakin ingin menghapus <span class="font-semibold text-zinc-800" x-text="task?.title"></span>? Tindakan ini tidak dapat dibatalkan.</p>
        
        <form method="POST" :action="deleteAction" class="mt-6 flex justify-center gap-3">
            @csrf
            @method('DELETE')
            <button type="button" @click="closeModal()" class="rounded-lg border border-zinc-300 bg-white px-5 py-2 font-semibold text-zinc-700 hover:bg-zinc-50">Batal</button>
            <button type="submit" class="rounded-lg bg-red-600 px-5 py-2 font-semibold text-white hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2">Ya, Hapus Task</button>
        </form>
    </div>
</div>