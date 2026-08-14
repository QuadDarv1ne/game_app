<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $achievements = [
            [
                'name' => 'Первая публикация',
                'slug' => 'posts_1',
                'description' => 'Опубликуйте свой первый пост',
                'required_count' => 1,
                'icon' => '📝',
            ],
            [
                'name' => 'Автор-профессионал',
                'slug' => 'posts_10',
                'description' => 'Опубликуйте 10 постов',
                'required_count' => 10,
                'icon' => '✍️',
            ],
            [
                'name' => 'Мастер пера',
                'slug' => 'posts_25',
                'description' => 'Опубликуйте 25 постов',
                'required_count' => 25,
                'icon' => '🖋️',
            ],
            [
                'name' => 'Первый комментарий',
                'slug' => 'comments_1',
                'description' => 'Оставьте свой первый комментарий',
                'required_count' => 1,
                'icon' => '💬',
            ],
            [
                'name' => 'Голос сообщества',
                'slug' => 'comments_50',
                'description' => 'Оставьте 50 комментариев',
                'required_count' => 50,
                'icon' => '🗣️',
            ],
            [
                'name' => 'Первая реакция',
                'slug' => 'reactions_1',
                'description' => 'Поставьте первую реакцию',
                'required_count' => 1,
                'icon' => '❤️',
            ],
            [
                'name' => 'Энтузиаст',
                'slug' => 'reactions_100',
                'description' => 'Поставьте 100 реакций',
                'required_count' => 100,
                'icon' => '⚡',
            ],
            [
                'name' => 'Коллекционер',
                'slug' => 'bookmarks_10',
                'description' => 'Добавьте 10 постов в избранное',
                'required_count' => 10,
                'icon' => '🔖',
            ],
        ];

        foreach ($achievements as $achievement) {
            Achievement::updateOrCreate(
                ['slug' => $achievement['slug']],
                $achievement,
            );
        }
    }
}
