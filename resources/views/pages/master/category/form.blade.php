<div>
    <x-form.label for="name" :value="__('Nama kategori')" />
    <x-form.input id="name" name="name" :value="old('name', $category?->name)" required autofocus
        placeholder="{{ __('Masukkan nama kategori') }}" class="mt-1 block w-full" />
    <x-form.error :messages="$errors->get('name')" class="mt-2" />
</div>

<div>
    <x-form.label for="description" :value="__('Deskripsi')" />
    <x-form.textarea id="description" name="description" rows="4"
        :value="old('description', $category?->description)"
        :placeholder="__('Masukkan deskripsi kategori (opsional)')" class="mt-1 block w-full" />
    <x-form.error :messages="$errors->get('description')" class="mt-2" />
</div>

<div>
    <x-form.label for="is_active" :value="__('Status')" />
    <x-form.select name="is_active" :options="['1' => __('Aktif'), '0' => __('Nonaktif')]"
        :selected="old('is_active', ($category?->is_active ?? true) ? '1' : '0')"
        :placeholder="__('Pilih status')" class="mt-1 block w-full" />
    <x-form.error :messages="$errors->get('is_active')" class="mt-2" />
</div>
