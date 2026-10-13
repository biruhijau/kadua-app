@section('title', __('Confirm Password'))

<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="font-serif text-3xl sm:text-4xl font-normal text-black dark:text-white tracking-tight">
            {{ __('Confirm Password') }}
        </h2>
        <p class="mt-2 text-xs sm:text-sm text-gray-500 dark:text-gray-400">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
        @csrf

        <div x-data="{ show: false }">
            <x-input-label for="password" :value="__('Password')" />
            <div class="relative">
                <input
                    id="password"
                    :type="show ? 'text' : 'password'"
                    name="password"
                    placeholder="{{ __('Enter your password') }}"
                    required
                    autocomplete="current-password"
                    class="w-full rounded-lg border border-black/5 bg-[#F3F4F6] px-4 py-3 pe-11 text-sm text-black placeholder:text-black/35 focus:border-[#C89B3C] focus:outline-none focus:ring-2 focus:ring-[#C89B3C]/30 dark:border-white/10 dark:bg-[#1F1F1F] dark:text-white dark:placeholder:text-white/35 transition-all duration-150"
                />
                <button
                    type="button"
                    @click="show = !show"
                    class="absolute inset-y-0 end-0 flex items-center pe-3.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors cursor-pointer focus:outline-none"
                    aria-label="Toggle password visibility"
                >
                    <x-icon-eye x-show="!show" class="h-5 w-5" />
                    <x-icon-eye-off x-show="show" x-cloak class="h-5 w-5" />
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div class="pt-2">
            <x-primary-button>
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
