<div>
    <x-form.label for="name" :value="__('Nama')" />
    <x-form.input id="name" name="name" type="text" :value="old('name', $user?->name)"
        placeholder="{{ __('Masukkan nama lengkap') }}" required autofocus class="mt-1 block w-full" />
    <x-form.error :messages="$errors->get('name')" class="mt-2" />
</div>

<div>
    <x-form.label for="email" :value="__('Email')" />
    <x-form.input id="email" name="email" type="email" :value="old('email', $user?->email)"
        placeholder="{{ __('Masukkan email') }}" required class="mt-1 block w-full" />
    <x-form.error :messages="$errors->get('email')" class="mt-2" />
</div>

<div>
    <x-form.label for="password" :value="__('Password')" />
    <x-form.input id="password" name="password" type="password" :required="!$user"
        placeholder="{{ $user ? __('Masukkan kata sandi baru') : __('Buat kata sandi') }}" class="mt-1 block w-full"
        autocomplete="new-password" />
    <x-form.error :messages="$errors->get('password')" class="mt-2" />
</div>

<div>
    <x-form.label for="password_confirmation" :value="__('Konfirmasi password')" />
    <x-form.input id="password_confirmation" name="password_confirmation" type="password" :required="!$user"
        placeholder="{{ __('Konfirmasi kata sandi') }}" class="mt-1 block w-full" autocomplete="new-password" />
</div>

<div>
    <x-form.label :value="__('Peran')" />
    <x-form.multiselect name="roles" :selected="old('roles', $user?->roles->pluck('id')->all() ?? [])"
        :options="$roles->pluck('name', 'id')->all()" :placeholder="__('Pilih peran')" class="mt-1" />
    <x-form.error :messages="$errors->get('roles')" class="mt-2" />
</div>
