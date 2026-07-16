<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bookmark extends Model
{
    use HasFactory;

    protected $table = 'bookmarks';

    protected $fillable = ['user_id', 'post_id'];

    /**
     * Получить пользователя, которому принадлежит закладка.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получить пост, добавленный в закладки.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
