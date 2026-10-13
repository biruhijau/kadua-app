@props(['active', 'danger' => false])

@php
$classes = $danger
            ? 'block w-full rounded-md py-2 ps-3 pe-4 text-start text-base font-medium text-red-600/80 transition duration-150 ease-in-out hover:bg-red-500/10 hover:text-red-700 focus:bg-red-500/10 focus:text-red-700 focus:outline-none focus:ring-0 dark:text-red-400/80 dark:hover:bg-red-400/10 dark:hover:text-red-300 dark:focus:bg-red-400/10 dark:focus:text-red-300'
            : (($active ?? false)
            ? 'block w-full rounded-md bg-black/5 py-2 ps-3 pe-4 text-start text-base font-medium text-black dark:bg-white/10 dark:text-white focus:outline-none focus:ring-0 active:outline-none active:ring-0 [-webkit-tap-highlight-color:transparent] transition duration-150 ease-in-out'
            : 'block w-full rounded-md py-2 ps-3 pe-4 text-start text-base font-medium text-black/60 hover:bg-black/5 hover:text-black dark:text-white/60 dark:hover:bg-white/10 dark:hover:text-white focus:outline-none focus:ring-0 active:outline-none active:ring-0 [-webkit-tap-highlight-color:transparent] transition duration-150 ease-in-out');
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
