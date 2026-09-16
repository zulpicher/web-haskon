<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2.5 bg-zinc-900 hover:bg-zinc-800 active:bg-black text-white border border-zinc-800 rounded-xl font-semibold text-xs tracking-wider uppercase shadow-xs transition duration-150 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:ring-offset-2 disabled:opacity-50 cursor-pointer']) }}>
    {{ $slot }}
</button>
