<div class="grid gap-6 md:grid-cols-2">
    @if ($product)
        <div>
            <x-form.label for="number" :value="__('Product Number')" />
            <x-form.input id="number" :value="$product->number" readonly class="mt-1 block w-full" />
        </div>
        <div>
            <x-form.label for="sku" :value="__('SKU')" />
            <x-form.input id="sku" :value="$product->sku" readonly class="mt-1 block w-full" />
        </div>
    @endif
    <div>
        <x-form.label for="name" :value="__('Nama produk')" />
        <x-form.input id="name" name="name" :value="old('name', $product?->name)" required
            placeholder="{{ __('Masukkan nama produk') }}" class="mt-1 block w-full" />
        <x-form.error :messages="$errors->get('name')" class="mt-2" />
    </div>
    <div>
        <x-form.label for="category_id" :value="__('Kategori')" />
        <x-form.select name="category_id" :options="$categories" :selected="old('category_id', $product?->category_id)"
            :placeholder="__('Pilih kategori aktif')" required class="mt-1 block w-full" />
        <x-form.error :messages="$errors->get('category_id')" class="mt-2" />
    </div>
    <div>
        <x-form.label for="type" :value="__('Tipe')" />
        <x-form.select name="type" :options="collect(\App\Enums\ProductType::cases())->mapWithKeys(fn ($type) => [$type->value => $type->label()])->all()" :selected="old('type', $product?->type?->value ?? 'drink')" :placeholder="__('Pilih tipe produk')" class="mt-1 block w-full" />
    </div>
    <div>
        <x-form.label for="purchase_price" :value="__('Harga beli')" />
        <x-form.money-input id="purchase_price" name="purchase_price" :value="$product?->purchase_price" required placeholder="{{ __('Contoh: 10.000') }}" class="mt-1 block w-full" />
        <x-form.error :messages="$errors->get('purchase_price')" class="mt-2" />
    </div>
    <div>
        <x-form.label for="selling_price" :value="__('Harga jual')" />
        <x-form.money-input id="selling_price" name="selling_price" :value="$product?->selling_price" required placeholder="{{ __('Contoh: 18.000') }}" class="mt-1 block w-full" />
        <x-form.error :messages="$errors->get('selling_price')" class="mt-2" />
    </div>
    <div>
        <x-form.label for="is_active" :value="__('Status')" />
        <x-form.select name="is_active" :options="['1' => __('Aktif'), '0' => __('Nonaktif')]" :selected="old('is_active', ($product?->is_active ?? true) ? '1' : '0')" class="mt-1 block w-full" />
    </div>
    <div>
        <x-form.label for="is_signature" :value="__('Signature menu')" />
        <x-form.select name="is_signature" :options="['1' => __('Ya'), '0' => __('Tidak')]" :selected="old('is_signature', ($product?->is_signature ?? false) ? '1' : '0')" class="mt-1 block w-full" />
    </div>
</div>
<div>
    <x-form.label for="description" :value="__('Deskripsi')" />
    <x-form.textarea id="description" name="description" rows="4" :value="old('description', $product?->description)" :placeholder="__('Masukkan deskripsi produk (opsional)')" class="mt-1 block w-full" />
</div>
<x-form.media-upload :label="__('Gambar produk')" :existing="$product?->getMedia('product-images')->all() ?? []" />
