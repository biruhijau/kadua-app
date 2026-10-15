<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('user with permission can view users', function () {
    $user = User::factory()->create();
    $role = Role::findOrCreate('staff', 'web');
    $role->givePermissionTo(Permission::findOrCreate('users.view', 'web'));
    $user->assignRole($role);

    $this->actingAs($user)->get(route('settings.users.index'))->assertOk()->assertSee('Pengguna');
});

test('user without permission cannot view users', function () {
    $user = User::factory()->create()->assignRole(Role::findOrCreate('cashier', 'web'));

    $this->actingAs($user)->get(route('settings.users.index'))->assertForbidden();
});

test('authorized user can create update and delete a user with synced roles', function () {
    $manager = User::factory()->create();
    $managerRole = Role::findOrCreate('staff', 'web');
    $managerRole->givePermissionTo([
        Permission::findOrCreate('users.create', 'web'),
        Permission::findOrCreate('users.update', 'web'),
        Permission::findOrCreate('users.delete', 'web'),
    ]);
    $manager->assignRole($managerRole);

    $staffRole = Role::findOrCreate('staff-member', 'web');
    $cashierRole = Role::findOrCreate('cashier-member', 'web');

    $this->actingAs($manager)
        ->post(route('settings.users.store'), [
            'name' => 'Managed User',
            'email' => 'managed@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'roles' => [$staffRole->id],
        ])
        ->assertRedirect(route('settings.users.index'));

    $managedUser = User::where('email', 'managed@example.com')->firstOrFail();
    expect($managedUser->hasRole($staffRole))->toBeTrue()
        ->and(Hash::check('password123', $managedUser->password))->toBeTrue();

    $this->actingAs($manager)
        ->patch(route('settings.users.update', $managedUser), [
            'name' => 'Updated User',
            'email' => 'managed@example.com',
            'password' => '',
            'password_confirmation' => '',
            'roles' => [$cashierRole->id],
        ])
        ->assertRedirect(route('settings.users.index'));

    expect($managedUser->refresh()->hasRole($cashierRole))->toBeTrue()
        ->and($managedUser->hasRole($staffRole))->toBeFalse();

    $this->actingAs($manager)
        ->delete(route('settings.users.destroy', $managedUser))
        ->assertRedirect(route('settings.users.index'));

    expect(User::whereKey($managedUser->id)->exists())->toBeFalse();
});
