<?php

use App\Livewire\UserProfile;
use App\Models\Achievement;
use App\Models\User;
use App\Models\UserRank;

test('profile redirects to the users own page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('profile'))
        ->assertRedirect(route('profile.show', $user));
});

test('profile page renders for a guest visible user', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('profile.show', $user))
        ->assertOk()
        ->assertSee($user->name);
});

test('profile page shows the current rank badge', function () {
    $rank = UserRank::factory()->create(['level' => 2, 'required_posts' => 0]);
    $user = User::factory()->create(['rank_id' => $rank->id]);

    $this->actingAs($user)
        ->get(route('profile.show', $user))
        ->assertOk()
        ->assertSee($rank->name);
});

test('profile page shows earned achievements', function () {
    $user = User::factory()->create();
    $achievement = Achievement::factory()->create(['slug' => 'posts_1', 'required_count' => 1]);
    $user->achievements()->attach($achievement->id);

    Livewire::test(UserProfile::class, ['user' => $user])
        ->call('setActiveTab', 'achievements')
        ->assertOk()
        ->assertSee($achievement->name);
});
