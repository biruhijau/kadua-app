@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-xs text-gray-700 dark:text-gray-300 tracking-wide uppercase mb-1.5']) }}>
    {{ $value ?? $slot }}
</label>