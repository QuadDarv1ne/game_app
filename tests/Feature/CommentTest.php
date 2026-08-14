<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

test('authenticated users can create a comment', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $this->actingAs($user);

    $response = $this->post(route('comments.store'), [
        'post_id' => $post->id,
        'content' => 'This is a test comment',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('comments', [
        'post_id' => $post->id,
        'user_id' => $user->id,
        'content' => 'This is a test comment',
    ]);
});

test('unauthenticated users cannot create comments', function () {
    $post = Post::factory()->create();

    $response = $this->post(route('comments.store'), [
        'post_id' => $post->id,
        'content' => 'This is a test comment',
    ]);

    $response->assertRedirect(route('login'));
});

test('comment requires post_id', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->post(route('comments.store'), [
        'content' => 'Comment without post_id',
    ]);

    $response->assertSessionHasErrors('post_id');
});

test('comment requires content', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $this->actingAs($user);

    $response = $this->post(route('comments.store'), [
        'post_id' => $post->id,
    ]);

    $response->assertSessionHasErrors('content');
});

test('authenticated users can update their own comment', function () {
    $user = User::factory()->create();
    $comment = Comment::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user);

    $response = $this->put(route('comments.update', $comment), [
        'content' => 'Updated comment content',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('comments', [
        'id' => $comment->id,
        'content' => 'Updated comment content',
    ]);
});

test('users cannot update other users comment', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $comment = Comment::factory()->create(['user_id' => $otherUser->id]);

    $this->actingAs($user);

    $response = $this->put(route('comments.update', $comment), [
        'content' => 'Hacked comment',
    ]);

    $response->assertForbidden();
});

test('authenticated users can delete their own comment', function () {
    $user = User::factory()->create();
    $comment = Comment::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user);

    $response = $this->delete(route('comments.destroy', $comment));
    $response->assertRedirect();
    $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
});

test('users cannot delete other users comment', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $comment = Comment::factory()->create(['user_id' => $otherUser->id]);

    $this->actingAs($user);

    $response = $this->delete(route('comments.destroy', $comment));
    $response->assertForbidden();
    $this->assertDatabaseHas('comments', ['id' => $comment->id]);
});
