<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductVariantFactory extends Factory
{
    protected $model = ProductVariant::class;

    public function definition(): array
    {
        return ['product_id' => Product::factory(), 'name' => fake()->word(), 'sku' => 'VAR-'.fake()->unique()->numerify('######'), 'price' => fake()->randomFloat(2, 1000, 100000), 'is_active' => true];
    }
}
