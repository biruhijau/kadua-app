<?php

namespace App\Http\Controllers\Master;

use App\Actions\Master\CreateProductAction;
use App\Actions\Master\DeleteProductAction;
use App\Actions\Master\UpdateProductAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\BulkProductRequest;
use App\Http\Requests\Master\StoreProductRequest;
use App\Http\Requests\Master\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $r): View
    {
        $search = $r->string('search')->trim()->toString();
        $status = $r->string('status')->toString();

        return view('pages.master.product.index', ['products' => Product::with('category')->when($search, fn ($q) => $q->where(fn ($q) => $q->where('name', 'like', "%$search%")->orWhere('sku', 'like', "%$search%")))->when($status === 'active', fn ($q) => $q->where('is_active', 1))->when($status === 'inactive', fn ($q) => $q->where('is_active', 0))->latest()->paginate(15)->withQueryString(), 'search' => $search, 'status' => $status]);
    }

    public function create(): View
    {
        return view('pages.master.product.create', ['categories' => Category::where('is_active', 1)->orderBy('name')->pluck('name', 'id')]);
    }

    public function store(StoreProductRequest $r, CreateProductAction $a): RedirectResponse
    {
        $p = $a->handle($r->validated());
        foreach ($r->file('images', []) as $image) {
            $p->addMedia($image)->toMediaCollection('product-images');
        }

        return to_route('master.products.index')->with('status', 'product-created');
    }

    public function edit(Product $product): View
    {
        return view('pages.master.product.edit', ['product' => $product, 'categories' => Category::where('is_active', 1)->orWhere('id', $product->category_id)->orderBy('name')->pluck('name', 'id')]);
    }

    public function update(UpdateProductRequest $r, Product $product, UpdateProductAction $a): RedirectResponse
    {
        $a->handle($product, $r->validated());
        foreach ($r->file('images', []) as $image) {
            $product->addMedia($image)->toMediaCollection('product-images');
        }

        return to_route('master.products.index')->with('status', 'product-updated');
    }

    public function destroy(Product $product, DeleteProductAction $a): RedirectResponse
    {
        $a->handle($product);

        return to_route('master.products.index')->with('status', 'product-deleted');
    }

    public function bulkDestroy(BulkProductRequest $request): RedirectResponse
    {
        Product::query()
            ->whereIn('id', $request->validated('ids'))
            ->get()
            ->each(fn (Product $product) => app(DeleteProductAction::class)->handle($product));

        return to_route('master.products.index')->with('status', 'products-deleted-bulk');
    }

    public function toggleStatus(Product $product, UpdateProductAction $a): RedirectResponse
    {
        $a->handle($product, ['is_active' => ! $product->is_active]);

        return back()->with('status', 'product-status-updated');
    }
}
