@props([
    'name' => 'search',
    'value' => '',
    'placeholder' => null,
])

<x-form.input
    :name="$name"
    :value="$value"
    :placeholder="$placeholder ?? __('Cari...')"
    {{ $attributes->merge(['class' => 'sm:max-w-sm']) }}
/>
