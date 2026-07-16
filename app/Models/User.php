<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Reaction;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property Carbon|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        $initials = Str::initials($this->name, true);

        return Str::length($initials) > 1
            ? Str::substr($initials, 0, 1).Str::substr($initials, -1)
            : $initials;
    }

    /**
     * Посты пользователя.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Комментарии пользователя.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Избранные посты пользователя.
     */
    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    /**
     * Реакции пользователя на посты.
     */
    public function reactions(): HasMany
    {
        return $this->hasMany(Reaction::class);
    }

    /**
     * Проверить, добавлен ли пост в избранное пользователем.
     */
    public function hasBookmarked(Post $post): bool
    {
        return $this->bookmarks()->where('post_id', $post->id)->exists();
    }

    /**
     * Добавить пост в избранное.
     */
    public function bookmark(Post $post): void
    {
        if (!$this->hasBookmarked($post)) {
            $this->bookmarks()->create(['post_id' => $post->id]);
        }
    }

    /**
     * Удалить пост из избранного.
     */
    public function removeBookmark(Post $post): void
    {
        $this->bookmarks()->where('post_id', $post->id)->delete();
    }

    /**
     * Проверить, есть ли у пользователя реакция на пост.
     */
    public function hasReacted(Post $post, string $type): bool
    {
        return $this->reactions()->where('post_id', $post->id)->where('type', $type)->exists();
    }

    /**
     * Добавить реакцию на пост.
     */
    public function react(Post $post, string $type): void
    {
        if (!$this->hasReacted($post, $type)) {
            $this->reactions()->create(['post_id' => $post->id, 'type' => $type]);
        }
    }

    /**
     * Удалить реакцию на пост.
     */
    public function removeReaction(Post $post, string $type): void
    {
        $this->reactions()->where('post_id', $post->id)->where('type', $type)->delete();
    }

    /**
     * Получить статистику пользователя.
     */
    public function getStats(): array
    {
        return [
            'posts_count' => $this->posts()->count(),
            'comments_count' => $this->comments()->count(),
            'bookmarks_count' => $this->bookmarks()->count(),
            'reactions_count' => $this->reactions()->count(),
        ];
    }
}
