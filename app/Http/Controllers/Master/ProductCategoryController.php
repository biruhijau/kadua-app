<?php

namespace App\Http\Controllers\Master;

use App\Actions\Master\CreateProductCategoryAction;
use App\Actions\Master\DeleteProductCategoryAction;
use App\Actions\Master\UpdateProductCategoryAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\BulkProductCategoryRequest;
use App\Http\Requests\Master\StoreProductCategoryRequest;
use App\Http\Requests\Master\UpdateProductCategoryRequest;
use App\Models\ProductCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductCategoryController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();

        return view('pages.master.product-category.index', [
            'productCategories' => ProductCategory::query()
                ->select(['id', 'name', 'description', 'created_at'])
                ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                }))
                ->latest()
                ->paginate(15)
                ->withQueryString(),
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('pages.master.product-category.create');
    }

    public function store(StoreProductCategoryRequest $request, CreateProductCategoryAction $create): RedirectResponse
    {
        $create->handle($request->validated());

        return to_route('master.product-categories.index')->with('status', 'product-category-created');
    }

    public function edit(ProductCategory $productCategory): View
    {
        return view('pages.master.product-category.edit', compact('productCategory'));
    }

    public function update(UpdateProductCategoryRequest $request, ProductCategory $productCategory, UpdateProductCategoryAction $update): RedirectResponse
    {
        $update->handle($productCategory, $request->validated());

        return to_route('master.product-categories.index')->with('status', 'product-category-updated');
    }

    public function destroy(ProductCategory $productCategory, DeleteProductCategoryAction $delete): RedirectResponse
    {
        $delete->handle($productCategory);

        return to_route('master.product-categories.index')->with('status', 'product-category-deleted');
    }

    public function bulkDestroy(BulkProductCategoryRequest $request): RedirectResponse
    {
        ProductCategory::query()
            ->whereIn('id', $request->validated('ids'))
            ->delete();

        return to_route('master.product-categories.index')->with('status', 'product-categories-deleted-bulk');
    }
}
