<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\User;

test('guests can view posts index', function () {
    $response = $this->get(route('posts.index'));
    $response->assertOk();
});

test('guests can view a post', function () {
    $post = Post::factory()->create();

    $response = $this->get(route('posts.show', $post));
    $response->assertOk();
});

test('authenticated users can create a post', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $this->actingAs($user);

    $response = $this->post(route('posts.store'), [
        'title' => 'Test Post Title',
        'description' => 'Test post description',
        'body' => 'Test post body content',
        'category_id' => $category->id,
    ]);

    $response->assertRedirect(route('posts.index'));
    $this->assertDatabaseHas('posts', [
        'title' => 'Test Post Title',
        'user_id' => $user->id,
    ]);
});

test('authenticated users can update their own post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user);

    $response = $this->put(route('posts.update', $post), [
        'title' => 'Updated Title',
        'description' => 'Updated description',
        'body' => 'Updated body',
        'category_id' => $post->category_id,
    ]);

    $response->assertRedirect(route('posts.show', $post));
    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'title' => 'Updated Title',
    ]);
});

test('users cannot update other users post', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $otherUser->id]);

    $this->actingAs($user);

    $response = $this->put(route('posts.update', $post), [
        'title' => 'Hacked Title',
        'description' => 'Hacked description',
        'body' => 'Hacked body',
        'category_id' => $post->category_id,
    ]);

    $response->assertForbidden();
});

test('authenticated users can delete their own post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user);

    $response = $this->delete(route('posts.destroy', $post));
    $response->assertRedirect(route('posts.index'));
    $this->assertDatabaseMissing('posts', ['id' => $post->id]);
});

test('users cannot delete other users post', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $otherUser->id]);

    $this->actingAs($user);

    $response = $this->delete(route('posts.destroy', $post));
    $response->assertForbidden();
    $this->assertDatabaseHas('posts', ['id' => $post->id]);
});

test('unauthenticated users cannot create posts', function () {
    $category = Category::factory()->create();

    $response = $this->post(route('posts.store'), [
        'title' => 'Test Post',
        'description' => 'Test description',
        'body' => 'Test body',
        'category_id' => $category->id,
    ]);

    $response->assertRedirect(route('login'));
});

test('posts index supports search', function () {
    Post::factory()->create(['title' => 'Laravel Tutorial']);
    Post::factory()->create(['title' => 'PHP Basics']);

    $response = $this->get(route('posts.index', ['search' => 'Laravel']));
    $response->assertOk();
});

test('posts index supports category filter', function () {
    $category = Category::factory()->create();
    Post::factory()->create(['category_id' => $category->id]);

    $response = $this->get(route('posts.index', ['category_id' => $category->id]));
    $response->assertOk();
});
