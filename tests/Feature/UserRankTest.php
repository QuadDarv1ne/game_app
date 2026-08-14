<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Models\UserRank;

test('assignRank assigns the highest qualifying rank', function () {
    $rookie = UserRank::factory()->create(['level' => 1, 'required_posts' => 0]);
    $author = UserRank::factory()->create(['level' => 2, 'required_posts' => 3]);

    $user = User::factory()->create();
    Post::factory()->count(3)->create(['user_id' => $user->id]);

    $user->assignRank();

    $this->assertSame($author->id, $user->fresh()->rank_id);
    $this->assertNotSame($rookie->id, $user->fresh()->rank_id);
});

test('assignRank keeps the rookie rank for inactive users', function () {
    $rookie = UserRank::factory()->create(['level' => 1, 'required_posts' => 0]);
    UserRank::factory()->create(['level' => 2, 'required_posts' => 3]);

    $user = User::factory()->create();

    $user->assignRank();

    $this->assertSame($rookie->id, $user->fresh()->rank_id);
});

test('rank upgrades as the user gains activity', function () {
    $rookie = UserRank::factory()->create(['level' => 1, 'required_posts' => 0]);
    $author = UserRank::factory()->create(['level' => 2, 'required_posts' => 3]);

    $user = User::factory()->create();
    $user->assignRank();
    $this->assertSame($rookie->id, $user->fresh()->rank_id);

    Post::factory()->count(3)->create(['user_id' => $user->id]);
    $user->assignRank();
    $this->assertSame($author->id, $user->fresh()->rank_id);
});

test('rank is assigned when a post is created', function () {
    $user = User::factory()->create();
    $author = UserRank::factory()->create(['level' => 2, 'required_posts' => 1]);
    $category = Category::factory()->create();

    $this->actingAs($user)->post(route('posts.store'), [
        'title' => 'My first post',
        'description' => 'Description',
        'body' => 'Body content',
        'category_id' => $category->id,
    ]);

    $this->assertSame($author->id, $user->fresh()->rank_id);
});
