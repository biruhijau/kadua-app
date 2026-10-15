@section('title', __('Peran'))

<x-app-layout>
    <x-slot name="header">
        <x-page.header :title="__('Peran')" :breadcrumbs="[
        ['label' => __('Pengaturan'), 'href' => '#', 'icon' => 'settings'],
        ['label' => __('Peran')],
    ]" />
    </x-slot>

    <div class="px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <div class="mx-auto max-w-7xl">
            @can('roles.create')
                <div class="mb-4 flex justify-end">
                    <x-form.button-primary class="w-full sm:w-auto"
                        onclick="window.location='{{ route('settings.role.create') }}'">
                        <x-lucide-plus class="mr-2 h-4 w-4" />{{ __('Tambah') }}
                    </x-form.button-primary>
                </div>
            @endcan

            <x-table :has-data="$roles->isNotEmpty()">
                <x-slot name="toolbar">
                    <x-table.toolbar :action="route('settings.role.index')">
                        <x-table.search :value="$search" :placeholder="__('Cari peran...')" />
                        @if ($search !== '')
                            <x-table.reset :href="route('settings.role.index')" />
                        @endif
                    </x-table.toolbar>
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
                            <td class="whitespace-nowrap px-6 py-4 font-medium text-black dark:text-white">{{ $role->name }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4"><x-ui.badge circle>{{ $role->permissions_count }}</x-ui.badge>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4"><x-ui.badge circle>{{ $role->users_count }}</x-ui.badge></td>
                            <td class="px-6 py-4">
                                <x-table.actions.menu>
                                    @can('roles.update')
                                        <x-table.actions.item :href="route('settings.role.edit', $role)" icon="pencil">
                                            {{ __('Edit') }}
                                        </x-table.actions.item>
                                    @endcan
                                    @can('roles.delete')
                                        <x-table.actions.item :action="route('settings.role.destroy', $role)"
                                            method="delete" icon="trash-2" danger :confirm="__('Hapus peran ini?')">
                                            {{ __('Hapus') }}
                                        </x-table.actions.item>
                                    @endcan
                                </x-table.actions.menu>
                            </td>
                        </tr>
                    @endforeach
                </x-slot>

                <x-slot name="empty">{{ __('Belum ada peran.') }}</x-slot>

                @if ($roles->hasPages())
                    <x-slot name="pagination">{{ $roles->links() }}</x-slot>
                @endif
            </x-table>
        </div>
    </div>
</x-app-layout>