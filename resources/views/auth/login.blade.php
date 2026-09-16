<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-xl font-bold text-zinc-900">LOGIN</h1>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email"
                class="block w-full"
                type="email"
                name="email"
                :value="old('email')"
                placeholder="nama@haskon.co.id"
                required
                autofocus
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Password')" />
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-zinc-600 hover:text-amber-600 transition" href="{{ route('password.request') }}">
                        {{ __('Lupa password?') }}
                    </a>
                @endif
            </div>

            <x-text-input id="password"
                class="block w-full"
                type="password"
                name="password"
                placeholder="••••••••"
                required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox"
                    class="rounded-md border-zinc-300 text-zinc-900 shadow-xs focus:ring-amber-400 focus:ring-offset-0 h-4 w-4"
                    name="remember">
                <span class="ms-2 text-xs font-medium text-zinc-600">{{ __('Ingat saya') }}</span>
            </label>
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full py-3 text-sm">
                {{ __('Masuk Sekarang') }}
            </x-primary-button>
        </div>

        @if (Route::has('register'))
            <div class="pt-4 border-t border-zinc-100 text-center">
                <p class="text-xs text-zinc-500">
                    Belum memiliki akun?
                    <a href="{{ route('register') }}" class="font-bold text-zinc-900 hover:text-amber-600 transition">
                        Daftar akun baru
                    </a>
                </p>
            </div>
        @endif
    </form>
</x-guest-layout>
