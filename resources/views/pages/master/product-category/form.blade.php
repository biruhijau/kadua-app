<div>
    <x-form.label for="name" :value="__('Nama kategori')" />
    <x-form.input id="name" name="name" :value="old('name', $productCategory?->name)" required autofocus
        placeholder="{{ __('Masukkan nama kategori') }}" class="mt-1 block w-full" />
    <x-form.error :messages="$errors->get('name')" class="mt-2" />
</div>

<div>
    <x-form.label for="description" :value="__('Deskripsi')" />
    <x-form.textarea id="description" name="description" rows="4"
        :value="old('description', $productCategory?->description)"
        :placeholder="__('Masukkan deskripsi kategori (opsional)')" class="mt-1 block w-full" />
    <x-form.error :messages="$errors->get('description')" class="mt-2" />
</div>
