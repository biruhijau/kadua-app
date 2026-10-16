<?php

namespace App\Actions\Master;

use App\Models\Category;

class CreateCategoryAction
{
    public function handle(array $attributes): Category
    {
        $attributes['is_active'] = $attributes['is_active'] ?? true;

        return Category::create($attributes);
    }
}
