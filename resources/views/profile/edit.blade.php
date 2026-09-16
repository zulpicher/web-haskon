<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-zinc-200/80 pb-6">
            <div>
                <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-md bg-zinc-900 text-white text-[11px] font-bold uppercase tracking-wider mb-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                    Pengaturan Akun
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-zinc-900">
                    Profil Pengguna
                </h1>
                <p class="text-sm text-zinc-500 mt-1">
                    Kelola data personal, kredensial keamanan kata sandi, dan privasi akun Anda.
                </p>
            </div>
        </div>

        {{-- Cards Grid --}}
        <div class="space-y-6">
            {{-- Update Profile Info Card --}}
            <div class="bg-white border border-zinc-200 shadow-xs rounded-2xl p-6 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Update Password Card --}}
            <div class="bg-white border border-zinc-200 shadow-xs rounded-2xl p-6 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Delete User Card --}}
            <div class="bg-white border border-rose-200/80 shadow-xs rounded-2xl p-6 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
