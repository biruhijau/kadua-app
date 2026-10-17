@props([
    'name',
    'value' => null,
    'placeholder' => '0',
    'id' => null,
    'required' => false,
    'disabled' => false,
])

@php
    $id ??= $name;
    $initialValue = old($name, $value);
@endphp

<div x-data="{
        raw: @js($initialValue === null ? '' : (string) $initialValue),
        get formatted() {
            if (this.raw === '') return '';
            return new Intl.NumberFormat('id-ID').format(Number(this.raw));
        },
        update(value) {
            this.raw = value.replace(/[^0-9]/g, '');
        },
    }" {{ $attributes->except(['class'])->merge(['class' => 'relative min-w-0']) }}>
    <span class="pointer-events-none absolute inset-y-0 start-0 flex w-16 items-center justify-center border-e border-black/5 text-sm font-medium text-black/45 dark:border-white/10 dark:text-white/45 sm:w-20">
        Rp
    </span>
    <input type="hidden" name="{{ $name }}" x-bind:value="raw">
    <input id="{{ $id }}" type="text" inputmode="numeric" autocomplete="off"
        :value="formatted" @input="update($event.target.value)"
        @required($required) @disabled($disabled)
        placeholder="{{ $placeholder }}"
        {{ $attributes->except(['class'])->merge(['class' => 'block w-full min-w-0 rounded-lg border border-black/5 bg-[#F3F4F6] py-3 pe-4 ps-20 text-sm text-black placeholder:text-black/35 transition-all duration-150 focus:border-[#C89B3C] focus:outline-none focus:ring-2 focus:ring-[#C89B3C]/30 dark:border-white/10 dark:bg-[#1F1F1F] dark:text-white dark:placeholder:text-white/35 sm:ps-24']) }}>
</div>
