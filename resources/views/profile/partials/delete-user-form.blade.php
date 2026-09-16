<section class="space-y-6">
    <header>
        <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded bg-rose-50 text-rose-700 border border-rose-200 text-[11px] font-bold uppercase tracking-wider mb-2">
            Zona Berbahaya
        </div>
        <h2 class="text-base font-bold text-zinc-900">
            {{ __('Hapus Akun Pengguna') }}
        </h2>

        <p class="mt-1 text-xs text-zinc-500 leading-relaxed">
            {{ __('Setelah akun Anda dihapus, semua data dan riwayat terkait akun ini akan dihapus permanen. Pastikan Anda telah mengamankan data yang Anda perlukan sebelum melanjutkan.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Hapus Akun') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 sm:p-8">
            @csrf
            @method('delete')

            <div class="flex items-center gap-3 mb-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-rose-50 text-rose-600 border border-rose-100">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-zinc-900">
                        {{ __('Konfirmasi Penghapusan Akun') }}
                    </h2>
                    <p class="text-xs text-zinc-500">
                        {{ __('Tindakan ini permanen dan tidak dapat dipulihkan.') }}
                    </p>
                </div>
            </div>

            <p class="text-xs text-zinc-600 leading-relaxed">
                {{ __('Silakan masukkan kata sandi akun Anda untuk mengonfirmasi bahwa Anda benar-benar ingin menghapus akun ini secara permanen.') }}
            </p>

            <div class="mt-4">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full sm:w-3/4"
                    placeholder="{{ __('Masukkan kata sandi Anda') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1.5" />
            </div>

            <div class="mt-6 flex items-center justify-end gap-3 pt-4 border-t border-zinc-100">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button>
                    {{ __('Ya, Hapus Akun') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
