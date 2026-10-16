<?php

namespace App\Http\Controllers\Master;

use App\Actions\Master\CreateCategoryAction;
use App\Actions\Master\DeleteCategoryAction;
use App\Actions\Master\UpdateCategoryAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\BulkCategoryRequest;
use App\Http\Requests\Master\StoreCategoryRequest;
use App\Http\Requests\Master\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();
        $status = $request->string('status')->trim()->toString();

        return view('pages.master.category.index', [
            'categories' => Category::query()
                ->select(['id', 'name', 'description', 'is_active', 'created_at'])
                ->when($search !== '', fn ($query) => $query->where(fn ($query) => $query->where('name', 'like', "%{$search}%")->orWhere('description', 'like', "%{$search}%")))
                ->when($status === 'active', fn ($query) => $query->where('is_active', true))
                ->when($status === 'inactive', fn ($query) => $query->where('is_active', false))
                ->latest()
                ->paginate(15)
                ->withQueryString(),
            'search' => $search,
            'status' => $status,
        ]);
    }

    public function create(): View
    {
        return view('pages.master.category.create');
    }

    public function store(StoreCategoryRequest $request, CreateCategoryAction $create): RedirectResponse
    {
        $create->handle($request->validated());

        return to_route('master.categories.index')->with('status', 'category-created');
    }

    public function edit(Category $category): View
    {
        return view('pages.master.category.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category, UpdateCategoryAction $update): RedirectResponse
    {
        $update->handle($category, $request->validated());

        return to_route('master.categories.index')->with('status', 'category-updated');
    }

    public function destroy(Category $category, DeleteCategoryAction $delete): RedirectResponse
    {
        $delete->handle($category);

        return to_route('master.categories.index')->with('status', 'category-deleted');
    }

    public function toggleStatus(Category $category, UpdateCategoryAction $update): RedirectResponse
    {
        $update->handle($category, ['is_active' => ! $category->is_active]);

        return to_route('master.categories.index')->with('status', 'category-status-updated');
    }

    public function bulkDestroy(BulkCategoryRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request): void {
            $categories = Category::query()->whereIn('id', $request->validated('ids'))->get();
            $delete = app(DeleteCategoryAction::class);

            foreach ($categories as $category) {
                $delete->handle($category);
            }
        });

        return to_route('master.categories.index')->with('status', 'categories-deleted-bulk');
    }
}
