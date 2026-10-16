<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsNotBlocked
{
    /**
     * Remove access from accounts that an administrator has blocked.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user instanceof User && $user->isBlocked()) {
            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return $request->expectsJson()
                ? abort(403, __('Akun Anda telah diblokir.'))
                : redirect()
                    ->route('login')
                    ->with('status', __('Akun Anda telah diblokir. Anda kehilangan akses ke dalam sistem.'))
                    ->with('status_type', 'error');
        }

        return $next($request);
    }
}
