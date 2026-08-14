<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = ['user_id', 'type', 'title', 'message', 'link', 'is_read'];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    /**
     * Пользователь, которому отправлено уведомление.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Отметить как прочитанное.
     */
    public function markAsRead(): void
    {
        $this->update(['is_read' => true]);
    }

    /**
     * Получить иконку для типа уведомления.
     */
    public function getIconAttribute(): string
    {
        return match ($this->type) {
            'like' => '👍',
            'dislike' => '👎',
            'comment' => '💬',
            'bookmark' => '⭐',
            default => '🔔',
        };
    }
}
