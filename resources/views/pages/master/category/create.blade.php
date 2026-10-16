@section('title', __('Tambah Kategori'))

<x-app-layout>
    <x-slot name="header">
        <x-page.header :title="__('Tambah Kategori')" :breadcrumbs="[
            ['label' => __('Data Master'), 'href' => '#', 'icon' => 'database'],
            ['label' => __('Kategori'), 'href' => route('master.categories.index')],
            ['label' => __('Tambah')],
        ]" />
    </x-slot>

    <div class="px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="rounded-2xl border border-black/5 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-neutral-950 sm:p-8">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-black dark:text-white">{{ __('Informasi Kategori') }}</h2>
                        <p class="mt-1 text-sm text-black/55 dark:text-white/55">{{ __('Buat kategori baru.') }}</p>
                    </header>
                    <form method="POST" action="{{ route('master.categories.store') }}" class="mt-6 space-y-6">
                        @csrf
                        @include('pages.master.category.form', ['category' => null])
                        <div class="flex flex-col-reverse items-stretch gap-3 pt-2 sm:flex-row sm:items-center sm:justify-end">
                            <x-form.button-secondary type="button" onclick="history.back()" class="w-full sm:w-auto">{{ __('Batal') }}</x-form.button-secondary>
                            <x-form.button-primary class="w-full sm:w-auto">{{ __('Simpan') }}</x-form.button-primary>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
