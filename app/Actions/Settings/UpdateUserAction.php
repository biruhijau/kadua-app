<?php

namespace App\Actions\Settings;

use App\Models\User;

class UpdateUserAction
{
    public function handle(User $user, array $attributes, array $roles): User
    {
        $user->update($attributes);
        $user->syncRoles($roles);

        return $user->refresh();
    }
}
