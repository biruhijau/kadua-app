<?php

namespace App\Actions\Master;

use App\Models\ProductCategory;

class CreateProductCategoryAction
{
    public function handle(array $attributes): ProductCategory
    {
        return ProductCategory::create($attributes);
    }
}
