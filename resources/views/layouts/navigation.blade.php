<nav
    x-data="{ open: false }"
    class="bg-zinc-900 border-b border-zinc-800 text-white shadow-sm"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- ================================================= --}}
            {{-- LEFT SIDE --}}
            {{-- ================================================= --}}
            <div class="flex items-center">

                {{-- Logo --}}
                <div class="shrink-0 flex items-center">
                    <a
                        href="{{ route('dashboard') }}"
                        class="flex items-center gap-3"
                    >
                        <div class="p-1 rounded-lg bg-white/10 border border-white/10 flex items-center justify-center">
                            <x-application-logo
                                class="block h-7 w-auto"
                            />
                        </div>

                        <span class="hidden sm:block font-bold tracking-wider text-sm text-white">
                            PT HASKON CITRA PERDANA
                        </span>
                    </a>
                </div>

                {{-- Navigation Links --}}
                <div class="hidden sm:flex sm:items-center sm:ms-10 sm:gap-2">

                    {{-- Beranda --}}
                    <a
                        href="{{ route('dashboard') }}"
                        class="
                            inline-flex items-center px-3.5 py-2 rounded-lg
                            text-sm font-medium
                            transition duration-150
                            {{ request()->routeIs('dashboard')
                                ? 'bg-zinc-800 text-amber-400 font-semibold border border-zinc-700/80 shadow-inner'
                                : 'text-zinc-400 hover:text-white hover:bg-zinc-800/60'
                            }}
                        "
                    >
                        Beranda
                    </a>

                    {{-- Buku Kas --}}
                    <a
                        href="{{ route('buku-kas.dashboard') }}"
                        class="
                            inline-flex items-center px-3.5 py-2 rounded-lg
                            text-sm font-medium
                            transition duration-150
                            {{ request()->routeIs('buku-kas.*')
                                ? 'bg-zinc-800 text-amber-400 font-semibold border border-zinc-700/80 shadow-inner'
                                : 'text-zinc-400 hover:text-white hover:bg-zinc-800/60'
                            }}
                        "
                    >
                        Buku Kas
                    </a>

                </div>
            </div>

            {{-- ================================================= --}}
            {{-- RIGHT SIDE --}}
            {{-- ================================================= --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">

                <x-dropdown align="right" width="48" content-classes="py-1.5 bg-zinc-900 border border-zinc-700/90 rounded-xl shadow-xl">

                    <x-slot name="trigger">

                        <button
                            class="
                                inline-flex items-center gap-2.5
                                px-3 py-1.5
                                rounded-lg
                                text-sm font-medium
                                text-zinc-200
                                bg-zinc-800/90
                                hover:bg-zinc-800
                                hover:text-white
                                border border-zinc-700/70
                                focus:outline-none
                                focus:ring-2
                                focus:ring-amber-400
                                transition duration-150
                            "
                        >

                            {{-- User Initial --}}
                            <span
                                class="
                                    inline-flex items-center justify-center
                                    w-7 h-7
                                    rounded-full
                                    bg-amber-400
                                    text-zinc-950
                                    text-xs font-bold
                                    shadow-xs
                                "
                            >
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>

                            <span class="font-medium text-zinc-200">
                                {{ Auth::user()->name }}
                            </span>

                            <svg
                                class="w-4 h-4 text-zinc-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"
                                />
                            </svg>

                        </button>

                    </x-slot>

                    <x-slot name="content">

                        {{-- Profile --}}
                        <x-dropdown-link
                            :href="route('profile.edit')"
                            class="text-zinc-200 hover:bg-zinc-800 hover:text-white"
                        >
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        {{-- Logout --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link
                                :href="route('logout')"
                                class="text-red-400 hover:bg-zinc-800 hover:text-red-300"
                                onclick="
                                    event.preventDefault();
                                    this.closest('form').submit();
                                "
                            >
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>

                    </x-slot>

                </x-dropdown>

            </div>

            {{-- ================================================= --}}
            {{-- MOBILE BUTTON --}}
            {{-- ================================================= --}}
            <div class="-me-2 flex items-center sm:hidden">

                <button
                    @click="open = ! open"
                    class="
                        inline-flex items-center justify-center
                        p-2 rounded-lg
                        text-zinc-400
                        hover:text-white
                        hover:bg-zinc-800
                        focus:outline-none
                        focus:ring-2
                        focus:ring-amber-400
                        transition duration-150
                    "
                >

                    <svg
                        class="h-6 w-6"
                        stroke="currentColor"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <path
                            :class="{ 'hidden': open, 'inline-flex': !open }"
                            class="inline-flex"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />

                        <path
                            :class="{ 'hidden': !open, 'inline-flex': open }"
                            class="hidden"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>

                </button>

            </div>

        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- MOBILE NAVIGATION --}}
    {{-- ========================================================= --}}
    <div
        :class="{ 'block': open, 'hidden': !open }"
        class="hidden sm:hidden border-t border-zinc-800 bg-zinc-900"
    >

        {{-- Navigation Links --}}
        <div class="px-4 pt-3 pb-3 space-y-1">

            {{-- Beranda --}}
            <a
                href="{{ route('dashboard') }}"
                class="
                    block px-4 py-2.5 rounded-lg
                    text-sm font-semibold
                    transition
                    {{ request()->routeIs('dashboard')
                        ? 'bg-zinc-800 text-amber-400 border border-zinc-700/80'
                        : 'text-zinc-400 hover:text-white hover:bg-zinc-800/60'
                    }}
                "
            >
                Beranda
            </a>

            {{-- Buku Kas --}}
            <a
                href="{{ route('buku-kas.dashboard') }}"
                class="
                    block px-4 py-2.5 rounded-lg
                    text-sm font-semibold
                    transition
                    {{ request()->routeIs('buku-kas.*')
                        ? 'bg-zinc-800 text-amber-400 border border-zinc-700/80'
                        : 'text-zinc-400 hover:text-white hover:bg-zinc-800/60'
                    }}
                "
            >
                Buku Kas
            </a>

        </div>

        {{-- Mobile User --}}
        <div class="pt-4 pb-3 border-t border-zinc-800">

            <div class="px-4">

                <div class="flex items-center gap-3">

                    <span
                        class="
                            inline-flex items-center justify-center
                            w-10 h-10
                            rounded-full
                            bg-amber-400
                            text-zinc-950
                            text-sm font-bold
                        "
                    >
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </span>

                    <div>
                        <div class="font-semibold text-sm text-zinc-100">
                            {{ Auth::user()->name }}
                        </div>

                        <div class="text-xs text-zinc-400">
                            {{ Auth::user()->email }}
                        </div>
                    </div>

                </div>

            </div>

            <div class="mt-3 px-4 space-y-1">

                {{-- Profile --}}
                <a
                    href="{{ route('profile.edit') }}"
                    class="
                        block px-4 py-2.5 rounded-lg
                        text-sm font-medium
                        text-zinc-300
                        hover:bg-zinc-800
                        hover:text-white
                        transition
                    "
                >
                    Profile
                </a>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button
                        type="submit"
                        class="
                            w-full text-left
                            px-4 py-2.5 rounded-lg
                            text-sm font-medium
                            text-red-400
                            hover:bg-zinc-800
                            hover:text-red-300
                            transition
                        "
                    >
                        Log Out
                    </button>
                </form>

            </div>

        </div>

    </div>
</nav>
