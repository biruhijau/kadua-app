@props(['active'])

@php
$classes = ($active ?? false)
? 'inline-flex items-center rounded-md bg-black/5 px-3 py-2 text-sm font-medium leading-5 text-black dark:bg-white/10 dark:text-white focus:outline-none focus:ring-0 active:outline-none active:ring-0 [-webkit-tap-highlight-color:transparent] transition duration-150 ease-in-out'
        : 'inline-flex items-center rounded-md px-3 py-2 text-sm font-medium leading-5 text-black/55 hover:bg-black/5 hover:text-black dark:text-white/55 dark:hover:bg-white/10 dark:hover:text-white focus:outline-none focus:ring-0 active:outline-none active:ring-0 [-webkit-tap-highlight-color:transparent] transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
