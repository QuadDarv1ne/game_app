<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Achievement extends Model
{
    protected $table = 'achievements';

    protected $fillable = ['name', 'slug', 'description', 'required_count', 'icon'];

    /**
     * Пользователи, получившие достижение.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_achievements');
    }
}
