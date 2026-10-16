<?php

use App\Models\User;

test('login screen can be rendered', function () {
    $response = $this->get('/auth/sign-in');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $response = $this->post('/auth/sign-in', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/auth/sign-in', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/auth/sign-out');

    $this->assertGuest();
    $response->assertRedirect(route('login'));
});

test('unverified user can logout without hitting the verification prompt', function () {
    $user = User::factory()->unverified()->create();

    $this->actingAs($user)->post('/auth/sign-out')->assertRedirect(route('login'));

    $this->get('/auth/verify-email')->assertRedirect(route('login'));
});
