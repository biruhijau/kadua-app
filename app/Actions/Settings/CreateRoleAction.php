<?php

namespace App\Actions\Settings;

use App\Models\Role;

class CreateRoleAction
{
    public function handle(string $name, array $permissions): Role
    {
        $role = Role::create(['name' => $name, 'guard_name' => 'web']);
        $role->syncPermissions($permissions);

        return $role;
    }
}
