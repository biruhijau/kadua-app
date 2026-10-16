@props([
    'disabled' => false,
    'value' => null,
])

<textarea @disabled($disabled) {{ $attributes->merge(['class' => 'w-full rounded-lg border border-black/5 bg-[#F3F4F6] px-4 py-3 text-sm text-black placeholder:text-black/35 transition-all duration-150 focus:border-[#C89B3C] focus:outline-none focus:ring-2 focus:ring-[#C89B3C]/30 dark:border-white/10 dark:bg-[#1F1F1F] dark:text-white dark:placeholder:text-white/35']) }}>{{ $value }}</textarea>
