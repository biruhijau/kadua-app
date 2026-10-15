@props([
    'icon' => null,
    'danger' => false,
    'href' => null,
    'action' => null,
    'method' => 'post',
    'confirm' => null,
    'download' => false,
    'target' => null,
])

@php
    $classes = $danger
        ? 'flex w-full items-center gap-3 rounded-md px-3.5 py-3 text-start text-sm leading-5 text-red-600/80 transition duration-150 ease-in-out hover:bg-red-500/10 hover:text-red-700 focus:bg-red-500/10 focus:text-red-700 focus:outline-none dark:text-red-400/80 dark:hover:bg-red-400/10 dark:hover:text-red-300 dark:focus:bg-red-400/10 dark:focus:text-red-300'
        : 'flex w-full items-center gap-3 rounded-md px-3.5 py-3 text-start text-sm leading-5 text-black/70 transition duration-150 ease-in-out hover:bg-[#C89B3C]/10 hover:text-black focus:bg-[#C89B3C]/10 focus:outline-none dark:text-white/70 dark:hover:text-white';
@endphp

@if ($href !== null)
    <a href="{{ $href }}" @if ($download) download @endif @if ($target !== null) target="{{ $target }}"
    rel="noopener noreferrer" @endif {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon !== null)
            <x-dynamic-component :component="'lucide-' . $icon" class="h-4 w-4 shrink-0" aria-hidden="true" />
        @endif
        <span>{{ $slot }}</span>
    </a>
@else
    <form method="POST" action="{{ $action }}" @if ($confirm !== null) x-data
        x-on:submit.prevent="if (await window.confirmAction({ text: @js($confirm), icon: 'warning', danger: {{ $danger ? 'true' : 'false' }} })) { HTMLFormElement.prototype.submit.call($el); }"
    @endif>
        @csrf
        @if (strtoupper($method) !== 'POST')
            @method($method)
        @endif

        <button type="submit" {{ $attributes->merge(['class' => $classes]) }}>
            @if ($icon !== null)
                <x-dynamic-component :component="'lucide-' . $icon" class="h-4 w-4 shrink-0" aria-hidden="true" />
            @endif
            <span>{{ $slot }}</span>
        </button>
    </form>
@endif