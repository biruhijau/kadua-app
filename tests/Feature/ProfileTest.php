<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;

test('profile page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/profile');

    $response->assertOk();
});

test('profile page displays the user sessions', function () {
    $user = User::factory()->create();

    DB::table('sessions')->insert([
        'id' => 'profile-session-1',
        'user_id' => $user->id,
        'ip_address' => '192.168.1.10',
        'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X)',
        'payload' => base64_encode('payload'),
        'last_activity' => now()->timestamp,
    ]);

    $response = $this
        ->actingAs($user)
        ->get('/profile');

    $response
        ->assertOk()
        ->assertSee('Apple device')
        ->assertSee('192.168.1.10');
});

test('profile page displays old sessions for revocation', function () {
    $user = User::factory()->create();

    DB::table('sessions')->insert([
        'id' => 'expired-profile-session',
        'user_id' => $user->id,
        'ip_address' => '192.168.1.20',
        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
        'payload' => base64_encode('payload'),
        'last_activity' => now()->subMinutes(config('session.lifetime') + 1)->timestamp,
    ]);

    $this->actingAs($user)
        ->get('/profile')
        ->assertOk()
        ->assertSee('Windows device')
        ->assertSee('192.168.1.20')
        ->assertSee('Kadaluarsa');
});

test('profile page displays at most three sessions and counts the remaining sessions', function () {
    $user = User::factory()->create();

    DB::table('sessions')->insert([
        [
            'id' => 'latest-profile-session',
            'user_id' => $user->id,
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
            'payload' => base64_encode('payload'),
            'last_activity' => now()->timestamp,
        ],
        [
            'id' => 'second-profile-session',
            'user_id' => $user->id,
            'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)',
            'payload' => base64_encode('payload'),
            'last_activity' => now()->subMinute()->timestamp,
        ],
        [
            'id' => 'third-profile-session',
            'user_id' => $user->id,
            'user_agent' => 'Mozilla/5.0 (X11; Linux x86_64)',
            'payload' => base64_encode('payload'),
            'last_activity' => now()->subMinutes(2)->timestamp,
        ],
        [
            'id' => 'hidden-profile-session',
            'user_id' => $user->id,
            'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X)',
            'payload' => base64_encode('payload'),
            'last_activity' => now()->subMinutes(3)->timestamp,
        ],
        [
            'id' => 'second-hidden-profile-session',
            'user_id' => $user->id,
            'user_agent' => 'Mozilla/5.0 (Linux; Android 14)',
            'payload' => base64_encode('payload'),
            'last_activity' => now()->subMinutes(4)->timestamp,
        ],
    ]);

    $this->actingAs($user)
        ->get('/profile')
        ->assertOk()
        ->assertSee('Windows device')
        ->assertSee('Mac device')
        ->assertDontSee('Apple device')
        ->assertSee('+2 Lainnya')
        ->assertSee('Keluarkan semua');
});

test('user can revoke another session but not another users session', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    DB::table('sessions')->insert([
        [
            'id' => 'user-session-1',
            'user_id' => $user->id,
            'payload' => base64_encode('payload'),
            'last_activity' => now()->timestamp,
        ],
        [
            'id' => 'other-user-session',
            'user_id' => $otherUser->id,
            'payload' => base64_encode('payload'),
            'last_activity' => now()->timestamp,
        ],
    ]);

    $this->actingAs($user)
        ->from('/profile')
        ->delete(route('profile.sessions.destroy', 'user-session-1'), [
            'password' => 'password',
        ])
        ->assertRedirect('/profile');

    expect(DB::table('sessions')->where('id', 'user-session-1')->exists())->toBeFalse();

    $this->actingAs($user)
        ->from('/profile')
        ->delete(route('profile.sessions.destroy', 'other-user-session'), [
            'password' => 'password',
        ])
        ->assertRedirect('/profile');

    expect(DB::table('sessions')->where('id', 'other-user-session')->exists())->toBeTrue();
});

test('password is required before revoking a session', function () {
    $user = User::factory()->create();

    DB::table('sessions')->insert([
        'id' => 'protected-profile-session',
        'user_id' => $user->id,
        'payload' => base64_encode('payload'),
        'last_activity' => now()->timestamp,
    ]);

    $this->actingAs($user)
        ->from('/profile')
        ->delete(route('profile.sessions.destroy', 'protected-profile-session'), [
            'password' => 'wrong-password',
        ])
        ->assertRedirect('/profile')
        ->assertSessionHasErrorsIn('sessionRevocation-protected-profile-session', 'password');

    expect(DB::table('sessions')->where('id', 'protected-profile-session')->exists())->toBeTrue();
});

test('user can revoke all other sessions with the correct password', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    DB::table('sessions')->insert([
        [
            'id' => 'all-sessions-current',
            'user_id' => $user->id,
            'payload' => base64_encode('payload'),
            'last_activity' => now()->timestamp,
        ],
        [
            'id' => 'all-sessions-other',
            'user_id' => $user->id,
            'payload' => base64_encode('payload'),
            'last_activity' => now()->timestamp,
        ],
        [
            'id' => 'all-sessions-foreign',
            'user_id' => $otherUser->id,
            'payload' => base64_encode('payload'),
            'last_activity' => now()->timestamp,
        ],
    ]);

    $this->actingAs($user)
        ->from('/profile')
        ->delete(route('profile.sessions.destroy-others'), [
            'password' => 'password',
        ])
        ->assertRedirect('/profile');

    expect(DB::table('sessions')->where('id', 'all-sessions-other')->exists())->toBeFalse();
    expect(DB::table('sessions')->where('id', 'all-sessions-foreign')->exists())->toBeTrue();
});

test('profile information can be updated', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $user->refresh();

    $this->assertSame('Test User', $user->name);
    $this->assertSame('test@example.com', $user->email);
    $this->assertNull($user->email_verified_at);
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'name' => 'Test User',
            'email' => $user->email,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $this->assertNotNull($user->refresh()->email_verified_at);
});

test('user can delete their account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->delete('/profile', [
            'password' => 'password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');

    $this->assertGuest();
    $this->assertNull($user->fresh());
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/profile')
        ->delete('/profile', [
            'password' => 'wrong-password',
        ]);

    $response
        ->assertSessionHasErrorsIn('userDeletion', 'password')
        ->assertRedirect('/profile');

    $this->assertNotNull($user->fresh());
});
