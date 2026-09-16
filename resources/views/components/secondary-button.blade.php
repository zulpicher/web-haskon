<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-4 py-2.5 bg-white hover:bg-zinc-50 active:bg-zinc-100 text-zinc-700 border border-zinc-300 rounded-xl font-semibold text-xs tracking-wider uppercase shadow-xs transition duration-150 focus:outline-none focus:ring-2 focus:ring-zinc-900 focus:ring-offset-2 disabled:opacity-50 cursor-pointer']) }}>
    {{ $slot }}
</button>
