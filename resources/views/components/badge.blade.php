@props([
    'variant' => 'primary',
    'circle' => false,
])

@php
    $classes = match ($variant) {
        'success' => 'bg-green-500/10 text-green-700 dark:text-green-300',
        'warning' => 'bg-amber-500/10 text-amber-700 dark:text-amber-300',
        'danger' => 'bg-red-500/10 text-red-700 dark:text-red-300',
        'neutral' => 'bg-black/5 text-black/70 dark:bg-white/10 dark:text-white/70',
        default => 'bg-[#C89B3C]/15 text-[#8a6a1f] dark:bg-[#C89B3C]/20 dark:text-[#e3c26b]',
    };

    $shape = $circle
        ? 'h-7 w-7 justify-center p-0'
        : 'whitespace-nowrap px-2 py-1';
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full text-xs ' . $shape . ' ' . $classes]) }}>
    {{ $slot }}
</span>