@section('title', __('Produk'))

<x-app-layout>
    <x-slot name="header">
        <x-page.header :title="__('Produk')" :breadcrumbs="[
            ['label' => __('Data Master'), 'href' => '#', 'icon' => 'database'],
            ['label' => __('Produk')],
        ]" />
    </x-slot>

    <div class="px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <div class="mx-auto max-w-7xl">
            @can('products.create')
                <div class="mb-4 flex justify-end">
                    <x-form.button-primary class="w-full sm:w-auto"
                        onclick="window.location='{{ route('master.products.create') }}'">
                        <x-lucide-plus class="mr-2 h-4 w-4" />{{ __('Tambah') }}
                    </x-form.button-primary>
                </div>
            @endcan

            <x-table :has-data="$products->isNotEmpty()" :selectable="true" :ids="$products->pluck('id')->all()">
                <x-slot name="toolbar">
                    <x-table.toolbar :action="route('master.products.index')">
                        <x-table.search :value="$search" :placeholder="__('Cari nama atau SKU...')" />
                        <x-table.filter name="status" :selected="$status" :placeholder="__('Semua status')"
                            :options="['active' => __('Aktif'), 'inactive' => __('Nonaktif')]" />
                        @if ($search !== '' || $status !== '')
                            <x-table.reset :href="route('master.products.index')" />
                        @endif
                    </x-table.toolbar>
                </x-slot>

                @if ($products->isNotEmpty())
                    <x-slot name="bulk">
                        <x-table.bulk>
                            @can('products.delete')
                                <button type="button" data-action="{{ route('master.products.bulk-destroy') }}"
                                    data-method="DELETE" data-confirm="{{ __('Hapus produk terpilih?') }}"
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
                        @can('products.delete')
                            <th class="w-12 px-6 py-4"><x-table.select-all /></th>
                        @endcan
                        <th class="whitespace-nowrap px-6 py-4">{{ __('Nama') }}</th>
                        <th class="whitespace-nowrap px-6 py-4">{{ __('Kategori') }}</th>
                        <th class="whitespace-nowrap px-6 py-4">{{ __('Tipe') }}</th>
                        <th class="whitespace-nowrap px-6 py-4">{{ __('Harga Jual') }}</th>
                        <th class="whitespace-nowrap px-6 py-4">{{ __('Status') }}</th>
                        <th class="w-16 px-6 py-4"><span class="sr-only">{{ __('Aksi') }}</span></th>
                    </tr>
                </x-slot>

                <x-slot name="body">
                    @foreach ($products as $product)
                        <tr class="text-black/75 dark:text-white/75">
                            @can('products.delete')
                                <td class="px-6 py-4"><x-table.select :value="$product->id" /></td>
                            @endcan
                            <td class="whitespace-nowrap px-6 py-4 font-medium text-black dark:text-white">
                                <div>{{ $product->name }}</div>
                                <div class="mt-0.5 text-xs text-black/45 dark:text-white/45">{{ $product->number }} · {{ $product->sku }}</div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">{{ $product->category?->name ?? __('—') }}</td>
                            <td class="whitespace-nowrap px-6 py-4">{{ $product->type?->label() ?? __('—') }}</td>
                            <td class="whitespace-nowrap px-6 py-4">
                                {{ $product->selling_price !== null ? number_format((float) $product->selling_price, 0, ',', '.') : __('—') }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                @if ($product->is_active)
                                    <x-ui.badge variant="success">{{ __('Aktif') }}</x-ui.badge>
                                @else
                                    <x-ui.badge variant="neutral">{{ __('Nonaktif') }}</x-ui.badge>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <x-table.actions.menu>
                                    @can('products.update')
                                        <x-table.actions.item :href="route('master.products.edit', $product)" icon="pencil">
                                            {{ __('Edit') }}
                                        </x-table.actions.item>
                                        <x-table.actions.item :action="route('master.products.toggle-status', $product)"
                                            method="patch" icon="power">
                                            {{ $product->is_active ? __('Nonaktifkan') : __('Aktifkan') }}
                                        </x-table.actions.item>
                                    @endcan
                                    @can('products.delete')
                                        <x-table.actions.item :action="route('master.products.destroy', $product)"
                                            method="delete" icon="trash-2" danger :confirm="__('Hapus produk ini?')">
                                            {{ __('Hapus') }}
                                        </x-table.actions.item>
                                    @endcan
                                </x-table.actions.menu>
                            </td>
                        </tr>
                    @endforeach
                </x-slot>

                <x-slot name="empty">{{ __('Belum ada produk.') }}</x-slot>

                @if ($products->hasPages())
                    <x-slot name="pagination">{{ $products->links() }}</x-slot>
                @endif
            </x-table>
        </div>
    </div>
</x-app-layout>
