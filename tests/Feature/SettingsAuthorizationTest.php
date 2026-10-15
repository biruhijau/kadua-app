<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

test('role without dashboard permission cannot access dashboard', function () {
    $user = User::factory()->create()->assignRole(Role::findOrCreate('cashier', 'web'));

    $this->actingAs($user)->get(route('dashboard'))->assertForbidden();
});

test('administrator without dashboard permission cannot access dashboard', function () {
    $user = User::factory()->create()->assignRole(Role::findOrCreate('administrator', 'web'));

    $this->actingAs($user)->get(route('dashboard'))->assertForbidden();
});

test('role can access settings role only with roles view permission', function () {
    $user = User::factory()->create();
    $role = Role::findOrCreate('staff', 'web');
    $role->givePermissionTo(Permission::findOrCreate('roles.view', 'web'));
    $user->assignRole($role);

    $this->actingAs($user)->get(route('settings.role.index'))->assertOk();
});
