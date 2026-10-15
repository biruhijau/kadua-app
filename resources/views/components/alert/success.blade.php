@props([
    'dismissible' => false,
])

<div {{ $attributes->merge(['class' => 'rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-400/20 dark:bg-green-400/10 dark:text-green-300']) }}>
    {{ $slot }}
</div>
