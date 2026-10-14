<?php

namespace App\Actions\Profile;

use Illuminate\Support\Facades\DB;

class RevokeOtherSessionsAction
{
    public function handle(string $userId, string $currentSessionId): void
    {
        DB::table('sessions')
            ->where('user_id', $userId)
            ->where('id', '!=', $currentSessionId)
            ->delete();
    }
}
