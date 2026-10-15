<div
    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-black/5 bg-white text-black/60 dark:border-white/10 dark:bg-neutral-900 dark:text-white/65">
    @if ($icon === 'mobile')
        <x-lucide-smartphone class="h-5 w-5" />
    @elseif ($icon === 'tablet')
        <x-lucide-tablet class="h-5 w-5" />
    @else
        <x-lucide-monitor class="h-5 w-5" />
    @endif
</div>