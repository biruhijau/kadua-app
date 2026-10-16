@php
    $classes = 'h-4 w-4 cursor-pointer rounded border-black/20 text-[#C89B3C] focus:ring-[#C89B3C] dark:border-white/20 dark:bg-neutral-900';
@endphp

<input
    type="checkbox"
    x-bind:checked="allSelected()"
    x-on:change="toggleAll($event.target.checked)"
    aria-label="{{ __('Pilih semua') }}"
    title="{{ __('Pilih semua') }}"
    {{ $attributes->merge(['class' => $classes]) }}
>
