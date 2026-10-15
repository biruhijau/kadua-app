<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

test('administrator requires assigned permissions', function () {
    $user = User::factory()->create()->assignRole(Role::findOrCreate('administrator', 'web'));

    expect($user->can('settings.any-action'))->toBeFalse();
});

test('developer requires assigned permissions', function () {
    $user = User::factory()->create()->assignRole(Role::findOrCreate('developer', 'web'));

    expect($user->can('settings.any-action'))->toBeFalse();
});

test('regular role requires an assigned permission', function () {
    $user = User::factory()->create();
    $role = Role::findOrCreate('staff', 'web');
    $permission = Permission::findOrCreate('settings.view', 'web');

    $user->assignRole($role);

    expect($user->can('settings.view'))->toBeFalse();

    $role->givePermissionTo($permission);

    expect($user->fresh()->can('settings.view'))->toBeTrue();
});
