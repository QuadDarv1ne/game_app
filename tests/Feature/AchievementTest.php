<?php

use App\Models\Achievement;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Services\AchievementService;

test('achievement is granted when the threshold is reached', function () {
    $user = User::factory()->create();
    $achievement = Achievement::factory()->create(['slug' => 'posts_1', 'required_count' => 1]);

    app(AchievementService::class)->sync($user);

    $this->assertDatabaseMissing('user_achievements', [
        'user_id' => $user->id,
        'achievement_id' => $achievement->id,
    ]);

    Post::factory()->create(['user_id' => $user->id]);

    app(AchievementService::class)->sync($user);

    $this->assertDatabaseHas('user_achievements', [
        'user_id' => $user->id,
        'achievement_id' => $achievement->id,
    ]);
});

test('achievements are granted based on their slug prefix counter', function () {
    $user = User::factory()->create();

    $postAchievement = Achievement::factory()->create(['slug' => 'posts_5', 'required_count' => 5]);
    $commentAchievement = Achievement::factory()->create(['slug' => 'comments_2', 'required_count' => 2]);

    Post::factory()->count(5)->create(['user_id' => $user->id]);
    Comment::factory()->count(2)->create(['user_id' => $user->id]);

    app(AchievementService::class)->sync($user);

    $this->assertDatabaseHas('user_achievements', ['user_id' => $user->id, 'achievement_id' => $postAchievement->id]);
    $this->assertDatabaseHas('user_achievements', ['user_id' => $user->id, 'achievement_id' => $commentAchievement->id]);
});

test('achievements are not granted twice', function () {
    $user = User::factory()->create();
    $achievement = Achievement::factory()->create(['slug' => 'posts_1', 'required_count' => 1]);

    Post::factory()->create(['user_id' => $user->id]);

    app(AchievementService::class)->sync($user);
    app(AchievementService::class)->sync($user);

    $this->assertDatabaseCount('user_achievements', 1);
});

test('unlocking achievements through the post creation endpoint', function () {
    $user = User::factory()->create();
    $achievement = Achievement::factory()->create(['slug' => 'posts_1', 'required_count' => 1]);
    $category = Category::factory()->create();

    $this->actingAs($user)->post(route('posts.store'), [
        'title' => 'My first post',
        'description' => 'Description',
        'body' => 'Body content',
        'category_id' => $category->id,
    ]);

    $this->assertDatabaseHas('user_achievements', [
        'user_id' => $user->id,
        'achievement_id' => $achievement->id,
    ]);
});
