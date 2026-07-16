<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{

    use HasFactory;
    protected $table = 'comments';

    protected $fillable = ['post_id', 'user_id', 'content'];

    public function post() : BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Лайки на комментарий.
     */
    public function likes(): HasMany
    {
        return $this->hasMany(CommentLike::class);
    }

    /**
     * Количество лайков на комментарий.
     */
    public function likesCount(): int
    {
        return $this->likes()->count();
    }
}
