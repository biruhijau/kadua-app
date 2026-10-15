<?php

namespace App\Actions\Settings;

use App\Models\Role;

class DeleteRoleAction
{
    public function handle(Role $role): void
    {
        $role->delete();
    }
}
