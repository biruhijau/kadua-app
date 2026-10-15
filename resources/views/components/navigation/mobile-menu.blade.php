<div class="space-y-1 px-3 pb-3 pt-3 sm:px-4">
    @foreach ($Navigation as $item)
        @if ($item['children'] !== [])
            <div x-data="{ submenu: false }">
                <button type="button" x-on:click="submenu = ! submenu" x-bind:aria-expanded="submenu.toString()"
                    class="flex w-full items-center justify-between rounded-md px-3 py-2 text-start text-base font-medium text-black/60 transition hover:bg-black/5 hover:text-black focus:outline-none focus:ring-0 dark:text-white/60 dark:hover:bg-white/10 dark:hover:text-white">
                    {{ $item['label'] }}
                    <x-lucide-chevron-down x-bind:class="{ 'rotate-180': submenu }"
                        class="h-4 w-4 shrink-0 transition-transform" />
                </button>

                <div x-show="submenu" x-cloak x-transition class="mt-1 space-y-1 ps-3" style="display: none;">
                    @foreach ($item['children'] as $child)
                        <a href="{{ $child['href'] }}"
                            class="block rounded-md px-3 py-2 text-sm text-black/60 transition hover:bg-black/5 hover:text-black focus:bg-black/5 focus:outline-none dark:text-white/60 dark:hover:bg-white/10 dark:hover:text-white dark:focus:bg-white/10">
                            {{ $child['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        @else
            <x-responsive-nav-link :href="$item['href']" :active="$item['active']">
                {{ $item['label'] }}
            </x-responsive-nav-link>
        @endif
    @endforeach
</div>