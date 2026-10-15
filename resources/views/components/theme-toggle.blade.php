@props(['fullWidth' => false])

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
    " x-on:click.stop
    class="{{ $fullWidth ? 'w-full' : 'w-[9.5rem]' }} flex shrink-0 items-center rounded-full border border-neutral-200 bg-neutral-100 p-1 transition-colors dark:border-neutral-800 dark:bg-neutral-900"
    role="group" aria-label="{{ __('Theme switcher') }}">
    <button type="button" x-on:click="setTheme('light')"
        x-bind:class="theme === 'light' ? 'bg-white dark:bg-neutral-800 text-black dark:text-white shadow-xs' : 'text-neutral-400 hover:text-neutral-700 dark:hover:text-neutral-300'"
        class="flex h-8 min-w-[2rem] flex-1 cursor-pointer items-center justify-center rounded-full transition-all duration-150 focus:outline-none"
        title="{{ __('Light theme') }}" aria-label="{{ __('Light theme') }}">
        <x-lucide-sun class="w-4 h-4" />
    </button>

    <button type="button" x-on:click="setTheme('dark')"
        x-bind:class="theme === 'dark' ? 'bg-white dark:bg-neutral-800 text-black dark:text-white shadow-xs' : 'text-neutral-400 hover:text-neutral-700 dark:hover:text-neutral-300'"
        class="flex h-8 min-w-[2rem] flex-1 cursor-pointer items-center justify-center rounded-full transition-all duration-150 focus:outline-none"
        title="{{ __('Dark theme') }}" aria-label="{{ __('Dark theme') }}">
        <x-lucide-moon class="w-4 h-4" />
    </button>

    <button type="button" x-on:click="setTheme('auto')"
        x-bind:class="theme === 'auto' ? 'bg-white dark:bg-neutral-800 text-black dark:text-white shadow-xs' : 'text-neutral-400 hover:text-neutral-700 dark:hover:text-neutral-300'"
        class="flex h-8 min-w-[2rem] flex-1 cursor-pointer items-center justify-center rounded-full transition-all duration-150 focus:outline-none"
        title="{{ __('Auto / System theme') }}" aria-label="{{ __('Auto / System theme') }}">
        <x-lucide-monitor class="w-4 h-4" />
    </button>
</div>