<div class="hidden items-center md:flex">
    <x-dropdown align="right" width="48" contentClasses="p-2 bg-white dark:bg-neutral-900">
        <x-slot name="trigger">
            <button
                type="button"
                aria-label="{{ __('Open profile menu') }}"
                class="inline-flex items-center justify-center rounded-full border border-black/10 bg-[#F8F7F4] p-2 text-black transition hover:border-[#C89B3C] hover:text-[#C89B3C] focus:outline-none focus:ring-0 active:outline-none active:ring-0 dark:border-white/10 dark:bg-neutral-900 dark:text-white"
            >
                <x-icon-user class="h-5 w-5" />
            </button>
        </x-slot>

        <x-slot name="content">
            <div class="mb-2 border-b border-black/10 px-1 pb-4 pt-1 dark:border-white/10">
                <x-theme-toggle full-width />
            </div>

            <x-dropdown-link :href="route('profile.edit')">
                {{ __('Profile') }}
            </x-dropdown-link>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-dropdown-link
                    :href="route('logout')"
                    danger
                    onclick="event.preventDefault(); this.closest('form').submit();"
                >
                    {{ __('Log Out') }}
                </x-dropdown-link>
            </form>
        </x-slot>
    </x-dropdown>
</div>
