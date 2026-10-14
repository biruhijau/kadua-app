<?php

namespace App\Actions\Profile;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LoadProfileSessionsAction
{
    /**
     * @return array{visible: Collection, remaining: int, has_other_sessions: bool}
     */
    public function handle(Request $request): array
    {
        $currentSessionId = $request->session()->getId();
        $sessions = DB::table('sessions')
            ->where('user_id', $request->user()->getAuthIdentifier())
            ->latest('last_activity')
            ->get()
            ->map(fn (object $session): array => $this->session($session, $currentSessionId))
            ->sortByDesc('is_current')
            ->values();

        return [
            'visible' => $sessions->take(3),
            'remaining' => max(0, $sessions->count() - 3),
            'has_other_sessions' => $sessions->count() > 1,
        ];
    }

    /**
     * @return array{id: string, ip_address: ?string, user_agent: ?string, device: string, last_active_at: Carbon, is_expired: bool, is_current: bool}
     */
    private function session(object $session, string $currentSessionId): array
    {
        return [
            'id' => $session->id,
            'ip_address' => $session->ip_address,
            'user_agent' => $session->user_agent,
            'device' => $this->device($session->user_agent),
            'last_active_at' => now()->setTimestamp($session->last_activity),
            'is_expired' => $session->last_activity < now()->subMinutes(config('session.lifetime'))->timestamp,
            'is_current' => $session->id === $currentSessionId,
        ];
    }

    private function device(?string $userAgent): string
    {
        $userAgent ??= '';

        return match (true) {
            Str::contains($userAgent, ['iPhone', 'iPad']) => 'Apple device',
            Str::contains($userAgent, ['Android']) => 'Android device',
            Str::contains($userAgent, ['Windows']) => 'Windows device',
            Str::contains($userAgent, ['Macintosh']) => 'Mac device',
            Str::contains($userAgent, ['Linux']) => 'Linux device',
            default => 'Unknown device',
        };
    }
}
