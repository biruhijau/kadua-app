<div>
    <x-input-label for="name" :value="__('Nama peran')" />
    <x-text-input id="name" name="name" :value="old('name', $role?->name)" required autofocus placeholder="staff"
        class="mt-1 block w-full" />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<x-settings-permission-fields :groups="$permissionGroups" :selected="old('permissions', $role?->permissions->pluck('id')->all() ?? [])" />