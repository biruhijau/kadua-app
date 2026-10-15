@props(['groups', 'selected' => []])

<div class="space-y-4">
    <div>
        <h3 class="text-sm font-medium text-black dark:text-white">{{ __('Permission') }}</h3>
        <p class="mt-1 text-sm text-black/55 dark:text-white/55">{{ __('Pilih perizinan untuk peran ini.') }}</p>
        <x-input-error :messages="$errors->get('permissions')" class="mt-2" />
    </div>
    <div class="grid gap-4 sm:grid-cols-2">
        @foreach ($groups as $group)
            <fieldset class="rounded-xl border border-black/5 p-4 dark:border-white/10">
                <legend class="px-1 text-sm font-medium text-black dark:text-white">{{ $group['label'] }}</legend>
                <div class="mt-2 space-y-2">
                    @foreach ($group['permissions'] as $permission)
                        <label class="flex items-center gap-3 text-sm text-black/70 dark:text-white/70">
                            <input type="checkbox" name="permissions[]" value="{{ $permission['id'] }}"
                                @checked(in_array($permission['id'], $selected, true))
                                class="rounded border-black/20 text-[#C89B3C] focus:ring-[#C89B3C] dark:border-white/20 dark:bg-neutral-900" />
                            <span>{{ $permission['label'] }}</span>
                        </label>
                    @endforeach
                </div>
            </fieldset>
        @endforeach
    </div>
</div>