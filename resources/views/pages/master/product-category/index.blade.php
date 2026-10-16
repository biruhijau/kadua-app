@section('title', __('Kategori Produk'))

<x-app-layout>
    <x-slot name="header">
        <x-page.header :title="__('Kategori Produk')" :breadcrumbs="[
            ['label' => __('Data Master'), 'href' => '#', 'icon' => 'database'],
            ['label' => __('Kategori Produk')],
        ]" />
    </x-slot>

    <div class="px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <div class="mx-auto max-w-7xl">
            @can('product-categories.create')
                <div class="mb-4 flex justify-end">
                    <x-form.button-primary class="w-full sm:w-auto"
                        onclick="window.location='{{ route('master.product-categories.create') }}'">
                        <x-lucide-plus class="mr-2 h-4 w-4" />{{ __('Tambah') }}
                    </x-form.button-primary>
                </div>
            @endcan

            <x-table :has-data="$productCategories->isNotEmpty()" :selectable="true" :ids="$productCategories->pluck('id')->all()">
                <x-slot name="toolbar">
                    <x-table.toolbar :action="route('master.product-categories.index')">
                        <x-table.search :value="$search" :placeholder="__('Cari kategori produk...')" />
                        @if ($search !== '')
                            <x-table.reset :href="route('master.product-categories.index')" />
                        @endif
                    </x-table.toolbar>
                </x-slot>

                @if ($productCategories->isNotEmpty())
                    <x-slot name="bulk">
                        <x-table.bulk>
                            @can('product-categories.delete')
                                <button type="button" data-action="{{ route('master.product-categories.bulk-destroy') }}"
                                    data-method="DELETE" data-confirm="{{ __('Hapus kategori produk terpilih?') }}"
                                    data-danger="true" x-on:click="submitBulk($el)"
                                    class="inline-flex w-full items-center justify-center rounded-lg bg-red-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400/40 dark:bg-red-500 dark:hover:bg-red-400 sm:w-auto">
                                    <x-lucide-trash-2 class="mr-2 h-4 w-4" />{{ __('Hapus') }}
                                </button>
                            @endcan
                        </x-table.bulk>
                    </x-slot>
                @endif

                <x-slot name="head">
                    <tr>
                        @can('product-categories.delete')
                            <th class="w-12 px-6 py-4"><x-table.select-all /></th>
                        @endcan
                        <th class="whitespace-nowrap px-6 py-4">{{ __('Nama') }}</th>
                        <th class="whitespace-nowrap px-6 py-4">{{ __('Deskripsi') }}</th>
                        <th class="w-16 px-6 py-4"><span class="sr-only">{{ __('Aksi') }}</span></th>
                    </tr>
                </x-slot>

                <x-slot name="body">
                    @foreach ($productCategories as $productCategory)
                        <tr class="text-black/75 dark:text-white/75">
                            @can('product-categories.delete')
                                <td class="px-6 py-4"><x-table.select :value="$productCategory->id" /></td>
                            @endcan
                            <td class="whitespace-nowrap px-6 py-4 font-medium text-black dark:text-white">
                                {{ $productCategory->name }}
                            </td>
                            <td class="max-w-xl whitespace-nowrap px-6 py-4">
                                {{ $productCategory->description ?: __('—') }}
                            </td>
                            <td class="px-6 py-4">
                                <x-table.actions.menu>
                                    @can('product-categories.update')
                                        <x-table.actions.item
                                            :href="route('master.product-categories.edit', $productCategory)" icon="pencil">
                                            {{ __('Edit') }}
                                        </x-table.actions.item>
                                    @endcan
                                    @can('product-categories.delete')
                                        <x-table.actions.item
                                            :action="route('master.product-categories.destroy', $productCategory)"
                                            method="delete" icon="trash-2" danger :confirm="__('Hapus kategori produk ini?')">
                                            {{ __('Hapus') }}
                                        </x-table.actions.item>
                                    @endcan
                                </x-table.actions.menu>
                            </td>
                        </tr>
                    @endforeach
                </x-slot>

                <x-slot name="empty">{{ __('Belum ada kategori produk.') }}</x-slot>

                @if ($productCategories->hasPages())
                    <x-slot name="pagination">{{ $productCategories->links() }}</x-slot>
                @endif
            </x-table>
        </div>
    </div>
</x-app-layout>
