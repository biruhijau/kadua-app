<?php

namespace App\Actions\Settings;

use App\Models\User;

class BlockUserAction
{
    /**
     * Revoke system access by blocking the account.
     *
     * The verified state is intentionally left untouched: verifying the email
     * address remains the user's own responsibility.
     */
    public function handle(User $user): User
    {
        $user->forceFill(['blocked_at' => now()])->save();

        return $user->refresh();
    }
}
