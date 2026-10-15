@props([
    'name' => 'filter',
    'options' => [],
    'selected' => '',
    'placeholder' => null,
])

@php
    $placeholder ??= __('Semua') . ' ' . $name;

    $items = collect($options)->mapWithKeys(function ($label, $value) {
        return is_int($value) ? [$label => $label] : [$value => $label];
    })->all();
@endphp

<x-ui.dropdown align="left" match-trigger contentClasses="p-2 bg-white dark:bg-neutral-900" {{ $attributes->merge(['class' => 'w-full sm:w-auto']) }}>
    <x-slot name="trigger">
        <button type="button"
            class="flex w-full items-center justify-between gap-2 rounded-lg border border-black/5 bg-[#F3F4F6] px-4 py-3 text-sm text-black transition hover:border-[#C89B3C] focus:outline-none focus:ring-2 focus:ring-[#C89B3C]/30 dark:border-white/10 dark:bg-[#1F1F1F] dark:text-white">
            <span class="inline-flex items-center gap-2">
                <x-lucide-filter class="h-4 w-4" aria-hidden="true" />
                {{ $selected !== '' && $selected !== null ? ($items[$selected] ?? $selected) : $placeholder }}
            </span>
            <x-lucide-chevron-down class="h-4 w-4 shrink-0" aria-hidden="true" />
        </button>
    </x-slot>

    <x-slot name="content">
        <button type="submit" name="{{ $name }}" value=""
            class="block w-full rounded-md px-3.5 py-2.5 text-start text-sm text-black/70 transition hover:bg-[#C89B3C]/10 dark:text-white/70 dark:hover:text-white">
            {{ $placeholder }}
        </button>
        @foreach ($items as $value => $label)
            <button type="submit" name="{{ $name }}" value="{{ $value }}"
                class="block w-full rounded-md px-3.5 py-2.5 text-start text-sm transition hover:bg-[#C89B3C]/10 {{ (string) $selected === (string) $value ? 'text-black dark:text-white' : 'text-black/70 dark:text-white/70' }}">
                {{ $label }}
            </button>
        @endforeach
    </x-slot>
</x-ui.dropdown>