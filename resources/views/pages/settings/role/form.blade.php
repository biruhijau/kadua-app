<div>
    <x-form.label for="name" :value="__('Nama peran')" />
    <x-form.input id="name" name="name" :value="old('name', $role?->name)" required autofocus
        placeholder="{{ __('Masukkan nama peran') }}" class="mt-1 block w-full" />
    <x-form.error :messages="$errors->get('name')" class="mt-2" />
</div>

<x-form.permission-fields :groups="$permissionGroups" :selected="old('permissions', $role?->permissions->pluck('id')->all() ?? [])" />