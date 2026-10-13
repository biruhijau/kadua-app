@section('title', __('Register'))

<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="font-serif text-3xl sm:text-4xl font-normal text-black dark:text-white tracking-tight">
            {{ __('Create Account') }}
        </h2>
        <p class="mt-2 text-xs sm:text-sm text-gray-500 dark:text-gray-400">
            {{ __('Join KADUA to manage and grow your journey') }}
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" type="text" name="name" :value="old('name')" placeholder="{{ __('Enter your full name') }}" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" placeholder="{{ __('Enter your email') }}" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div x-data="{ show: false }">
            <x-input-label for="password" :value="__('Password')" />
            <div class="relative">
                <input
                    id="password"
                    :type="show ? 'text' : 'password'"
                    name="password"
                    placeholder="{{ __('Create a password') }}"
                    required
                    autocomplete="new-password"
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

        <div x-data="{ show: false }">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <div class="relative">
                <input
                    id="password_confirmation"
                    :type="show ? 'text' : 'password'"
                    name="password_confirmation"
                    placeholder="{{ __('Confirm your password') }}"
                    required
                    autocomplete="new-password"
                    class="w-full rounded-lg border border-black/5 bg-[#F3F4F6] px-4 py-3 pe-11 text-sm text-black placeholder:text-black/35 focus:border-[#C89B3C] focus:outline-none focus:ring-2 focus:ring-[#C89B3C]/30 dark:border-white/10 dark:bg-[#1F1F1F] dark:text-white dark:placeholder:text-white/35 transition-all duration-150"
                />
                <button
                    type="button"
                    @click="show = !show"
                    class="absolute inset-y-0 end-0 flex items-center pe-3.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors cursor-pointer focus:outline-none"
                    aria-label="Toggle confirm password visibility"
                >
                    <x-icon-eye x-show="!show" class="h-5 w-5" />
                    <x-icon-eye-off x-show="show" x-cloak class="h-5 w-5" />
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
        </div>

        <div class="pt-2">
            <x-primary-button>
                {{ __('Create Account') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-8 text-center text-xs sm:text-sm text-gray-500 dark:text-gray-400">
        {{ __('Already have an account?') }}
        <a href="{{ route('login') }}" class="font-bold text-black dark:text-white hover:text-[#C89B3C] dark:hover:text-[#C89B3C] transition-colors ms-1">
            {{ __('Sign In') }}
        </a>
    </div>
</x-guest-layout>
