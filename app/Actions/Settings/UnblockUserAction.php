<?php

namespace App\Actions\Settings;

use App\Models\User;

class UnblockUserAction
{
    /**
     * Restore system access by clearing the block.
     *
     * The verified state is intentionally left untouched.
     */
    public function handle(User $user): User
    {
        $user->forceFill(['blocked_at' => null])->save();

        return $user->refresh();
    }
}
