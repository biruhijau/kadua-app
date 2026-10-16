<?php

namespace App\Http\Requests\Master;

use App\Models\ProductCategory;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('product-categories.update') ?? false;
    }

    /** @return array<string, ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        /** @var ProductCategory|null $productCategory */
        $productCategory = $this->route('productCategory');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('product_categories', 'name')->ignore($productCategory?->getKey()),
            ],
            'description' => ['nullable', 'string'],
        ];
    }
}
