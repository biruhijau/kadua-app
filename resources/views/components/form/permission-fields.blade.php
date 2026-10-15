@props(['groups', 'selected' => []])

<div class="space-y-8">
    <div>
        <h3 class="text-sm font-medium text-black dark:text-white">{{ __('Izin Akses') }}</h3>
        <p class="mt-1 text-sm text-black/55 dark:text-white/55">{{ __('Pilih perizinan untuk peran ini.') }}</p>
        <x-form.error :messages="$errors->get('permissions')" class="mt-2" />
    </div>

    @foreach ($groups as $group)
        <div>
            <p class="mb-3 text-xs font-medium uppercase tracking-wide text-black/45 dark:text-white/45">
                {{ $group['label'] }}
            </p>

            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-4 xl:grid-cols-4">
                @foreach ($group['permissions'] as $permission)
                    <label
                        class="group flex cursor-pointer items-center gap-3.5 rounded-xl border border-black/10 bg-white px-5 py-4 transition hover:border-[#C89B3C]/50 hover:shadow-sm has-[:checked]:border-[#C89B3C] has-[:checked]:bg-[#C89B3C]/10 has-[:focus-visible]:ring-2 has-[:focus-visible]:ring-[#C89B3C]/40 dark:border-white/10 dark:bg-neutral-900 dark:hover:border-[#C89B3C]/50 dark:has-[:checked]:border-[#C89B3C] dark:has-[:checked]:bg-[#C89B3C]/15">
                        <input type="checkbox" name="permissions[]" value="{{ $permission['id'] }}"
                            @checked(in_array($permission['id'], $selected, true)) class="sr-only" />

                        <span
                            class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full border-2 border-black/25 transition group-has-[:checked]:border-[#C89B3C] dark:border-white/25">
                            <span class="h-2.5 w-2.5 rounded-full bg-[#C89B3C] opacity-0 transition group-has-[:checked]:opacity-100"></span>
                        </span>

                        <span
                            class="text-sm font-medium text-black/70 transition sm:text-base group-has-[:checked]:text-[#8a6a1f] dark:text-white/70 dark:group-has-[:checked]:text-[#e3c26b]">
                            {{ $permission['label'] }}
                        </span>
                    </label>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
