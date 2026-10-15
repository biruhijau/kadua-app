<section x-data>
    <header>
        <h2 class="text-lg font-medium text-black dark:text-white">
            {{ __('Aktivitas') }}
        </h2>

        <div class="mt-1 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <p class="text-sm text-black/55 dark:text-white/55">
                {{ __('Kelola perangkat yang sedang masuk ke akun Anda.') }}
            </p>

            @if ($sessions['has_other_sessions'])
                <button type="button" x-on:click.prevent="$dispatch('open-modal', { name: 'revoke-all-sessions' })"
                    class="inline-flex w-full items-center justify-center rounded-lg border border-red-200/70 bg-red-50 px-4 py-2.5 text-sm font-medium text-red-700 transition hover:border-red-300 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-400/40 focus:ring-offset-2 dark:border-red-400/20 dark:bg-red-400/10 dark:text-red-300 dark:hover:bg-red-400/20 dark:focus:ring-offset-black sm:w-auto">
                    {{ __('Keluarkan semua') }}
                </button>
            @endif
        </div>
    </header>

    <div class="mt-6 space-y-3">
        @forelse ($sessions['visible'] as $session)
            <div
                class="flex items-start gap-3 rounded-xl border border-black/5 bg-[#F8F7F4]/70 p-4 dark:border-white/10 dark:bg-white/[0.03] sm:items-center sm:p-5">
                <div class="flex min-w-0 flex-1 items-center gap-4">
                    <x-profile-session-device :user-agent="$session['user_agent']" />
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-x-2 gap-y-1">
                            <p class="truncate text-sm font-medium text-black dark:text-white">
                                {{ $session['device'] }}
                            </p>

                            @if ($session['is_current'])
                                <span
                                    class="rounded-full bg-black/5 px-2 py-0.5 text-xs font-medium text-black/60 dark:bg-white/10 dark:text-white/65">
                                    {{ __('Perangkat ini') }}
                                </span>
                            @elseif ($session['is_expired'])
                                <span
                                    class="rounded-full bg-black/5 px-2 py-0.5 text-xs font-medium text-black/45 dark:bg-white/10 dark:text-white/45">
                                    {{ __('Kadaluarsa') }}
                                </span>
                            @endif
                        </div>

                        <p class="mt-1 text-xs text-black/50 dark:text-white/50">
                            {{ $session['ip_address'] ?: __('IP tidak tersedia') }}
                            <span class="mx-1">&middot;</span>
                            {{ $session['last_active_at']->diffForHumans() }}
                        </p>
                    </div>
                </div>

                @if (!$session['is_current'])
                    <div class="ml-auto shrink-0">
                        <button type="button"
                            x-on:click.prevent="$dispatch('open-modal', { name: 'revoke-session-{{ $session['id'] }}' })"
                            aria-label="{{ __('Keluarkan perangkat ini') }}" title="{{ __('Keluarkan perangkat ini') }}"
                            class="inline-flex h-11 w-11 items-center justify-center rounded-lg border border-red-200/70 bg-red-50 text-red-700 transition hover:border-red-300 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-400/40 focus:ring-offset-2 dark:border-red-400/20 dark:bg-red-400/10 dark:text-red-300 dark:hover:bg-red-400/20 dark:focus:ring-offset-black">
                            <x-lucide-log-out class="h-5 w-5" aria-hidden="true" />
                        </button>
                    </div>

                    <x-ui.modal name="revoke-session-{{ $session['id'] }}"
                        :show="$errors->getBag('sessionRevocation-' . $session['id'])->isNotEmpty()" focusable>
                        <form method="POST" action="{{ route('profile.sessions.destroy', $session['id']) }}" class="p-6">
                            @csrf
                            @method('delete')

                            <h2 class="text-lg font-medium text-black dark:text-white">
                                {{ __('Keluarkan perangkat ini?') }}
                            </h2>

                            <p class="mt-2 text-sm text-black/55 dark:text-white/55">
                                {{ __('Perangkat ini akan dikeluarkan dari akun Anda dan perlu login kembali. Masukkan kata sandi untuk melanjutkan.') }}
                            </p>

                            <div class="mt-6">
                                <x-form.label for="session_password_{{ $session['id'] }}" :value="__('Kata sandi')"
                                    class="sr-only" />
                                <x-form.input id="session_password_{{ $session['id'] }}" name="password" type="password"
                                    class="block w-full" placeholder="{{ __('Kata sandi saat ini') }}"
                                    autocomplete="current-password" />
                                <x-form.error :messages="$errors->getBag('sessionRevocation-' . $session['id'])->get('password')"
                                    class="mt-2" />
                            </div>

                            <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                                <x-form.button-secondary
                                    x-on:click="$dispatch('close-modal', { name: 'revoke-session-{{ $session['id'] }}' })">
                                    {{ __('Batal') }}
                                </x-form.button-secondary>

                                <x-form.button-danger>
                                    {{ __('Keluarkan') }}
                                </x-form.button-danger>
                            </div>
                        </form>
                    </x-ui.modal>
                @endif
            </div>
        @empty
            <p class="py-4 text-sm text-black/55 dark:text-white/55">
                {{ __('Tidak ada aktivitas login yang tersedia.') }}
            </p>
        @endforelse

        @if ($sessions['remaining'] > 0)
            <p class="px-1 pt-1 text-sm font-medium text-black/55 dark:text-white/55">
                +{{ $sessions['remaining'] }} {{ __('Lainnya') }}
            </p>
        @endif
    </div>

    @if ($sessions['has_other_sessions'])
        <x-ui.modal name="revoke-all-sessions" :show="$errors->sessionRevocationAll->isNotEmpty()" focusable>
            <form method="POST" action="{{ route('profile.sessions.destroy-others') }}" class="p-6">
                @csrf
                @method('delete')

                <h2 class="text-lg font-medium text-black dark:text-white">
                    {{ __('Keluarkan semua perangkat lain?') }}
                </h2>

                <p class="mt-2 text-sm text-black/55 dark:text-white/55">
                    {{ __('Semua perangkat lain akan dikeluarkan dari akun Anda. Perangkat ini tetap aktif. Masukkan kata sandi untuk melanjutkan.') }}
                </p>

                <div class="mt-6">
                    <x-form.label for="revoke_all_password" :value="__('Kata sandi')" class="sr-only" />
                    <x-form.input id="revoke_all_password" name="password" type="password" class="block w-full"
                        placeholder="{{ __('Kata sandi saat ini') }}" autocomplete="current-password" />
                    <x-form.error :messages="$errors->sessionRevocationAll->get('password')" class="mt-2" />
                </div>

                <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                    <x-form.button-secondary x-on:click="$dispatch('close-modal', { name: 'revoke-all-sessions' })">
                        {{ __('Batal') }}
                    </x-form.button-secondary>

                    <x-form.button-danger>
                        {{ __('Keluarkan semua') }}
                    </x-form.button-danger>
                </div>
            </form>
        </x-ui.modal>
    @endif
</section>