<?php

namespace App\Actions\Settings;

use App\Models\User;

class DeleteUserAction
{
    public function handle(User $user): void
    {
        $user->delete();
    }
}
