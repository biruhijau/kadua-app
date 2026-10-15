@section('title', __('Tambah Pengguna'))

<x-app-layout>
    <x-slot name="header">
        <x-page.header :title="__('Tambah Pengguna')" :breadcrumbs="[
        ['label' => __('Pengaturan'), 'href' => '#', 'icon' => 'settings'],
        ['label' => __('Pengguna'), 'href' => route('settings.users.index')],
        ['label' => __('Tambah')],
    ]" />
    </x-slot>

    <div class="px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <div
            class="mx-auto max-w-3xl rounded-2xl border border-black/5 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-neutral-950 sm:p-8">
            <form method="POST" action="{{ route('settings.users.store') }}" class="space-y-6" x-data="{
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
                            window.location = @js(route('settings.users.index'));
                        }
                    },
                }" x-on:input="dirty = true" x-on:change="dirty = true" x-on:submit="dirty = false">
                @csrf
                @include('pages.settings.user.form', ['user' => null])

                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                    <x-form.button-secondary type="button" x-on:click.prevent="cancelForm()">
                        {{ __('Batal') }}
                    </x-form.button-secondary>
                    <x-form.button-primary>{{ __('Simpan') }}</x-form.button-primary>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>