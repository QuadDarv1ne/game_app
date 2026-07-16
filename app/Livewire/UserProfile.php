<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\Bookmark;
use App\Models\Reaction;
use Livewire\Component;
use Livewire\WithPagination;

class UserProfile extends Component
{
    use WithPagination;

    public \App\Models\User $user;
    public string $activeTab = 'posts'; // posts, bookmarks, reactions

    public function mount(\App\Models\User $user): void
    {
        $this->user = $user;
    }

    /**
     * Получить посты пользователя.
     */
    public function getPostsProperty()
    {
        return Post::with(['user', 'category', 'tags'])
            ->where('user_id', $this->user->id)
            ->latest()
            ->paginate(12);
    }

    /**
     * Получить избранные посты пользователя.
     */
    public function getBookmarksProperty()
    {
        return Bookmark::with(['post.user', 'post.category', 'post.tags'])
            ->where('user_id', $this->user->id)
            ->latest()
            ->get()
            ->map(function ($bookmark) {
                return $bookmark->post;
            })
            ->values();
    }

    /**
     * Получить реакции пользователя.
     */
    public function getReactionsProperty()
    {
        return Reaction::with(['post.user', 'post.category', 'post.tags'])
            ->where('user_id', $this->user->id)
            ->latest()
            ->paginate(12);
    }

    /**
     * Переключить вкладку.
     */
    public function setActiveTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.user-profile', [
            'stats' => $this->user->getStats(),
        ]);
    }
}
