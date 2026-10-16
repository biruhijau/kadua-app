<?php

namespace App\Actions\Settings;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class CreateUserAction
{
    /**
     * Create the account, sync its roles, and hand verification over to the user.
     */
    public function handle(array $attributes, array $roles): User
    {
        $user = User::create($attributes);
        $user->syncRoles($roles);

        if ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
        }

        return $user;
    }
}
