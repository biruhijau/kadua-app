<section>
    <header>
        <h2 class="text-lg font-medium text-black dark:text-white">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-black/55 dark:text-white/55">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-form.label for="update_password_current_password" :value="__('Current Password')" />
            <x-form.input id="update_password_current_password" name="current_password" type="password"
                class="mt-1 block w-full" autocomplete="current-password" />
            <x-form.error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-form.label for="update_password_password" :value="__('New Password')" />
            <x-form.input id="update_password_password" name="password" type="password" class="mt-1 block w-full"
                autocomplete="new-password" />
            <x-form.error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-form.label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <x-form.input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="mt-1 block w-full" autocomplete="new-password" />
            <x-form.error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex flex-col items-stretch gap-3 sm:flex-row sm:items-center sm:justify-end">
            <x-form.button-primary class="w-full sm:w-auto">{{ __('Save') }}</x-form.button-primary>
        </div>
    </form>
</section>