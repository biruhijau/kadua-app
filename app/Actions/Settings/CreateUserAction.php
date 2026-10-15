<?php

namespace App\Actions\Settings;

use App\Models\User;

class CreateUserAction
{
    public function handle(array $attributes, array $roles): User
    {
        $user = User::create($attributes);
        $user->syncRoles($roles);

        return $user;
    }
}
