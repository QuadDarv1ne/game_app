<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserRank extends Model
{
    protected $table = 'user_ranks';

    protected $fillable = ['name', 'slug', 'level', 'required_posts', 'required_comments', 'required_reactions', 'icon', 'color'];

    /**
     * Пользователи с этим рангом.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'rank_id');
    }

    /**
     * Получить текущий ранг пользователя.
     */
    public function getCurrentRank(): ?self
    {
        $currentUser = auth()->user();
        if (!$currentUser) {
            return null;
        }

        return self::where('required_posts', '<=', $currentUser->posts()->count())
            ->where('required_comments', '<=', $currentUser->comments()->count())
            ->where('required_reactions', '<=', $currentUser->reactions()->count())
            ->orderBy('level', 'desc')
            ->first();
    }

    /**
     * Получить прогресс пользователя до следующего ранга.
     */
    public function getProgressPercentage(): int
    {
        $currentUser = auth()->user();
        if (!$currentUser) {
            return 0;
        }

        $postsProgress = $this->required_posts > 0 
            ? min(100, ($currentUser->posts()->count() / $this->required_posts) * 100) 
            : 100;
        
        $commentsProgress = $this->required_comments > 0 
            ? min(100, ($currentUser->comments()->count() / $this->required_comments) * 100) 
            : 100;
        
        $reactionsProgress = $this->required_reactions > 0 
            ? min(100, ($currentUser->reactions()->count() / $this->required_reactions) * 100) 
            : 100;

        return (int) round(($postsProgress + $commentsProgress + $reactionsProgress) / 3);
    }
}
