<?php

namespace App\Actions\Master;

use App\Models\Product;

class UpdateProductAction
{
    public function handle(Product $product, array $data): Product
    {
        $product->update($data);

        return $product->refresh();
    }
}
