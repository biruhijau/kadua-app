@props([
    'action',
])

<form method="GET" action="{{ $action }}" {{ $attributes->merge(['class' => 'flex flex-col gap-3 sm:flex-row sm:items-center']) }}>
    {{ $slot }}
</form>
