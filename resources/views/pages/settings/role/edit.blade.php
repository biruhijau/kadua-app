@section('title', __('Edit Peran'))

<x-app-layout>
    <x-slot name="header">
        <x-page.header :title="__('Edit Peran')" :breadcrumbs="[
        ['label' => __('Pengaturan'), 'href' => '#', 'icon' => 'settings'],
        ['label' => __('Peran'), 'href' => route('settings.role.index')],
        ['label' => __('Edit')],
    ]" />
    </x-slot>

    <div class="px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div
                class="rounded-2xl border border-black/5 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-neutral-950 sm:p-8">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-black dark:text-white">
                            {{ __('Informasi Peran') }}
                        </h2>
                        <p class="mt-1 text-sm text-black/55 dark:text-white/55">
                            {{ __('Perbarui nama peran dan izin aksesnya.') }}
                        </p>
                    </header>

                    <form method="POST" action="{{ route('settings.role.update', $role) }}" class="mt-6 space-y-6"
                        x-data="{
                            dirty: false,
                            async cancelForm() {
                                const leave = ! this.dirty || await window.confirmAction({
                                    icon: 'warning',
                                    title: @js(__('Batalkan perubahan?')),
                                    text: @js(__('Perubahan yang belum disimpan akan hilang.')),
                                    confirmText: @js(__('Ya, batalkan')),
                                    danger: true,
                                });

                                if (leave) {
                                    window.location = @js(route('settings.role.index'));
                                }
                            },
                        }" x-on:input="dirty = true" x-on:change="dirty = true" x-on:submit="dirty = false">
                        @csrf
                        @method('patch')
                        @include('pages.settings.role.form')

                        <div
                            class="flex flex-col-reverse items-stretch gap-3 pt-2 sm:flex-row sm:items-center sm:justify-end">
                            <x-form.button-secondary type="button" x-on:click.prevent="cancelForm()"
                                class="w-full sm:w-auto">
                                {{ __('Batal') }}
                            </x-form.button-secondary>
                            <x-form.button-primary class="w-full sm:w-auto">{{ __('Simpan perubahan') }}
                            </x-form.button-primary>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
