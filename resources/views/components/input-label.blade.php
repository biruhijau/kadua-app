@props(['value'])

<label {{ $attributes->merge(['class' => 'mb-1.5 block text-xs font-medium uppercase tracking-wide text-black/70 dark:text-white/70']) }}>
    {{ $value ?? $slot }}
</label>