<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Profile\LoadProfileSessionsAction;
use App\Actions\Profile\RevokeOtherSessionsAction;
use App\Actions\Profile\RevokeProfileSessionAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileSessionController extends Controller
{
    /**
     * Display the user's profile and active sessions.
     */
    public function edit(Request $request, LoadProfileSessionsAction $loadProfileSessions): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'sessions' => $loadProfileSessions->handle($request),
        ]);
    }

    public function destroy(Request $request, string $session, RevokeProfileSessionAction $revokeProfileSession): RedirectResponse
    {
        if ($session === $request->session()->getId()) {
            return back();
        }

        $request->validateWithBag('sessionRevocation-'.$session, [
            'password' => ['required', 'current_password'],
        ]);

        $revokeProfileSession->handle($request->user()->getAuthIdentifier(), $session);

        return back()->with('status', 'session-revoked');
    }

    public function destroyOthers(Request $request, RevokeOtherSessionsAction $revokeOtherSessions): RedirectResponse
    {
        $request->validateWithBag('sessionRevocationAll', [
            'password' => ['required', 'current_password'],
        ]);

        $revokeOtherSessions->handle(
            $request->user()->getAuthIdentifier(),
            $request->session()->getId(),
        );

        return back()->with('status', 'sessions-revoked');
    }
}
