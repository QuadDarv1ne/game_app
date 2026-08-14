<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // Популярные посты (по количеству лайков)
        $popularPosts = Post::with(['user', 'category'])
            ->withCount(['reactions' => function ($q) {
                $q->where('type', 'like');
            }, 'comments', 'bookmarks'])
            ->orderBy('reactions_count', 'desc')
            ->limit(3)
            ->get();

        // Последние посты
        $latestPosts = Post::with(['user', 'category'])
            ->withCount(['reactions' => function ($q) {
                $q->where('type', 'like');
            }, 'comments'])
            ->latest()
            ->limit(4)
            ->get();

        // Популярные теги (по количеству постов)
        $popularTags = Tag::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->limit(10)
            ->get();

        // Статистика платформы
        $stats = [
            'posts' => Post::query()->count(),
            'users' => User::query()->count(),
            'comments' => Comment::query()->count(),
        ];

        return view('welcome', compact('popularPosts', 'latestPosts', 'popularTags', 'stats'));
    }
}
