<?php

namespace Database\Factories;

use App\Models\UserRank;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserRank>
 */
class UserRankFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'slug' => $this->faker->unique()->slug(2),
            'level' => 1,
            'required_posts' => 0,
            'required_comments' => 0,
            'required_reactions' => 0,
            'icon' => '🏅',
            'color' => '#6366f1',
        ];
    }
}
