<nav x-data="{ open: false }" class="border-b border-black/5 bg-white dark:border-white/10 dark:bg-black">
    <div class="mx-auto max-w-7xl px-3 sm:px-6 lg:px-8">
        <div class="flex h-[4.5rem] items-center justify-between gap-3 md:gap-4">
            <div class="flex min-w-0 items-center gap-8">
                <div class="flex shrink-0 items-center">
                    <a href="{{ route('dashboard') }}"
                        class="block select-none outline-none focus:outline-none focus:ring-0"
                        oncontextmenu="return false;">
                        <img src="{{ asset('images/kadua_light-mode.png') }}" alt="KADUA BY AMARTHA" draggable="false"
                            class="pointer-events-none block h-9 w-auto max-w-[125px] select-none object-contain dark:hidden md:h-10 md:max-w-[150px]"
                            oncontextmenu="return false;" />
                        <img src="{{ asset('images/kadua_dark-mode.png') }}" alt="KADUA BY AMARTHA" draggable="false"
                            class="pointer-events-none hidden h-9 w-auto max-w-[125px] select-none object-contain dark:block md:h-10 md:max-w-[150px]"
                            oncontextmenu="return false;" />
                    </a>
                </div>

                @include('components.navigation.desktop-menu', ['Navigation' => $Navigation])
            </div>

            @include('components.navigation.profile-dropdown')

            <div class="flex items-center md:hidden">
                <button type="button" @click="open = ! open" :aria-expanded="open.toString()"
                    aria-label="{{ __('Toggle navigation menu') }}"
                    class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-lg p-2 text-black transition hover:bg-[#F8F7F4] hover:text-[#C89B3C] focus:outline-none focus:ring-0 active:outline-none active:ring-0 [-webkit-tap-highlight-color:transparent] dark:text-white dark:hover:bg-neutral-900">
                    <span class="relative block h-5 w-5" aria-hidden="true">
                        <span :class="{ 'rotate-45': open, '-translate-y-2': ! open, 'translate-y-0': open }"
                            class="absolute left-0 top-1/2 block h-0.5 w-5 origin-center bg-current transition-transform"></span>
                        <span :class="{ 'scale-x-0 opacity-0': open, 'scale-x-100 opacity-100': ! open }"
                            class="absolute left-0 top-1/2 block h-0.5 w-5 origin-center bg-current transition-all"></span>
                        <span :class="{ '-rotate-45': open, 'translate-y-2': ! open, 'translate-y-0': open }"
                            class="absolute left-0 top-1/2 block h-0.5 w-5 origin-center bg-current transition-transform"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>

    <div :class="{ 'block': open, 'hidden': ! open }"
        class="hidden border-t border-black/5 md:hidden dark:border-white/10">
        @include('components.navigation.mobile-menu', ['Navigation' => $Navigation])
        @include('components.navigation.mobile-account')
    </div>
</nav>