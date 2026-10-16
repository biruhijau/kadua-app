<?php

namespace App\Actions\Master;

use App\Models\Category;

class DeleteCategoryAction
{
    public function handle(Category $category): void
    {
        $category->delete();
    }
}
