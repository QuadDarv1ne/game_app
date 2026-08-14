<?php

namespace App\Services;

use App\Models\Achievement;
use App\Models\User;

class AchievementService
{
    /**
     * Проверить достижения пользователя и выдать новые при достижении порога.
     */
    public function sync(User $user): void
    {
        $user = $user->loadCount([
            'posts',
            'comments',
            'reactions',
            'bookmarks',
        ]);

        $attributes = $user->getAttributes();

        $counters = [
            'posts' => (int) $attributes['posts_count'],
            'comments' => (int) $attributes['comments_count'],
            'reactions' => (int) $attributes['reactions_count'],
            'bookmarks' => (int) $attributes['bookmarks_count'],
        ];

        $ownedIds = $user->achievements()->pluck('achievements.id')->toArray();

        Achievement::query()
            ->whereNotIn('id', $ownedIds)
            ->get()
            ->each(function (Achievement $achievement) use ($user, $counters): void {
                $prefix = str($achievement->slug)->before('_')->toString();
                $count = $counters[$prefix] ?? 0;

                if ($count >= $achievement->required_count) {
                    $user->achievements()->attach($achievement->id);
                }
            });
    }
}
