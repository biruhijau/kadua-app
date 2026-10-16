<?php

use App\Models\Category;

test('user with category view permission can view categories', function () {
    $manager = makeManager(['categories.view']);
    $category = Category::factory()->create();

    $this->actingAs($manager)
        ->get(route('master.categories.index'))
        ->assertOk()
        ->assertSee($category->name);
});

test('user without category view permission cannot view categories', function () {
    $manager = makeManager([]);

    $this->actingAs($manager)
        ->get(route('master.categories.index'))
        ->assertForbidden();
});

test('authorized user can create a category', function () {
    $manager = makeManager(['categories.create']);

    $this->actingAs($manager)
        ->post(route('master.categories.store'), [
            'name' => 'Minuman',
            'description' => 'Kategori untuk produk minuman.',
        ])
        ->assertRedirect(route('master.categories.index'))
        ->assertSessionHas('status', 'category-created');

    expect(Category::where('name', 'Minuman')->exists())->toBeTrue();
});

test('category name must be unique', function () {
    $manager = makeManager(['categories.create']);
    $category = Category::factory()->create(['name' => 'Minuman']);

    $this->actingAs($manager)
        ->post(route('master.categories.store'), ['name' => $category->name])
        ->assertSessionHasErrors('name');
});

test('authorized user can update a category', function () {
    $manager = makeManager(['categories.update']);
    $category = Category::factory()->create();

    $this->actingAs($manager)
        ->patch(route('master.categories.update', $category), [
            'name' => 'Makanan Baru',
            'description' => 'Deskripsi baru.',
        ])
        ->assertRedirect(route('master.categories.index'))
        ->assertSessionHas('status', 'category-updated');

    expect($category->refresh()->name)->toBe('Makanan Baru');
});

test('authorized user can delete a category', function () {
    $manager = makeManager(['categories.delete']);
    $category = Category::factory()->create();

    $this->actingAs($manager)
        ->delete(route('master.categories.destroy', $category))
        ->assertRedirect(route('master.categories.index'))
        ->assertSessionHas('status', 'category-deleted');

    expect(Category::whereKey($category->id)->exists())->toBeFalse();
});

test('authorized user can bulk delete categories', function () {
    $manager = makeManager(['categories.delete']);
    $targets = Category::factory()->count(2)->create();
    $spared = Category::factory()->create();

    $this->actingAs($manager)
        ->delete(route('master.categories.bulk-destroy'), ['ids' => $targets->pluck('id')->all()])
        ->assertRedirect(route('master.categories.index'))
        ->assertSessionHas('status', 'categories-deleted-bulk');

    expect(Category::whereIn('id', $targets->pluck('id'))->exists())->toBeFalse()
        ->and(Category::whereKey($spared->id)->exists())->toBeTrue();
});

test('bulk category delete requires selected ids', function () {
    $manager = makeManager(['categories.delete']);

    $this->actingAs($manager)
        ->delete(route('master.categories.bulk-destroy'), [])
        ->assertSessionHasErrors('ids');
});

test('user without category delete permission cannot bulk delete', function () {
    $manager = makeManager(['categories.view']);
    $category = Category::factory()->create();

    $this->actingAs($manager)
        ->delete(route('master.categories.bulk-destroy'), ['ids' => [$category->id]])
        ->assertForbidden();

    expect(Category::whereKey($category->id)->exists())->toBeTrue();
});

test('category is flat and active by default', function () {
    $manager = makeManager(['categories.create']);

    $this->actingAs($manager)
        ->post(route('master.categories.store'), [
            'name' => 'Kopi',
            'is_active' => '1',
        ])
        ->assertRedirect(route('master.categories.index'));

    $category = Category::where('name', 'Kopi')->firstOrFail();

    expect($category->is_active)->toBeTrue()
        ->and(array_key_exists('parent_id', $category->getAttributes()))->toBeFalse();
});

test('category rejects whitespace-only names', function () {
    $manager = makeManager(['categories.create']);

    $this->actingAs($manager)
        ->post(route('master.categories.store'), ['name' => '   '])
        ->assertSessionHasErrors('name');
});

test('authorized user can toggle category status', function () {
    $manager = makeManager(['categories.update']);
    $category = Category::factory()->create(['is_active' => true]);

    $this->actingAs($manager)
        ->patch(route('master.categories.toggle-status', $category))
        ->assertRedirect(route('master.categories.index'))
        ->assertSessionHas('status', 'category-status-updated');

    expect($category->refresh()->is_active)->toBeFalse();
});
