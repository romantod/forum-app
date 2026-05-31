<?php

use App\Models\User;

it('returns true for admin role', function () {
    $user = new User(['role' => 'admin']);

    expect($user->isAdmin())->toBeTrue();
});

it('returns false for regular user role', function () {
    $user = new User(['role' => 'user']);

    expect($user->isAdmin())->toBeFalse();
});

it('treats admin as moderator too', function () {
    $user = new User(['role' => 'admin']);

    expect($user->isModerator())->toBeTrue();
});