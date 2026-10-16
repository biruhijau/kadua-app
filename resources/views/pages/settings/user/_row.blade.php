@php
    $canUpdate = auth()->user()?->can('users.update') ?? false;
    $canDelete = auth()->user()?->can('users.delete') ?? false;
@endphp

<tr class="text-black/75 dark:text-white/75">
    @if ($canUpdate || $canDelete)
        <td class="px-6 py-4"><x-table.select :value="$user->id" /></td>
    @endif
    <td class="whitespace-nowrap px-6 py-4 font-medium text-black dark:text-white">{{ $user->name }}</td>
    <td class="whitespace-nowrap px-6 py-4 text-black/60 dark:text-white/60">{{ $user->email }}</td>
    <td class="px-6 py-4">
        <div class="flex flex-wrap gap-1">
            @forelse ($user->roles as $userRole)
                <x-ui.badge>{{ $userRole->name }}</x-ui.badge>
            @empty
                <span class="whitespace-nowrap text-xs text-black/45 dark:text-white/45">{{ __('Tanpa peran') }}</span>
            @endforelse
        </div>
    </td>
    <td class="whitespace-nowrap px-6 py-4">
        @if ($user->isBlocked())
            <x-ui.badge variant="danger">{{ __('Diblokir') }}</x-ui.badge>
        @else
            <span class="text-green-700 dark:text-green-300">{{ __('Aktif') }}</span>
        @endif
    </td>
    <td class="px-6 py-4">
        <x-table.actions.menu>
            @if ($canUpdate)
                <x-table.actions.item :href="route('settings.users.edit', $user)" icon="pencil">
                    {{ __('Edit') }}
                </x-table.actions.item>

                @if ($user->isBlocked())
                    <x-table.actions.item
                        :action="route('settings.users.unblock', $user)" method="post"
                        icon="rotate-ccw">
                        {{ __('Buka Blokir') }}
                    </x-table.actions.item>
                @else
                    <x-table.actions.item :action="route('settings.users.block', $user)"
                        method="post" icon="ban"
                        :confirm="__('Blokir akun pengguna ini?')" danger>
                        {{ __('Blokir') }}
                    </x-table.actions.item>
                @endif
            @endif

            @if ($canDelete)
                <x-table.actions.item :action="route('settings.users.destroy', $user)"
                    method="delete" icon="trash-2" danger :confirm="__('Hapus pengguna ini?')">
                    {{ __('Hapus') }}
                </x-table.actions.item>
            @endif
        </x-table.actions.menu>
    </td>
</tr>
