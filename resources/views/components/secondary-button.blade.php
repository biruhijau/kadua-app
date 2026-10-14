<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center rounded-lg border border-black/10 bg-white px-5 py-3 text-sm font-medium text-black/70 shadow-sm transition-all duration-150 hover:border-black/20 hover:bg-black/5 hover:text-black focus:outline-none focus:ring-2 focus:ring-black/10 focus:ring-offset-2 dark:border-white/10 dark:bg-neutral-900 dark:text-white/70 dark:hover:border-white/20 dark:hover:bg-white/10 dark:hover:text-white dark:focus:ring-white/10 dark:focus:ring-offset-black disabled:opacity-25']) }}>
    {{ $slot }}
</button>
