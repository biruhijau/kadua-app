@section('title', __('Sign In'))

<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="font-serif text-3xl sm:text-4xl font-normal text-black dark:text-white tracking-tight">
            {{ __('Portal') }}
        </h2>
        <p class="mt-2 text-xs sm:text-sm text-gray-500 dark:text-gray-400">
            {{ __('Enter your email and password to access your account') }}
        </p>
    </div>

    <x-auth-session-status class="mb-5" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" placeholder="{{ __('Enter your email') }}" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

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

        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                <input id="remember_me" type="checkbox" class="h-4 w-4 cursor-pointer rounded-sm border border-black/15 bg-[#F3F4F6] text-[#C89B3C] transition checked:border-transparent checked:bg-[#C89B3C] focus:ring-[#C89B3C] focus:ring-offset-0 dark:border-white/15 dark:bg-[#1F1F1F] dark:focus:ring-offset-black" name="remember">
                <span class="ms-2 text-xs text-black/55 dark:text-white/55 sm:text-sm">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs text-black/55 transition-colors hover:text-[#C89B3C] focus:outline-none focus:ring-2 focus:ring-[#C89B3C] sm:text-sm dark:text-white/55" href="{{ route('password.request') }}">
                    {{ __('Forgot Password?') }}
                </a>
            @endif
        </div>

        <div class="pt-2">
            <x-primary-button>
                {{ __('Sign In') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-8 text-center text-xs text-black/55 dark:text-white/55 sm:text-sm">
        {{ __("Don't have an account?") }}
        <a href="{{ route('register') }}" class="font-bold text-black dark:text-white hover:text-[#C89B3C] dark:hover:text-[#C89B3C] transition-colors ms-1">
            {{ __('Sign Up') }}
        </a>
    </div>
</x-guest-layout>
