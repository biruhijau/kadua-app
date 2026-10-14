@section('title', __('Profile'))

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-black dark:text-white">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <div class="mx-auto max-w-7xl space-y-6">
            <div class="rounded-2xl border border-black/5 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-neutral-950 sm:p-8">
                <div class="w-full">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="rounded-2xl border border-black/5 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-neutral-950 sm:p-8">
                <div class="w-full">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="rounded-2xl border border-black/5 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-neutral-950 sm:p-8">
                <div class="w-full">
                    @include('profile.partials.profile-sessions')
                </div>
            </div>

            <div class="rounded-2xl border border-red-200/60 bg-red-50/40 p-4 shadow-sm dark:border-red-400/15 dark:bg-red-400/5 sm:p-8">
                <div class="w-full">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
