@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-zinc-300 bg-white text-zinc-900 focus:border-amber-500 focus:ring-2 focus:ring-amber-400/20 rounded-xl shadow-xs transition duration-150 placeholder:text-zinc-400 text-sm px-3.5 py-2.5']) }}>
