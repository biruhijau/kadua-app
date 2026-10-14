<div class="hidden h-full items-center gap-2 md:flex">
    @foreach ($Navigation as $item)
        @if ($item['children'] !== [])
            <div
                x-data="{ submenu: false }"
                class="relative h-full py-3"
                x-on:mouseenter="submenu = true"
                x-on:mouseleave="submenu = false"
            >
                <button
                    type="button"
                    x-on:focus="submenu = true"
                    x-on:click="submenu = ! submenu"
                    x-bind:aria-expanded="submenu.toString()"
                    x-bind:class="submenu ? 'bg-black/5 text-black dark:bg-white/10 dark:text-white' : ''"
                    class="inline-flex h-full items-center gap-2 rounded-md px-3 py-2 text-sm font-medium text-black/60 transition hover:bg-black/5 hover:text-black focus:outline-none focus:ring-0 dark:text-white/60 dark:hover:bg-white/10 dark:hover:text-white"
                >
                    {{ $item['label'] }}
                    <x-lucide-chevron-down x-bind:class="{ 'rotate-180': submenu }" class="h-4 w-4 shrink-0 transition-transform" />
                </button>

                <div
                    x-show="submenu"
                    x-cloak
                    x-transition
                    class="absolute start-0 top-full z-50 mt-2 w-48 max-w-[calc(100vw-2rem)] rounded-md shadow-lg"
                    style="display: none;"
                >
                    <div class="rounded-md bg-white p-2 ring-1 ring-black/5 dark:bg-neutral-900">
                        @foreach ($item['children'] as $child)
                            <x-dropdown-link :href="$child['href']">
                                {{ $child['label'] }}
                            </x-dropdown-link>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <x-nav-link :href="$item['href']" :active="$item['active']">
                {{ $item['label'] }}
            </x-nav-link>
        @endif
    @endforeach
</div>
