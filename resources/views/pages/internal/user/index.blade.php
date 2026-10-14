@section('title', __('Pengguna'))

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-black dark:text-white">
            {{ __('Pengguna') }}
        </h2>
    </x-slot>

    <div class="px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="min-h-64 rounded-2xl border border-black/5 bg-white shadow-sm dark:border-white/10 dark:bg-neutral-950"></div>
        </div>
    </div>
</x-app-layout>
