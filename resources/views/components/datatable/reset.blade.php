@props([
    'href',
    'label' => null,
])

@php
    $label ??= __('Reset');
@endphp

<a href="{{ $href }}" aria-label="{{ $label }}" title="{{ $label }}" {{ $attributes->merge(['class' => 'inline-flex h-[46px] w-full items-center justify-center rounded-lg border border-black/10 bg-white px-4 text-black/60 transition hover:border-black/20 hover:bg-black/5 hover:text-black focus:outline-none focus:ring-2 focus:ring-black/10 dark:border-white/10 dark:bg-neutral-900 dark:text-white/60 dark:hover:border-white/20 dark:hover:bg-white/10 dark:hover:text-white dark:focus:ring-offset-black sm:w-[46px]']) }}>
    <x-lucide-x class="h-4 w-4" aria-hidden="true" />
</a>