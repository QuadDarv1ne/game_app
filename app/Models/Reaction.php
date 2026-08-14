<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reaction extends Model
{
    protected $table = 'reactions';

    protected $fillable = ['user_id', 'post_id', 'type'];

    /**
     * Пользователь, оставивший реакцию.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Пост, на который оставлена реакция.
     *
     * @return BelongsTo<Post, $this>
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Проверить, является ли реакция лайком.
     */
    public function isLike(): bool
    {
        return $this->type === 'like';
    }

    /**
     * Проверить, является ли реакция дизлайком.
     */
    public function isDislike(): bool
    {
        return $this->type === 'dislike';
    }
}
