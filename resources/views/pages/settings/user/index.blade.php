@section('title', __('Pengguna'))

<x-app-layout>
    <x-slot name="header">
        <x-page.header :title="__('Pengguna')" :breadcrumbs="[
        ['label' => __('Pengaturan'), 'href' => '#', 'icon' => 'settings'],
        ['label' => __('Pengguna')],
    ]" />
    </x-slot>

    <div class="px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <div class="mx-auto max-w-7xl">
            @can('users.create')
                <div class="mb-4 flex justify-end">
                    <x-form.button-primary class="w-full sm:w-auto"
                        onclick="window.location='{{ route('settings.users.create') }}'">
                        <x-lucide-plus class="mr-2 h-4 w-4" />{{ __('Tambah') }}
                    </x-form.button-primary>
                </div>
            @endcan

            <x-table :has-data="$users->isNotEmpty()" :selectable="true" :ids="$users->pluck('id')->all()"
                :blocked-ids="$users->getCollection()->filter(fn ($user) => $user->isBlocked())->pluck('id')->all()">
                <x-slot name="toolbar">
                    <x-table.toolbar :action="route('settings.users.index')">
                        <x-table.search :value="$search" :placeholder="__('Cari nama atau email...')" />
                        <x-table.filter name="role" :selected="$role" :placeholder="__('Semua peran')"
                            :options="$roles->pluck('name', 'name')->all()" />
                        @if ($search !== '' || $role !== '')
                            <x-table.reset :href="route('settings.users.index')" />
                        @endif
                    </x-table.toolbar>
                </x-slot>

                @if ($users->isNotEmpty())
                    <x-slot name="bulk">
                        <x-table.bulk>
                            @can('users.update')
                                <x-table.bulk-button
                                    :block-route="route('settings.users.bulk-block')"
                                    :unblock-route="route('settings.users.bulk-unblock')"
                                    :confirm-block="__('Blokir pengguna terpilih?')"
                                    :confirm-unblock="__('Buka blokir pengguna terpilih?')" />
                            @endcan

                            @can('users.delete')
                                <button type="button" data-action="{{ route('settings.users.bulk-destroy') }}"
                                    data-method="DELETE" data-confirm="{{ __('Hapus pengguna terpilih?') }}"
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
                        @canany(['users.update', 'users.delete'])
                            <th class="w-12 px-6 py-4"><x-table.select-all /></th>
                        @endcanany
                        <th class="whitespace-nowrap px-6 py-4">{{ __('Nama') }}</th>
                        <th class="whitespace-nowrap px-6 py-4">{{ __('Email') }}</th>
                        <th class="whitespace-nowrap px-6 py-4">{{ __('Peran') }}</th>
                        <th class="whitespace-nowrap px-6 py-4">{{ __('Status') }}</th>
                        <th class="w-16 px-6 py-4"><span class="sr-only">{{ __('Aksi') }}</span></th>
                    </tr>
                </x-slot>

                <x-slot name="body">
                    @foreach ($users as $user)
                        @include('pages.settings.user._row', ['user' => $user])
                    @endforeach
                </x-slot>

                <x-slot name="empty">{{ __('Belum ada pengguna.') }}</x-slot>

                @if ($users->hasPages())
                    <x-slot name="pagination">{{ $users->links() }}</x-slot>
                @endif
            </x-table>
        </div>
    </div>
</x-app-layout>
