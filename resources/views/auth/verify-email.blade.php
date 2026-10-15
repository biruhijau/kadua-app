@section('title', __('Verify Email'))

<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="font-serif text-3xl sm:text-4xl font-normal text-black dark:text-white tracking-tight">
            {{ __('Verify Email') }}
        </h2>
        <p class="mt-2 text-xs sm:text-sm text-gray-500 dark:text-gray-400">
            {{ __('Thanks for signing up! Please verify your email by clicking the link we just sent to your inbox.') }}
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-5 p-3 rounded-lg bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-xs sm:text-sm text-emerald-700 dark:text-emerald-300 text-center">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="space-y-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-form.button-primary>
                {{ __('Resend Verification Email') }}
            </x-form.button-primary>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="text-center">
            @csrf
            <button type="submit" class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 hover:text-black dark:hover:text-white underline transition-colors cursor-pointer focus:outline-none">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
