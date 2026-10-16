<?php

namespace App\Http\Requests\Master;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BulkProductCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('product-categories.delete') ?? false;
    }

    /** @return array<string, ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['uuid', 'exists:product_categories,id'],
        ];
    }
}
