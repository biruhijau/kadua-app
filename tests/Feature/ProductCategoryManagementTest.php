<?php

use App\Models\ProductCategory;

test('user with product category view permission can view categories', function () {
    $manager = makeManager(['product-categories.view']);
    $category = ProductCategory::factory()->create();

    $this->actingAs($manager)
        ->get(route('master.product-categories.index'))
        ->assertOk()
        ->assertSee($category->name);
});

test('user without product category view permission cannot view categories', function () {
    $manager = makeManager([]);

    $this->actingAs($manager)
        ->get(route('master.product-categories.index'))
        ->assertForbidden();
});

test('authorized user can create a product category', function () {
    $manager = makeManager(['product-categories.create']);

    $this->actingAs($manager)
        ->post(route('master.product-categories.store'), [
            'name' => 'Minuman',
            'description' => 'Kategori untuk produk minuman.',
        ])
        ->assertRedirect(route('master.product-categories.index'))
        ->assertSessionHas('status', 'product-category-created');

    expect(ProductCategory::where('name', 'Minuman')->exists())->toBeTrue();
});

test('product category name must be unique', function () {
    $manager = makeManager(['product-categories.create']);
    $category = ProductCategory::factory()->create(['name' => 'Minuman']);

    $this->actingAs($manager)
        ->post(route('master.product-categories.store'), ['name' => $category->name])
        ->assertSessionHasErrors('name');
});

test('authorized user can update a product category', function () {
    $manager = makeManager(['product-categories.update']);
    $category = ProductCategory::factory()->create();

    $this->actingAs($manager)
        ->patch(route('master.product-categories.update', $category), [
            'name' => 'Makanan Baru',
            'description' => 'Deskripsi baru.',
        ])
        ->assertRedirect(route('master.product-categories.index'))
        ->assertSessionHas('status', 'product-category-updated');

    expect($category->refresh()->name)->toBe('Makanan Baru');
});

test('authorized user can delete a product category', function () {
    $manager = makeManager(['product-categories.delete']);
    $category = ProductCategory::factory()->create();

    $this->actingAs($manager)
        ->delete(route('master.product-categories.destroy', $category))
        ->assertRedirect(route('master.product-categories.index'))
        ->assertSessionHas('status', 'product-category-deleted');

    expect(ProductCategory::whereKey($category->id)->exists())->toBeFalse();
});

test('authorized user can bulk delete product categories', function () {
    $manager = makeManager(['product-categories.delete']);
    $targets = ProductCategory::factory()->count(2)->create();
    $spared = ProductCategory::factory()->create();

    $this->actingAs($manager)
        ->delete(route('master.product-categories.bulk-destroy'), ['ids' => $targets->pluck('id')->all()])
        ->assertRedirect(route('master.product-categories.index'))
        ->assertSessionHas('status', 'product-categories-deleted-bulk');

    expect(ProductCategory::whereIn('id', $targets->pluck('id'))->exists())->toBeFalse()
        ->and(ProductCategory::whereKey($spared->id)->exists())->toBeTrue();
});

test('bulk product category delete requires selected ids', function () {
    $manager = makeManager(['product-categories.delete']);

    $this->actingAs($manager)
        ->delete(route('master.product-categories.bulk-destroy'), [])
        ->assertSessionHasErrors('ids');
});

test('user without product category delete permission cannot bulk delete', function () {
    $manager = makeManager(['product-categories.view']);
    $category = ProductCategory::factory()->create();

    $this->actingAs($manager)
        ->delete(route('master.product-categories.bulk-destroy'), ['ids' => [$category->id]])
        ->assertForbidden();

    expect(ProductCategory::whereKey($category->id)->exists())->toBeTrue();
});
