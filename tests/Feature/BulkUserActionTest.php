<?php

use App\Models\User;
use Illuminate\Support\Str;

test('authorized user can bulk delete selected users', function () {
    $manager = makeManager(['users.view', 'users.delete']);
    $targets = User::factory()->count(3)->create();
    $spared = User::factory()->create();

    $this->actingAs($manager)
        ->delete(route('settings.users.bulk-destroy'), ['ids' => $targets->pluck('id')->all()])
        ->assertRedirect(route('settings.users.index'))
        ->assertSessionHas('status', 'users-deleted-bulk');

    expect(User::whereIn('id', $targets->pluck('id'))->exists())->toBeFalse()
        ->and(User::whereKey($spared->id)->exists())->toBeTrue();
});

test('bulk delete never removes the authenticated user', function () {
    $manager = makeManager(['users.view', 'users.delete']);
    $target = User::factory()->create();

    $this->actingAs($manager)
        ->delete(route('settings.users.bulk-destroy'), ['ids' => [$manager->id, $target->id]])
        ->assertRedirect(route('settings.users.index'));

    expect(User::whereKey($manager->id)->exists())->toBeTrue()
        ->and(User::whereKey($target->id)->exists())->toBeFalse();
});

test('authorized user can bulk block and bulk unblock', function () {
    $manager = makeManager(['users.view', 'users.update']);
    $targets = User::factory()->count(2)->create();

    $verifiedAt = $targets->first()->email_verified_at;

    $this->actingAs($manager)
        ->post(route('settings.users.bulk-block'), ['ids' => $targets->pluck('id')->all()])
        ->assertRedirect(route('settings.users.index'))
        ->assertSessionHas('status', 'users-blocked-bulk');

    expect($targets->fresh()->every->isBlocked())->toBeTrue()
        ->and($targets->fresh()->every(fn (User $user) => $user->email_verified_at !== null))->toBeTrue();

    $this->actingAs($manager)
        ->post(route('settings.users.bulk-unblock'), ['ids' => $targets->pluck('id')->all()])
        ->assertRedirect(route('settings.users.index'))
        ->assertSessionHas('status', 'users-unblocked-bulk');

    expect($targets->fresh()->every(fn (User $user) => ! $user->isBlocked()))->toBeTrue()
        ->and($targets->first()->email_verified_at->toDateTimeString())->toBe($verifiedAt->toDateTimeString());
});

test('bulk block is idempotent for a mixed selection', function () {
    $manager = makeManager(['users.view', 'users.update']);
    $alreadyBlocked = User::factory()->blocked()->create();
    $toBlock = User::factory()->create();

    $blockedAt = $alreadyBlocked->blocked_at;
    $updatedAt = $alreadyBlocked->updated_at;

    $this->actingAs($manager)
        ->post(route('settings.users.bulk-block'), ['ids' => [$alreadyBlocked->id, $toBlock->id]])
        ->assertRedirect(route('settings.users.index'))
        ->assertSessionHas('status', 'users-blocked-bulk');

    expect($toBlock->refresh()->isBlocked())->toBeTrue()
        ->and($alreadyBlocked->refresh()->isBlocked())->toBeTrue()
        ->and($alreadyBlocked->blocked_at->toDateTimeString())->toBe($blockedAt->toDateTimeString())
        ->and($alreadyBlocked->updated_at->toDateTimeString())->toBe($updatedAt->toDateTimeString());
});

test('bulk unblock is idempotent for a mixed selection', function () {
    $manager = makeManager(['users.view', 'users.update']);
    $alreadyBlocked = User::factory()->blocked()->create();
    $toUnblock = User::factory()->create();

    $this->actingAs($manager)
        ->post(route('settings.users.bulk-unblock'), ['ids' => [$alreadyBlocked->id, $toUnblock->id]])
        ->assertRedirect(route('settings.users.index'))
        ->assertSessionHas('status', 'users-unblocked-bulk');

    expect($alreadyBlocked->refresh()->isBlocked())->toBeFalse()
        ->and($toUnblock->refresh()->isBlocked())->toBeFalse();
});

test('bulk action requires selected ids', function () {
    $manager = makeManager(['users.view', 'users.delete']);

    $this->actingAs($manager)
        ->delete(route('settings.users.bulk-destroy'), [])
        ->assertSessionHasErrors('ids');
});

test('bulk action rejects unknown user ids', function () {
    $manager = makeManager(['users.view', 'users.delete']);
    $unknown = (string) Str::uuid();

    $this->actingAs($manager)
        ->delete(route('settings.users.bulk-destroy'), ['ids' => [$unknown]])
        ->assertSessionHasErrors('ids.*');
});

test('user without permission cannot run bulk actions', function () {
    $manager = makeManager(['users.view', 'users.update']);
    $target = User::factory()->create();

    $this->actingAs($manager)
        ->delete(route('settings.users.bulk-destroy'), ['ids' => [$target->id]])
        ->assertForbidden();

    expect(User::whereKey($target->id)->exists())->toBeTrue();
});
