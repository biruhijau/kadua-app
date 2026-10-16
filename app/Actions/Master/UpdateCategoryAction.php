<?php

namespace App\Actions\Master;

use App\Models\Category;

class UpdateCategoryAction
{
    public function handle(Category $category, array $attributes): Category
    {
        $category->update($attributes);

        return $category->refresh();
    }
}
