<?php

namespace App\Actions\Profile;

use Illuminate\Support\Facades\DB;

class RevokeProfileSessionAction
{
    public function handle(string $userId, string $sessionId): void
    {
        DB::table('sessions')
            ->where('id', $sessionId)
            ->where('user_id', $userId)
            ->delete();
    }
}
