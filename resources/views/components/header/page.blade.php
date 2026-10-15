@props([
    'title',
    'breadcrumbs' => [],
])

<div class="space-y-2">
    <h2 class="text-xl font-semibold leading-tight text-black dark:text-white">
        {{ $title }}
    </h2>

    @if ($breadcrumbs !== [])
        <nav aria-label="{{ __('Breadcrumb') }}" class="flex flex-wrap items-center gap-1.5 text-sm text-black/50 dark:text-white/50">
            @foreach ($breadcrumbs as $index => $breadcrumb)
                @if ($index > 0)
                    <x-lucide-chevron-right class="h-3.5 w-3.5 shrink-0 text-black/30 dark:text-white/30" aria-hidden="true" />
                @endif

                @if (! empty($breadcrumb['href']))
                    <a href="{{ $breadcrumb['href'] }}" class="inline-flex items-center gap-1.5 transition hover:text-black dark:hover:text-white">
                        @if (! empty($breadcrumb['icon']))
                            <x-lucide-settings class="h-3.5 w-3.5" aria-hidden="true" />
                        @endif
                        <span>{{ $breadcrumb['label'] }}</span>
                    </a>
                @else
                    <span class="text-black/70 dark:text-white/70">{{ $breadcrumb['label'] }}</span>
                @endif
            @endforeach
        </nav>
    @endif
</div>
