<?php

namespace Database\Seeders;

use App\Models\UserRank;
use Illuminate\Database\Seeder;

class UserRankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ranks = [
            [
                'name' => 'Новичок',
                'slug' => 'rookie',
                'level' => 1,
                'required_posts' => 0,
                'required_comments' => 0,
                'required_reactions' => 0,
                'icon' => '🎮',
                'color' => '#71717a',
            ],
            [
                'name' => 'Автор',
                'slug' => 'author',
                'level' => 2,
                'required_posts' => 3,
                'required_comments' => 0,
                'required_reactions' => 0,
                'icon' => '✍️',
                'color' => '#f59e0b',
            ],
            [
                'name' => 'Активный участник',
                'slug' => 'active-member',
                'level' => 3,
                'required_posts' => 1,
                'required_comments' => 10,
                'required_reactions' => 0,
                'icon' => '💬',
                'color' => '#22c55e',
            ],
            [
                'name' => 'Эксперт',
                'slug' => 'expert',
                'level' => 4,
                'required_posts' => 10,
                'required_comments' => 25,
                'required_reactions' => 50,
                'icon' => '🏆',
                'color' => '#3b82f6',
            ],
            [
                'name' => 'Легенда',
                'slug' => 'legend',
                'level' => 5,
                'required_posts' => 25,
                'required_comments' => 100,
                'required_reactions' => 200,
                'icon' => '👑',
                'color' => '#ef4444',
            ],
        ];

        foreach ($ranks as $rank) {
            UserRank::updateOrCreate(
                ['slug' => $rank['slug']],
                $rank,
            );
        }
    }
}
