<?php

namespace App\Actions\Master;

use App\Models\Product;
use Illuminate\Validation\ValidationException;

class DeleteProductAction
{
    public function handle(Product $product): void
    {
        if ($product->variants()->exists() || $product->barcodes()->exists()) {
            throw ValidationException::withMessages([
                'product' => __('Produk tidak dapat dihapus karena masih memiliki varian atau barcode.'),
            ]);
        }

        $product->delete();
    }
}
