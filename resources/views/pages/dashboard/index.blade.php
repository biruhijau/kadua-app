@section('title', __('Dashboard'))

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-black dark:text-white">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div
                class="overflow-hidden rounded-2xl border border-black/5 bg-white shadow-sm dark:border-white/10 dark:bg-neutral-950">
                <div class="p-6 text-sm text-black/70 dark:text-white/70 sm:p-8">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>