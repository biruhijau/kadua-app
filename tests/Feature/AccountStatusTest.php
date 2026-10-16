<?php

use App\Models\Role;
use App\Models\User;

test('blocking an account leaves its verified state untouched', function () {
    $manager = makeManager(['users.view', 'users.update']);
    $target = User::factory()->create();

    $verifiedAt = $target->email_verified_at;

    expect($verifiedAt)->not->toBeNull();

    $this->actingAs($manager)
        ->post(route('settings.users.block', $target))
        ->assertRedirect(route('settings.users.index'))
        ->assertSessionHas('status', 'user-blocked');

    expect($target->refresh()->isBlocked())->toBeTrue()
        ->and($target->email_verified_at->toDateTimeString())->toBe($verifiedAt->toDateTimeString());
});

test('unblocking an account clears the block only', function () {
    $manager = makeManager(['users.view', 'users.update']);
    $target = User::factory()->blocked()->create();

    $verifiedAt = $target->email_verified_at;

    expect($target->isBlocked())->toBeTrue();

    $this->actingAs($manager)
        ->post(route('settings.users.unblock', $target))
        ->assertRedirect(route('settings.users.index'))
        ->assertSessionHas('status', 'user-unblocked');

    expect($target->refresh()->isBlocked())->toBeFalse()
        ->and($target->email_verified_at->toDateTimeString())->toBe($verifiedAt->toDateTimeString());
});

test('user cannot block their own account', function () {
    $manager = makeManager(['users.view', 'users.update']);

    $this->actingAs($manager)
        ->post(route('settings.users.block', $manager))
        ->assertRedirect(route('settings.users.index'));

    expect($manager->refresh()->isBlocked())->toBeFalse();
});

test('blocked user cannot log in', function () {
    $user = User::factory()->blocked()->create(['password' => bcrypt('password123')]);

    $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'password123',
    ])->assertRedirect(route('login'));

    $this->assertGuest();
});

test('blocked user loses access to the application', function () {
    $user = User::factory()->blocked()->create();
    $user->assignRole(Role::findOrCreate('staff', 'web'));

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertRedirect(route('login'));

    expect($user->refresh()->isBlocked())->toBeTrue();
});

test('user without update permission cannot block or unblock', function () {
    $manager = makeManager(['users.view', 'users.delete']);
    $target = User::factory()->create();

    $this->actingAs($manager)->post(route('settings.users.block', $target))->assertForbidden();
    $this->actingAs($manager)->post(route('settings.users.unblock', $target))->assertForbidden();

    expect($target->refresh()->isBlocked())->toBeFalse();
});
