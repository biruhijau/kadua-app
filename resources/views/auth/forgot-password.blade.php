@section('title', __('Forgot Password'))

<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="font-serif text-3xl sm:text-4xl font-normal text-black dark:text-white tracking-tight">
            {{ __('Forgot Password') }}
        </h2>
        <p class="mt-2 text-xs sm:text-sm text-gray-500 dark:text-gray-400">
            {{ __('Enter your email address and we will send you a password reset link') }}
        </p>
    </div>

    <x-auth-session-status class="mb-5" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" placeholder="{{ __('Enter your email') }}" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div class="pt-2">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-8 text-center text-xs sm:text-sm text-gray-500 dark:text-gray-400">
        {{ __('Remember your password?') }}
        <a href="{{ route('login') }}" class="font-bold text-black dark:text-white hover:text-[#C89B3C] dark:hover:text-[#C89B3C] transition-colors ms-1">
            {{ __('Sign In') }}
        </a>
    </div>
</x-guest-layout>
