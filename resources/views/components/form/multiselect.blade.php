@props([
    'name' => 'items',
    'options' => [],
    'selected' => [],
    'placeholder' => null,
])

@php
    $placeholder ??= __('Pilih...');
    $selectedValues = array_map('strval', array_values((array) $selected));
@endphp

<div
    x-data="{
        open: false,
        selected: @js($selectedValues),
        labels: @js($options),
        get summary() {
            const chosen = this.selected.map((value) => this.labels[value]).filter(Boolean);

            if (chosen.length === 0) {
                return @js($placeholder);
            }

            if (chosen.length === 1) {
                return chosen[0];
            }

            return chosen[0] + ', +' + (chosen.length - 1) + ' ' + @js(__('Lainnya'));
        },
    }"
    x-on:click.outside="open = false"
    x-on:keydown.escape.window="open = false"
    {{ $attributes->merge(['class' => 'relative']) }}
>
    <button type="button" x-on:click="open = ! open" x-bind:aria-expanded="open.toString()"
        class="flex w-full items-center justify-between gap-2 rounded-lg border border-black/5 bg-[#F3F4F6] px-4 py-3 text-sm transition hover:border-[#C89B3C] focus:outline-none focus:ring-2 focus:ring-[#C89B3C]/30 dark:border-white/10 dark:bg-[#1F1F1F]">
        <span x-text="summary" class="truncate"
            x-bind:class="selected.length === 0 ? 'text-black/40 dark:text-white/40' : 'text-black dark:text-white'"></span>
        <x-lucide-chevron-down class="h-4 w-4 shrink-0 transition-transform" x-bind:class="{ 'rotate-180': open }"
            aria-hidden="true" />
    </button>

    <div x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95" class="absolute z-50 mt-2 w-full rounded-md shadow-lg"
        style="display: none;">
        <div class="theme-scrollbar max-h-60 overflow-y-auto rounded-md bg-white p-2 ring-1 ring-black/5 dark:bg-neutral-900">
            @forelse ($options as $value => $label)
                <label
                    class="flex cursor-pointer items-center gap-3 rounded-md px-3.5 py-2.5 text-sm text-black/70 transition hover:bg-[#C89B3C]/10 dark:text-white/70 dark:hover:text-white">
                    <input type="checkbox" name="{{ $name }}[]" value="{{ $value }}" x-model="selected"
                        class="rounded border-black/20 text-[#C89B3C] focus:ring-[#C89B3C] dark:border-white/20 dark:bg-neutral-900" />
                    <span>{{ $label }}</span>
                </label>
            @empty
                <p class="px-3.5 py-2.5 text-sm text-black/50 dark:text-white/50">{{ __('Tidak ada pilihan.') }}</p>
            @endforelse
        </div>
    </div>
</div>
