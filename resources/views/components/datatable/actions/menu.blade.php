@props([
    'align' => 'right',
    'width' => 'w-44',
])

<div
    x-data="{
        open: false,
        openUp: false,
        top: 0,
        left: 0,
        toggle() {
            this.open = ! this.open;

            if (! this.open) {
                return;
            }

            this.$nextTick(() => {
                const rect = this.$refs.trigger.getBoundingClientRect();
                const menuHeight = this.$refs.menu?.offsetHeight ?? 0;
                const menuWidth = this.$refs.menu?.offsetWidth ?? 0;
                const gap = 8;
                const spaceBelow = window.innerHeight - rect.bottom;
                const spaceAbove = rect.top;

                this.openUp = spaceBelow < menuHeight + gap && spaceAbove > spaceBelow;
                this.top = Math.max(gap, Math.min(
                    this.openUp ? rect.top - menuHeight - gap : rect.bottom + gap,
                    window.innerHeight - menuHeight - gap,
                ));
                this.left = Math.max(gap, Math.min(
                    rect.right - menuWidth,
                    window.innerWidth - menuWidth - gap,
                ));
            });
        },
    }"
    x-on:keydown.escape.window="open = false"
    x-on:scroll.window.capture="open = false"
    x-on:resize.window="open = false"
    @click.outside="open = false"
    class="relative flex justify-end"
>
    <button
        type="button"
        x-ref="trigger"
        x-on:click="toggle()"
        x-bind:aria-expanded="open.toString()"
        aria-haspopup="true"
        aria-label="{{ __('Buka aksi') }}"
        class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-black/55 transition hover:bg-black/5 hover:text-black focus:outline-none focus:ring-2 focus:ring-[#C89B3C]/40 dark:text-white/55 dark:hover:bg-white/10 dark:hover:text-white"
    >
        <x-lucide-ellipsis-vertical class="h-4 w-4" aria-hidden="true" />
    </button>

    <template x-teleport="body">
        <div class="pointer-events-none fixed inset-0 z-[60] overflow-hidden">
            <div
                x-show="open"
                x-ref="menu"
                x-on:click="open = false"
                x-bind:style="`top: ${top}px; left: ${left}px;`"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="pointer-events-auto absolute {{ $width }} rounded-md shadow-lg"
                style="display: none;"
            >
                <div class="rounded-md bg-white p-1.5 ring-1 ring-black/5 dark:bg-neutral-900">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </template>
</div>
