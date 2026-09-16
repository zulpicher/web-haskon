<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-xl font-bold text-zinc-900">Lupa Password?</h1>
        <p class="text-xs text-zinc-500 mt-1 leading-relaxed">
            Tidak masalah. Masukkan alamat email Anda yang terdaftar, kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Alamat Email')" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" placeholder="nama@haskon.co.id" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full py-3 text-sm">
                {{ __('Kirim Tautan Reset Password') }}
            </x-primary-button>
        </div>

        <div class="pt-4 border-t border-zinc-100 text-center">
            <a href="{{ route('login') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-zinc-600 hover:text-zinc-900 transition">
                &larr; {{ __('Kembali ke halaman login') }}
            </a>
        </div>
    </form>
</x-guest-layout>
