@section('title', __('Peran'))

<x-app-layout>
    <x-slot name="header">
        <x-header.page
            :title="__('Peran')"
            :breadcrumbs="[
                ['label' => __('Pengaturan'), 'href' => '#', 'icon' => 'settings'],
                ['label' => __('Peran')],
            ]"
        />
    </x-slot>

    <div class="px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <div class="mx-auto max-w-7xl">
            @if (session('status'))
                <x-alert.success>{{ __('Perubahan peran berhasil disimpan.') }}</x-alert.success>
            @endif

            @can('roles.create')
                <div class="mb-4 flex justify-end">
                    <x-primary-button class="w-full sm:w-auto" onclick="window.location='{{ route('settings.role.create') }}'">
                        <x-lucide-plus class="mr-2 h-4 w-4" />{{ __('Tambah') }}
                    </x-primary-button>
                </div>
            @endcan

            <x-datatable.table :has-data="$roles->isNotEmpty()">
                <x-slot name="toolbar">
                    <x-datatable.toolbar :action="route('settings.role.index')">
                        <x-datatable.search :value="$search" :placeholder="__('Cari peran...')" />
                        @if ($search !== '')
                            <x-datatable.reset :href="route('settings.role.index')" />
                        @endif
                    </x-datatable.toolbar>
                </x-slot>

                <x-slot name="head">
                    <tr>
                        <th class="whitespace-nowrap px-6 py-4">{{ __('Nama') }}</th>
                        <th class="whitespace-nowrap px-6 py-4">{{ __('Permission') }}</th>
                        <th class="whitespace-nowrap px-6 py-4">{{ __('Pengguna') }}</th>
                        <th class="w-16 px-6 py-4"><span class="sr-only">{{ __('Aksi') }}</span></th>
                    </tr>
                </x-slot>

                <x-slot name="body">
                    @foreach ($roles as $role)
                        <tr class="text-black/75 dark:text-white/75">
                            <td class="whitespace-nowrap px-6 py-4 font-medium text-black dark:text-white">{{ $role->name }}</td>
                            <td class="whitespace-nowrap px-6 py-4"><x-badge>{{ $role->permissions_count }}</x-badge></td>
                            <td class="whitespace-nowrap px-6 py-4"><x-badge>{{ $role->users_count }}</x-badge></td>
                            <td class="px-6 py-4">
                                <x-datatable.actions.menu>
                                    @can('roles.update')
                                        <x-datatable.actions.item :href="route('settings.role.edit', $role)" icon="pencil">
                                            {{ __('Edit') }}
                                        </x-datatable.actions.item>
                                    @endcan
                                    @can('roles.delete')
                                        <x-datatable.actions.item
                                            :action="route('settings.role.destroy', $role)"
                                            method="delete"
                                            icon="trash-2"
                                            danger
                                            :confirm="__('Hapus peran ini?')"
                                        >
                                            {{ __('Hapus') }}
                                        </x-datatable.actions.item>
                                    @endcan
                                </x-datatable.actions.menu>
                            </td>
                        </tr>
                    @endforeach
                </x-slot>

                <x-slot name="empty">{{ __('Belum ada peran.') }}</x-slot>

                @if ($roles->hasPages())
                    <x-slot name="pagination">{{ $roles->links() }}</x-slot>
                @endif
            </x-datatable.table>
        </div>
    </div>
</x-app-layout>
