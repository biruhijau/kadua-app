@props(['danger' => false])

@php
$classes = $danger
    ? 'block w-full rounded-md px-3.5 py-3 text-start text-sm leading-5 text-red-600/80 transition duration-150 ease-in-out hover:bg-red-500/10 hover:text-red-700 focus:bg-red-500/10 focus:text-red-700 focus:outline-none dark:text-red-400/80 dark:hover:bg-red-400/10 dark:hover:text-red-300 dark:focus:bg-red-400/10 dark:focus:text-red-300'
    : 'block w-full rounded-md px-3.5 py-3 text-start text-sm leading-5 text-black/70 transition duration-150 ease-in-out hover:bg-[#C89B3C]/10 hover:text-black focus:bg-[#C89B3C]/10 focus:outline-none dark:text-white/70 dark:hover:text-white';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
