<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-red-800 dark:text-red-200">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-red-900/65 dark:text-red-100/65">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-form.button-danger x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="w-full sm:w-auto">{{ __('Delete Account') }}</x-form.button-danger>

    <x-ui.modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-black dark:text-white">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-black/55 dark:text-white/55">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-form.label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-form.input id="password" name="password" type="password" class="mt-1 block w-full"
                    placeholder="{{ __('Password') }}" />

                <x-form.error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <x-form.button-secondary x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-form.button-secondary>

                <x-form.button-danger>
                    {{ __('Delete Account') }}
                </x-form.button-danger>
            </div>
        </form>
    </x-ui.modal>
</section>