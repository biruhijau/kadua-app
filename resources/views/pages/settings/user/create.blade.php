@section('title', __('Tambah Pengguna'))

<x-app-layout>
    <x-slot name="header">
        <x-header.page
            :title="__('Tambah Pengguna')"
            :breadcrumbs="[
                ['label' => __('Pengaturan'), 'href' => '#', 'icon' => 'settings'],
                ['label' => __('Pengguna'), 'href' => route('settings.users.index')],
                ['label' => __('Tambah')],
            ]"
        />
    </x-slot>

    <div class="px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <div class="mx-auto max-w-3xl rounded-2xl border border-black/5 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-neutral-950 sm:p-8">
            <form method="POST" action="{{ route('settings.users.store') }}" class="space-y-6">
                @csrf
                @include('pages.settings.user.form', ['user' => null])

                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                    <x-secondary-button type="button" onclick="window.location='{{ route('settings.users.index') }}'">{{ __('Batal') }}</x-secondary-button>
                    <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
