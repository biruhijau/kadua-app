<?php

namespace App\Actions\Master;

use App\Models\Product;
use App\Services\NumberSequenceService;
use Illuminate\Support\Facades\DB;

class CreateProductAction
{
    public function __construct(private NumberSequenceService $sequences) {}

    public function handle(array $data): Product
    {
        return DB::transaction(function () use ($data) {
            $data['number'] = $this->sequences->next('product-number', 'PRD-');
            $data['sku'] = 'KADUA-'.$data['number'];
            $data['is_active'] = $data['is_active'] ?? true;

            $product = new Product($data);
            $product->number = $data['number'];
            $product->sku = $data['sku'];
            $product->save();

            return $product;
        });
    }
}
