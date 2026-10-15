<?php

namespace App\Actions\Settings;

use App\Models\Role;

class UpdateRoleAction
{
    public function handle(Role $role, string $name, array $permissions): Role
    {
        $role->update(['name' => $name]);
        $role->syncPermissions($permissions);

        return $role->refresh();
    }
}
