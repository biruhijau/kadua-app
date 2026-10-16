@props([
    'value',
    'form' => 'bulk-form',
])

@php
    $classes = 'h-4 w-4 cursor-pointer rounded border-black/20 text-[#C89B3C] focus:ring-[#C89B3C] dark:border-white/20 dark:bg-neutral-900';
@endphp

<input
    type="checkbox"
    x-model="selected"
    value="{{ $value }}"
    form="{{ $form }}"
    name="ids[]"
    aria-label="{{ __('Pilih baris ini') }}"
    {{ $attributes->merge(['class' => $classes]) }}
>
