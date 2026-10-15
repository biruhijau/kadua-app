<?php

use App\Enums\Permission as PermissionEnum;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\KaduaSeeder;

test('user with permission can view roles', function () {
    $user = User::factory()->create();
    $role = Role::findOrCreate('staff', 'web');
    $role->givePermissionTo(Permission::findOrCreate('roles.view', 'web'));
    $user->assignRole($role);

    $this->actingAs($user)
        ->get(route('settings.role.index'))
        ->assertOk()
        ->assertSee('Peran');
});

test('role form uses the code defined permission labels', function () {
    $this->seed(KaduaSeeder::class);

    $user = User::factory()->create();
    $role = Role::findOrCreate('staff', 'web');
    $role->givePermissionTo(Permission::findOrCreate('roles.create', 'web'));
    $user->assignRole($role);

    $this->actingAs($user)
        ->get(route('settings.role.create'))
        ->assertOk()
        ->assertSee(PermissionEnum::UsersView->feature())
        ->assertSee('Lihat')
        ->assertDontSee('users.view');
});

test('user without permission cannot view roles', function () {
    $user = User::factory()->create()->assignRole(Role::findOrCreate('cashier', 'web'));

    $this->actingAs($user)
        ->get(route('settings.role.index'))
        ->assertForbidden();
});

test('user with role permissions can create update and delete a role', function () {
    $user = User::factory()->create();
    $role = Role::findOrCreate('staff', 'web');
    $role->givePermissionTo([
        Permission::findOrCreate('roles.create', 'web'),
        Permission::findOrCreate('roles.update', 'web'),
        Permission::findOrCreate('roles.delete', 'web'),
    ]);
    $user->assignRole($role);

    $permission = Permission::findOrCreate('reports.view', 'web');

    $this->actingAs($user)
        ->post(route('settings.role.store'), [
            'name' => 'reporter',
            'permissions' => [$permission->id],
        ])
        ->assertRedirect(route('settings.role.index'));

    $managedRole = Role::findByName('reporter', 'web');
    expect($managedRole->hasPermissionTo($permission))->toBeTrue();

    $updatedPermission = Permission::findOrCreate('reports.export', 'web');

    $this->actingAs($user)
        ->patch(route('settings.role.update', $managedRole), [
            'name' => 'report-manager',
            'permissions' => [$updatedPermission->id],
        ])
        ->assertRedirect(route('settings.role.index'));

    expect($managedRole->refresh()->hasPermissionTo($updatedPermission))->toBeTrue()
        ->and($managedRole->hasPermissionTo($permission))->toBeFalse();

    $this->actingAs($user)
        ->delete(route('settings.role.destroy', $managedRole))
        ->assertRedirect(route('settings.role.index'));

    expect(Role::where('name', 'report-manager')->exists())->toBeFalse();
});
