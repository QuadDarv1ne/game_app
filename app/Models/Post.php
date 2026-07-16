<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Reaction;

class Post extends Model
{

    use HasFactory;
    protected $table = 'posts';

    protected $fillable = ['user_id', 'category_id', 'title', 'description', 'body'];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tags', 'post_id', 'tag_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Закладки пользователя на этот пост.
     */
    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    /**
     * Реакции пользователей на этот пост.
     */
    public function reactions(): HasMany
    {
        return $this->hasMany(Reaction::class);
    }

    /**
     * Количество закладок на этот пост.
     */
    public function bookmarksCount(): int
    {
        return $this->bookmarks()->count();
    }

    /**
     * Получить количество закладок (для withCount).
     */
    public function getBookmarksCountAttribute(): int
    {
        return $this->bookmarks()->count();
    }

    /**
     * Количество лайков на пост.
     */
    public function likesCount(): int
    {
        return $this->reactions()->where('type', 'like')->count();
    }

    /**
     * Количество дизлайков на пост.
     */
    public function dislikesCount(): int
    {
        return $this->reactions()->where('type', 'dislike')->count();
    }

    /**
     * Получить разницу лайков и дизлайков.
     */
    public function reactionScore(): int
    {
        return $this->likesCount() - $this->dislikesCount();
    }
}
