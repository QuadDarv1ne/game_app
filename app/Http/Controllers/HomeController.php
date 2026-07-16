<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // Популярные посты (по количеству лайков)
        $popularPosts = Post::with(['user', 'category'])
            ->withCount(['reactions' => function ($q) {
                $q->where('type', 'like');
            }])
            ->orderBy('reactions_count', 'desc')
            ->limit(3)
            ->get();

        // Популярные теги (по количеству постов)
        $popularTags = Tag::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->limit(8)
            ->get();

        return view('welcome', compact('popularPosts', 'popularTags'));
    }
}
