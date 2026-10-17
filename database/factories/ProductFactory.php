<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return ['number' => 'PRD'.fake()->unique()->numerify('######'), 'name' => fake()->words(3, true), 'sku' => 'SKU-'.fake()->unique()->numerify('######'), 'category_id' => Category::factory(), 'purchase_price' => fake()->randomFloat(2, 1000, 50000), 'selling_price' => fake()->randomFloat(2, 50000, 100000), 'is_active' => true];
    }
}
