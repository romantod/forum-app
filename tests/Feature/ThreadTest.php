<?php

use App\Models\Category;
use App\Models\User;

it('redirects guests away from creating a thread', function () {
    $category = Category::factory()->create();

    $response = $this->post("/forum/{$category->slug}", [
        'title' => 'Тестовая тема',
        'body' => 'Тело тестовой темы достаточно длинное',
    ]);

    $response->assertRedirect('/login');
});


it('allows authenticated user to create a thread', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $response = $this->actingAs($user)->post("/forum/{$category->slug}", [
        'title' => 'Моя новая тема',
        'body' => 'Это тело темы, достаточно длинное',
    ]);

    $this->assertDatabaseHas('threads', [
        'title' => 'Моя новая тема',
        'user_id' => $user->id,
    ]);
});


it('allows authenticated user to post a reply', function () {
    $user = User::factory()->create();
    $thread = \App\Models\Thread::factory()->create();

    $response = $this->actingAs($user)->post(
        "/forum/{$thread->category->slug}/{$thread->slug}/replies",
        ['body' => 'Мой ответ в теме']
    );

    $this->assertDatabaseHas('replies', [
        'body' => 'Мой ответ в теме',
        'user_id' => $user->id,
        'thread_id' => $thread->id,
    ]);
});

it('forbids deleting a thread by a non-owner', function () {
    $owner = User::factory()->create();
    $stranger = User::factory()->create();
    $thread = \App\Models\Thread::factory()->create(['user_id' => $owner->id]);

    $response = $this->actingAs($stranger)->delete(
        "/forum/{$thread->category->slug}/{$thread->slug}"
    );

    $response->assertForbidden();
    $this->assertDatabaseHas('threads', ['id' => $thread->id]);
});

it('allows owner to delete their thread', function () {
    $owner = User::factory()->create();
    $thread = \App\Models\Thread::factory()->create(['user_id' => $owner->id]);

    $response = $this->actingAs($owner)->delete(
        "/forum/{$thread->category->slug}/{$thread->slug}"
    );

    $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
});

