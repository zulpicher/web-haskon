<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-xl font-bold text-zinc-900">DAFTAR AKUN BARU</h1>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" class="block w-full" type="text" name="name" :value="old('name')" placeholder="Nama Anda" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Alamat Email')" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" placeholder="nama@haskon.co.id" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block w-full"
                            type="password"
                            name="password"
                            placeholder="Minimal 8 karakter"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <x-text-input id="password_confirmation" class="block w-full"
                            type="password"
                            name="password_confirmation"
                            placeholder="Ulangi password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full py-3 text-sm">
                {{ __('Daftar Akun') }}
            </x-primary-button>
        </div>

        <div class="pt-4 border-t border-zinc-100 text-center">
            <p class="text-xs text-zinc-500">
                Sudah memiliki akun?
                <a href="{{ route('login') }}" class="font-bold text-zinc-900 hover:text-amber-600 transition">
                    Masuk di sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
