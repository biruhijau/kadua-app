@props([
    'variant' => 'neutral',
])

@php
$classes = match ($variant) {
    'success' => 'bg-green-500/10 text-green-700 dark:text-green-300',
    'warning' => 'bg-amber-500/10 text-amber-700 dark:text-amber-300',
    'danger' => 'bg-red-500/10 text-red-700 dark:text-red-300',
    default => 'bg-black/5 text-black/70 dark:bg-white/10 dark:text-white/70',
};
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center whitespace-nowrap rounded-full px-2 py-1 text-xs ' . $classes]) }}>
    {{ $slot }}
</span>
