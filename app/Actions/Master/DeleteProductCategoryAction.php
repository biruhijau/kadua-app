<?php

namespace App\Actions\Master;

use App\Models\ProductCategory;

class DeleteProductCategoryAction
{
    public function handle(ProductCategory $productCategory): void
    {
        $productCategory->delete();
    }
}
