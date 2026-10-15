@section('title', __('Reset Password'))

<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="font-serif text-3xl sm:text-4xl font-normal text-black dark:text-white tracking-tight">
            {{ __('Reset Password') }}
        </h2>
        <p class="mt-2 text-xs sm:text-sm text-gray-500 dark:text-gray-400">
            {{ __('Create a new secure password for your account') }}
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <x-form.label for="email" :value="__('Email')" />
            <x-form.input id="email" type="email" name="email" :value="old('email', $request->email)" placeholder="{{ __('Enter your email') }}" required autofocus autocomplete="username" />
            <x-form.error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div x-data="{ show: false }">
            <x-form.label for="password" :value="__('New Password')" />
            <div class="relative">
                <input
                    id="password"
                    :type="show ? 'text' : 'password'"
                    name="password"
                    placeholder="{{ __('Enter new password') }}"
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
                    <x-lucide-eye x-show="!show" class="h-5 w-5" />
                    <x-lucide-eye-off x-show="show" x-cloak class="h-5 w-5" />
                </button>
            </div>
            <x-form.error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div x-data="{ show: false }">
            <x-form.label for="password_confirmation" :value="__('Confirm Password')" />
            <div class="relative">
                <input
                    id="password_confirmation"
                    :type="show ? 'text' : 'password'"
                    name="password_confirmation"
                    placeholder="{{ __('Confirm new password') }}"
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
                    <x-lucide-eye x-show="!show" class="h-5 w-5" />
                    <x-lucide-eye-off x-show="show" x-cloak class="h-5 w-5" />
                </button>
            </div>
            <x-form.error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
        </div>

        <div class="pt-2">
            <x-form.button-primary>
                {{ __('Reset Password') }}
            </x-form.button-primary>
        </div>
    </form>
</x-guest-layout>
