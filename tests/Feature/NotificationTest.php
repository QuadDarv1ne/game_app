<?php

use App\Models\Notification;
use App\Models\Post;
use App\Models\User;

test('opening a notification marks it as read and redirects', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $notification = Notification::create([
        'user_id' => $user->id,
        'type' => 'comment',
        'title' => 'Новый комментарий!',
        'message' => 'Тест',
        'link' => route('posts.show', $post),
        'is_read' => false,
    ]);

    $this->actingAs($user);

    $response = $this->get(route('notifications.open', $notification));

    $response->assertRedirect(route('posts.show', $post));
    $this->assertDatabaseHas('notifications', [
        'id' => $notification->id,
        'is_read' => true,
    ]);
});

test('users cannot open notifications of other users', function () {
    $owner = User::factory()->create();
    $stranger = User::factory()->create();

    $notification = Notification::create([
        'user_id' => $owner->id,
        'type' => 'comment',
        'title' => 'Новый комментарий!',
        'message' => 'Тест',
        'is_read' => false,
    ]);

    $this->actingAs($stranger);

    $this->get(route('notifications.open', $notification))->assertForbidden();
    $this->assertDatabaseHas('notifications', [
        'id' => $notification->id,
        'is_read' => false,
    ]);
});

test('notification without link redirects to posts index', function () {
    $user = User::factory()->create();

    $notification = Notification::create([
        'user_id' => $user->id,
        'type' => 'comment',
        'title' => 'Новый комментарий!',
        'message' => 'Тест',
        'is_read' => false,
    ]);

    $this->actingAs($user);

    $this->get(route('notifications.open', $notification))
        ->assertRedirect(route('posts.index'));
});
