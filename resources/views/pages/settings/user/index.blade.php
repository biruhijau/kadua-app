@section('title', __('Pengguna'))

<x-app-layout>
    <x-slot name="header">
        <x-header.page :title="__('Pengguna')" :breadcrumbs="[
        ['label' => __('Pengaturan'), 'href' => '#', 'icon' => 'settings'],
        ['label' => __('Pengguna')],
    ]" />
    </x-slot>

    <div class="px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <div class="mx-auto max-w-7xl">
            @can('users.create')
                <div class="mb-4 flex justify-end">
                    <x-primary-button class="w-full sm:w-auto"
                        onclick="window.location='{{ route('settings.users.create') }}'">
                        <x-lucide-plus class="mr-2 h-4 w-4" />{{ __('Tambah') }}
                    </x-primary-button>
                </div>
            @endcan

            <x-datatable.table :has-data="$users->isNotEmpty()">
                <x-slot name="toolbar">
                    <x-datatable.toolbar :action="route('settings.users.index')">
                        <x-datatable.search :value="$search" :placeholder="__('Cari nama atau email...')" />
                        <x-datatable.filter name="role" :selected="$role" :placeholder="__('Semua peran')"
                            :options="$roles->pluck('name', 'name')->all()" />
                        @if ($search !== '' || $role !== '')
                            <x-datatable.reset :href="route('settings.users.index')" />
                        @endif
                    </x-datatable.toolbar>
                </x-slot>

                <x-slot name="head">
                    <tr>
                        <th class="whitespace-nowrap px-6 py-4">{{ __('Nama') }}</th>
                        <th class="whitespace-nowrap px-6 py-4">{{ __('Email') }}</th>
                        <th class="whitespace-nowrap px-6 py-4">{{ __('Peran') }}</th>
                        <th class="whitespace-nowrap px-6 py-4">{{ __('Status') }}</th>
                        <th class="w-16 px-6 py-4"><span class="sr-only">{{ __('Aksi') }}</span></th>
                    </tr>
                </x-slot>

                <x-slot name="body">
                    @foreach ($users as $user)
                        <tr class="text-black/75 dark:text-white/75">
                            <td class="whitespace-nowrap px-6 py-4 font-medium text-black dark:text-white">{{ $user->name }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-black/60 dark:text-white/60">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @forelse ($user->roles as $userRole)
                                        <x-badge>{{ $userRole->name }}</x-badge>
                                    @empty
                                        <span
                                            class="whitespace-nowrap text-xs text-black/45 dark:text-white/45">{{ __('Tanpa peran') }}</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                @if ($user->email_verified_at)
                                    <span class="text-green-700 dark:text-green-300">{{ __('Terverifikasi') }}</span>
                                @else
                                    <span class="text-amber-700 dark:text-amber-300">{{ __('Belum diverifikasi') }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <x-datatable.actions.menu>
                                    @can('users.update')
                                        <x-datatable.actions.item :href="route('settings.users.edit', $user)" icon="pencil">
                                            {{ __('Edit') }}
                                        </x-datatable.actions.item>
                                    @endcan
                                    @can('users.delete')
                                        <x-datatable.actions.item :action="route('settings.users.destroy', $user)"
                                            method="delete" icon="trash-2" danger :confirm="__('Hapus pengguna ini?')">
                                            {{ __('Hapus') }}
                                        </x-datatable.actions.item>
                                    @endcan
                                </x-datatable.actions.menu>
                            </td>
                        </tr>
                    @endforeach
                </x-slot>

                <x-slot name="empty">{{ __('Belum ada pengguna.') }}</x-slot>

                @if ($users->hasPages())
                    <x-slot name="pagination">{{ $users->links() }}</x-slot>
                @endif
            </x-datatable.table>
        </div>
    </div>
</x-app-layout>