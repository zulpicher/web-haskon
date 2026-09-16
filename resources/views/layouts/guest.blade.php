<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-zinc-900 antialiased bg-[#f4f5f7]">
        <div class="min-h-screen flex flex-col sm:justify-center items-center py-10 px-4 sm:px-6">
            {{-- Brand Logo & Title --}}
            <div class="flex flex-col items-center mb-6 text-center">
                <a href="/" class="group flex flex-col items-center">
                    <div class="h-16 w-16 rounded-2xl bg-zinc-900 border border-zinc-800 p-3 shadow-md flex items-center justify-center transition transform group-hover:scale-105">
                        <x-application-logo class="w-full h-full object-contain" />
                    </div>
                    <span class="mt-3 text-lg font-black tracking-tight text-zinc-900">
                        PT HASKON CITRA PERDANA
                    </span>
                </a>
            </div>

            {{-- Card Container --}}
            <div class="w-full sm:max-w-md bg-white border border-zinc-200 shadow-sm rounded-2xl p-6 sm:p-8">
                {{ $slot }}
            </div>

            {{-- Footer Note --}}
            <p class="mt-6 text-center text-xs text-zinc-400">
                &copy; {{ date('Y') }} PT HASKON CITRA PERDANA. All rights reserved.
            </p>
        </div>
    </body>
</html>
