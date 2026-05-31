<?php

use App\Models\User;

it('returns a token on valid login', function () {
    $user = User::factory()->create();

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertOk()->assertJsonStructure(['token']);
});

it('rejects login with wrong password', function () {
    $user = User::factory()->create();

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $response->assertStatus(401);
});

it('blocks access to threads without a token', function () {
    $response = $this->getJson('/api/threads');

    $response->assertStatus(401);
});
