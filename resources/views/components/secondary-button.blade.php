<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center rounded-lg border border-black/10 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-black/70 shadow-xs transition hover:border-[#C89B3C] hover:bg-[#C89B3C]/10 focus:outline-none focus:ring-2 focus:ring-[#C89B3C] focus:ring-offset-2 dark:border-white/10 dark:bg-neutral-900 dark:text-white/70 dark:hover:bg-[#C89B3C]/10 dark:focus:ring-offset-black disabled:opacity-25']) }}>
    {{ $slot }}
</button>
