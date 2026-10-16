<?php

namespace App\Actions\Master;

use App\Models\ProductCategory;

class UpdateProductCategoryAction
{
    public function handle(ProductCategory $productCategory, array $attributes): ProductCategory
    {
        $productCategory->update($attributes);

        return $productCategory->refresh();
    }
}
