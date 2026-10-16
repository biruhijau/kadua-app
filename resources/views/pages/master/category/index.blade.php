@section('title', __('Kategori'))

<x-app-layout>
    <x-slot name="header">
        <x-page.header :title="__('Kategori')" :breadcrumbs="[
            ['label' => __('Data Master'), 'href' => '#', 'icon' => 'database'],
            ['label' => __('Kategori')],
        ]" />
    </x-slot>

    <div class="px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <div class="mx-auto max-w-7xl">
            @can('categories.create')
                <div class="mb-4 flex justify-end">
                    <x-form.button-primary class="w-full sm:w-auto"
                        onclick="window.location='{{ route('master.categories.create') }}'">
                        <x-lucide-plus class="mr-2 h-4 w-4" />{{ __('Tambah') }}
                    </x-form.button-primary>
                </div>
            @endcan

            <x-table :has-data="$categories->isNotEmpty()" :selectable="true" :ids="$categories->pluck('id')->all()">
                <x-slot name="toolbar">
                    <x-table.toolbar :action="route('master.categories.index')">
                        <x-table.search :value="$search" :placeholder="__('Cari kategori...')" />
                        <x-table.filter name="status" :selected="$status" :placeholder="__('Semua status')"
                            :options="['active' => __('Aktif'), 'inactive' => __('Nonaktif')]" />
                        @if ($search !== '')
                            <x-table.reset :href="route('master.categories.index')" />
                        @endif
                    </x-table.toolbar>
                </x-slot>

                @if ($categories->isNotEmpty())
                    <x-slot name="bulk">
                        <x-table.bulk>
                            @can('categories.delete')
                                <button type="button" data-action="{{ route('master.categories.bulk-destroy') }}"
                                    data-method="DELETE" data-confirm="{{ __('Hapus kategori terpilih?') }}"
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
                        @can('categories.delete')
                            <th class="w-12 px-6 py-4"><x-table.select-all /></th>
                        @endcan
                        <th class="whitespace-nowrap px-6 py-4">{{ __('Nama') }}</th>
                        <th class="whitespace-nowrap px-6 py-4">{{ __('Induk') }}</th>
                        <th class="whitespace-nowrap px-6 py-4">{{ __('Status') }}</th>
                        <th class="whitespace-nowrap px-6 py-4">{{ __('Dibuat') }}</th>
                        <th class="w-16 px-6 py-4"><span class="sr-only">{{ __('Aksi') }}</span></th>
                    </tr>
                </x-slot>

                <x-slot name="body">
                    @foreach ($categories as $category)
                        <tr class="text-black/75 dark:text-white/75">
                            @can('categories.delete')
                                <td class="px-6 py-4"><x-table.select :value="$category->id" /></td>
                            @endcan
                            <td class="whitespace-nowrap px-6 py-4 font-medium text-black dark:text-white">
                                {{ $category->name }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                {{ $category->parent?->name ?? __('—') }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                @if ($category->is_active)
                                    <x-ui.badge variant="success">{{ __('Aktif') }}</x-ui.badge>
                                @else
                                    <x-ui.badge variant="neutral">{{ __('Nonaktif') }}</x-ui.badge>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                {{ $category->created_at?->format('d/m/Y') ?? __('—') }}
                            </td>
                            <td class="px-6 py-4">
                                <x-table.actions.menu>
                                    @can('categories.update')
                                        <x-table.actions.item
                                            :href="route('master.categories.edit', $category)" icon="pencil">
                                            {{ __('Edit') }}
                                        </x-table.actions.item>
                                        <x-table.actions.item :action="route('master.categories.toggle-status', $category)"
                                            method="patch" icon="power">
                                            {{ $category->is_active ? __('Nonaktifkan') : __('Aktifkan') }}
                                        </x-table.actions.item>
                                    @endcan
                                    @can('categories.delete')
                                        <x-table.actions.item
                                            :action="route('master.categories.destroy', $category)"
                                            method="delete" icon="trash-2" danger :confirm="__('Hapus kategori ini?')">
                                            {{ __('Hapus') }}
                                        </x-table.actions.item>
                                    @endcan
                                </x-table.actions.menu>
                            </td>
                        </tr>
                    @endforeach
                </x-slot>

                <x-slot name="empty">{{ __('Belum ada kategori.') }}</x-slot>

                @if ($categories->hasPages())
                    <x-slot name="pagination">{{ $categories->links() }}</x-slot>
                @endif
            </x-table>
        </div>
    </div>
</x-app-layout>
