@props([
    'name',
    'options' => [],
    'selected' => null,
    'placeholder' => null,
])

@php
    $placeholder ??= __('Pilih...');
    $selectedValue = $selected === null ? '' : (string) $selected;
    $optionLabels = collect($options)->mapWithKeys(fn ($label, $value) => [(string) $value => $label])->all();
@endphp

<div x-data="{
        open: false,
        selected: @js($selectedValue),
        labels: @js($optionLabels),
        get summary() { return this.labels[this.selected] || @js($placeholder); },
    }" x-on:click.outside="open = false" x-on:keydown.escape.window="open = false"
    {{ $attributes->merge(['class' => 'relative']) }}>
    <input type="hidden" name="{{ $name }}" x-bind:value="selected">

    <button type="button" x-on:click="open = ! open" x-bind:aria-expanded="open.toString()"
        class="flex w-full items-center justify-between gap-2 rounded-lg border border-black/5 bg-[#F3F4F6] px-4 py-3 text-sm transition hover:border-[#C89B3C] focus:outline-none focus:ring-2 focus:ring-[#C89B3C]/30 dark:border-white/10 dark:bg-[#1F1F1F]"
        x-bind:class="selected === '' ? 'text-black/40 dark:text-white/40' : 'text-black dark:text-white'">
        <span x-text="summary" class="truncate"></span>
        <x-lucide-chevron-down class="h-4 w-4 shrink-0 transition-transform" x-bind:class="{ 'rotate-180': open }" aria-hidden="true" />
    </button>

    <div x-show="open" x-cloak x-transition class="absolute z-50 mt-2 w-full rounded-md shadow-lg" style="display: none;">
        <div class="theme-scrollbar max-h-60 overflow-y-auto rounded-md bg-white p-2 ring-1 ring-black/5 dark:bg-neutral-900">
            <button type="button" x-on:click="selected = ''; open = false"
                class="block w-full rounded-md px-3.5 py-2.5 text-start text-sm text-black/60 transition hover:bg-[#C89B3C]/10 dark:text-white/60 dark:hover:text-white">
                {{ $placeholder }}
            </button>
            @forelse ($options as $value => $label)
                <button type="button" x-on:click="selected = @js((string) $value); open = false"
                    class="block w-full rounded-md px-3.5 py-2.5 text-start text-sm text-black/70 transition hover:bg-[#C89B3C]/10 dark:text-white/70 dark:hover:text-white">
                    {{ $label }}
                </button>
            @empty
                <p class="px-3.5 py-2.5 text-sm text-black/50 dark:text-white/50">{{ __('Tidak ada pilihan.') }}</p>
            @endforelse
        </div>
    </div>
</div>
