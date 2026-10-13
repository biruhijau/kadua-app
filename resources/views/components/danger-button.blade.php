<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center rounded-lg border border-red-200/70 bg-red-50 px-5 py-3 text-sm font-medium text-red-700 shadow-sm transition-all duration-150 hover:border-red-300 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-400/40 focus:ring-offset-2 active:bg-red-100 dark:border-red-400/20 dark:bg-red-400/10 dark:text-red-300 dark:hover:border-red-400/30 dark:hover:bg-red-400/20 dark:focus:ring-red-400/30 dark:focus:ring-offset-black']) }}>
    {{ $slot }}
</button>
