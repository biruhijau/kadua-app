@props([
    'blockRoute',
    'unblockRoute',
    'confirmBlock' => null,
    'confirmUnblock' => null,
])

@php
    $isBlocked = 'allBlocked()';
    $action = "{$isBlocked} ? '{$unblockRoute}' : '{$blockRoute}'";
    $confirm = "{$isBlocked} ? '" . ($confirmUnblock ?? '') . "' : '" . ($confirmBlock ?? '') . "'";
    $label = "{$isBlocked} ? '" . __('Buka Blokir') . "' : '" . __('Blokir') . "'";
@endphp

<button
    type="button"
    data-method="POST"
    x-bind:data-action="{{ $action }}"
    x-bind:data-confirm="{{ $confirm }}"
    x-on:click="submitBulk($el)"
    class="inline-flex w-full items-center justify-center rounded-lg border border-black/10 bg-white px-4 py-2.5 text-sm font-medium text-black/70 transition hover:border-[#C89B3C] hover:bg-[#C89B3C]/10 hover:text-black focus:outline-none focus:ring-2 focus:ring-[#C89B3C]/40 dark:border-white/10 dark:bg-neutral-900 dark:text-white/70 dark:hover:bg-[#C89B3C]/20 dark:hover:text-white sm:w-auto"
>
    <x-lucide-ban x-show="! {{ $isBlocked }}" class="mr-2 h-4 w-4" />
    <x-lucide-rotate-ccw x-show="{{ $isBlocked }}" class="mr-2 h-4 w-4" />
    <span x-text="{{ $label }}"></span>
</button>
