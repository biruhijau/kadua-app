<div class="border-t border-black/5 pb-1 pt-4 dark:border-white/10">
    <div class="px-3 sm:px-4">
        <div class="truncate text-base font-medium text-black dark:text-white">{{ Auth::user()->name }}</div>
        <div class="truncate text-sm text-black/50 dark:text-white/50">{{ Auth::user()->email }}</div>
    </div>

    <div class="mt-3 space-y-3 px-3 sm:px-4">
        <div class="border-b border-black/10 pb-4 dark:border-white/10">
            <x-theme-toggle full-width />
        </div>

        <div class="space-y-1 pt-1">
            <x-responsive-nav-link :href="route('profile.edit')">
                {{ __('Profile') }}
            </x-responsive-nav-link>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-responsive-nav-link :href="route('logout')" danger
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
</div>