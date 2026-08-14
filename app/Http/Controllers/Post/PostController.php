<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Services\AchievementService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::all();
        $tags = Tag::all();

        // Поиск и фильтрация
        $query = Post::with(['user', 'category', 'tags']);

        // Поиск по тексту
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                    ->orWhere('body', 'like', '%'.$request->search.'%')
                    ->orWhere('description', 'like', '%'.$request->search.'%');
            });
        }

        // Фильтр по категории
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Фильтр по тегу
        if ($request->filled('tag_id')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.id', $request->tag_id);
            });
        }

        // Сортировка
        match ($request->input('sort', 'latest')) {
            'popular' => $query->withCount(['bookmarks', 'reactions' => function ($q) {
                $q->where('type', 'like');
            }])->orderBy('bookmarks_count', 'desc'),
            'title' => $query->orderBy('title', 'asc'),
            'reactions' => $query->withCount('reactions')->orderBy('reactions_count', 'desc'),
            default => $query->latest(),
        };

        $posts = $query->paginate(12);

        return view('pages.posts.index', compact('posts', 'categories', 'tags'));
    }

    public function create(): View
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('pages.posts.create', compact('categories', 'tags'));
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $userId = auth()->id();

        DB::transaction(function () use ($request, $userId) {

            $post = Post::create(array_merge($request->validated(), [
                'user_id' => $userId,
            ]));

            if ($request->has('tags')) {
                $post->tags()->attach($request->tags);
            }
        });

        $user = User::withCount([
            'posts',
            'comments',
            'reactions',
            'bookmarks',
        ])->find($userId);

        app(AchievementService::class)->sync($user);
        $user->assignRank();

        return redirect()->route('posts.index')->with('success', 'Пост успешно создан!');
    }

    public function show(Post $post): View
    {
        $post->load(['user', 'category', 'tags', 'comments.user']);

        $seoDescription = Str::limit(strip_tags($post->body), 160);

        // Похожие посты по категории и тегам
        $similarPosts = Post::with(['user', 'category'])
            ->where('id', '!=', $post->id)
            ->where(function ($q) use ($post) {
                $q->where('category_id', $post->category_id)
                    ->orWhereHas('tags', function ($tagQuery) use ($post) {
                        $tagQuery->whereIn('tags.id', $post->tags->pluck('id')->toArray());
                    });
            })
            ->latest()
            ->limit(3)
            ->get();

        return view('pages.posts.show', compact('post', 'similarPosts'))->with('seo', [
            'title' => $post->title.' - '.config('app.name'),
            'description' => $seoDescription,
        ]);
    }

    public function edit(Post $post): View
    {
        $categories = Category::all();
        $tags = Tag::all();

        $post->load('tags');

        return view('pages.posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(StorePostRequest $request, Post $post): RedirectResponse
    {
        $this->authorize('update', $post);

        DB::transaction(function () use ($request, $post) {
            $post->update($request->except('tags'));

            $post->tags()->sync($request->get('tags', []));
        });

        return redirect()->route('posts.show', $post)->with('success', 'Пост успешно обновлен!');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Пост успешно удален!');
    }
}
