<?php

namespace App\Livewire;

use App\Models\Post;
use App\Services\AchievementService;
use App\Services\NotificationService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ToggleBookmark extends Component
{
    public Post $post;

    public bool $isBookmarked = false;

    public int $bookmarksCount = 0;

    /**
     * Mount компонент.
     */
    public function mount(Post $post): void
    {
        $this->post = $post;

        if (auth()->check()) {
            $this->isBookmarked = auth()->user()->hasBookmarked($post);
            $this->bookmarksCount = $post->bookmarksCount();
        }
    }

    /**
     * Переключить закладку.
     */
    public function toggle(): void
    {
        if (! auth()->check()) {
            return;
        }

        $user = auth()->user();

        if ($this->isBookmarked) {
            $user->removeBookmark($this->post);
            $this->isBookmarked = false;
        } else {
            $user->bookmark($this->post);
            $this->isBookmarked = true;

            $this->post->load('user');

            $notificationService = app(NotificationService::class);
            $notificationService->postBookmarked($this->post, $user);
        }

        app(AchievementService::class)->sync($user);
        $user->assignRank();

        $this->bookmarksCount = $this->post->bookmarksCount();
    }

    public function render(): View
    {
        return view('livewire.toggle-bookmark');
    }
}
