<div x-data="{
        theme: localStorage.getItem('theme') || 'auto',
        setTheme(val) {
            this.theme = val;
            if (val === 'auto') {
                localStorage.removeItem('theme');
            } else {
                localStorage.setItem('theme', val);
            }
            this.applyTheme();
        },
        applyTheme() {
            const isDark = this.theme === 'dark' || (this.theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches);
            document.documentElement.classList.toggle('dark', isDark);
        }
    }" x-init="
        applyTheme();
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
            if (theme === 'auto') applyTheme();
        });
    "
    class="inline-flex items-center p-1 rounded-full bg-neutral-100 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 transition-colors"
    role="group" aria-label="{{ __('Theme switcher') }}">
    <button type="button" @click="setTheme('light')"
        :class="theme === 'light' ? 'bg-white dark:bg-neutral-800 text-black dark:text-white shadow-xs' : 'text-neutral-400 hover:text-neutral-700 dark:hover:text-neutral-300'"
        class="flex items-center justify-center w-8 h-8 rounded-full transition-all duration-150 cursor-pointer focus:outline-none"
        title="{{ __('Light theme') }}" aria-label="{{ __('Light theme') }}">
        <x-icon-sun class="w-4 h-4" />
    </button>

    <button type="button" @click="setTheme('dark')"
        :class="theme === 'dark' ? 'bg-white dark:bg-neutral-800 text-black dark:text-white shadow-xs' : 'text-neutral-400 hover:text-neutral-700 dark:hover:text-neutral-300'"
        class="flex items-center justify-center w-8 h-8 rounded-full transition-all duration-150 cursor-pointer focus:outline-none"
        title="{{ __('Dark theme') }}" aria-label="{{ __('Dark theme') }}">
        <x-icon-moon class="w-4 h-4" />
    </button>

    <button type="button" @click="setTheme('auto')"
        :class="theme === 'auto' ? 'bg-white dark:bg-neutral-800 text-black dark:text-white shadow-xs' : 'text-neutral-400 hover:text-neutral-700 dark:hover:text-neutral-300'"
        class="flex items-center justify-center w-8 h-8 rounded-full transition-all duration-150 cursor-pointer focus:outline-none"
        title="{{ __('Auto / System theme') }}" aria-label="{{ __('Auto / System theme') }}">
        <x-icon-computer-desktop class="w-4 h-4" />
    </button>
</div>