<?php

namespace App\Models;

use Database\Factories\PostTagFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
    /** @use HasFactory<PostTagFactory> */
    use HasFactory;

    protected $table = 'post_tags';

    protected $fillable = ['post_id', 'tag_id'];
}
