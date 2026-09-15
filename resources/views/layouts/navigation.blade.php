<nav
    x-data="{ open: false }"
    class="bg-white border-b border-haskon-border"
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
                        <x-application-logo
                            class="block h-9 w-auto fill-current text-haskon-primary"
                        />

                        <span class="hidden sm:block font-bold tracking-wide text-haskon-primary">
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
                            inline-flex items-center px-4 py-2 rounded-lg
                            text-sm font-semibold
                            transition duration-150
                            {{ request()->routeIs('dashboard')
                                ? 'bg-haskon-accent-soft text-haskon-primary'
                                : 'text-haskon-muted hover:text-haskon-primary hover:bg-haskon-surface'
                            }}
                        "
                    >
                        Beranda
                    </a>

                    {{-- Buku Kas --}}
                    <a
                        href="{{ route('buku-kas.dashboard') }}"
                        class="
                            inline-flex items-center px-4 py-2 rounded-lg
                            text-sm font-semibold
                            transition duration-150
                            {{ request()->routeIs('buku-kas.*')
                                ? 'bg-haskon-accent-soft text-haskon-primary'
                                : 'text-haskon-muted hover:text-haskon-primary hover:bg-haskon-surface'
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

                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">

                        <button
                            class="
                                inline-flex items-center gap-2
                                px-3 py-2
                                rounded-lg
                                text-sm font-medium
                                text-haskon-muted
                                bg-white
                                hover:bg-haskon-surface
                                hover:text-haskon-primary
                                focus:outline-none
                                focus:ring-2
                                focus:ring-haskon-accent
                                transition duration-150
                            "
                        >

                            {{-- User Initial --}}
                            <span
                                class="
                                    inline-flex items-center justify-center
                                    w-8 h-8
                                    rounded-full
                                    bg-haskon-primary
                                    text-haskon-inverted
                                    text-xs font-bold
                                "
                            >
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>

                            <span>
                                {{ Auth::user()->name }}
                            </span>

                            <svg
                                class="w-4 h-4"
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
                            class="text-haskon-text hover:bg-haskon-surface"
                        >
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        {{-- Logout --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link
                                :href="route('logout')"
                                class="text-haskon-danger hover:bg-haskon-surface"
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
                        text-haskon-muted
                        hover:text-haskon-primary
                        hover:bg-haskon-surface
                        focus:outline-none
                        focus:ring-2
                        focus:ring-haskon-accent
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
        class="hidden sm:hidden border-t border-haskon-border"
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
                        ? 'bg-haskon-accent-soft text-haskon-primary'
                        : 'text-haskon-muted hover:text-haskon-primary hover:bg-haskon-surface'
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
                        ? 'bg-haskon-accent-soft text-haskon-primary'
                        : 'text-haskon-muted hover:text-haskon-primary hover:bg-haskon-surface'
                    }}
                "
            >
                Buku Kas
            </a>

        </div>

        {{-- Mobile User --}}
        <div class="pt-4 pb-3 border-t border-haskon-border">

            <div class="px-4">

                <div class="flex items-center gap-3">

                    <span
                        class="
                            inline-flex items-center justify-center
                            w-10 h-10
                            rounded-full
                            bg-haskon-primary
                            text-haskon-inverted
                            text-sm font-bold
                        "
                    >
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </span>

                    <div>
                        <div class="font-semibold text-sm text-haskon-text">
                            {{ Auth::user()->name }}
                        </div>

                        <div class="text-xs text-haskon-muted">
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
                        text-haskon-text
                        hover:bg-haskon-surface
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
                            text-haskon-danger
                            hover:bg-haskon-surface
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
