<?php

namespace App\Http\Requests\Master;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('product-categories.create') ?? false;
    }

    /** @return array<string, ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:product_categories,name'],
            'description' => ['nullable', 'string'],
        ];
    }
}
