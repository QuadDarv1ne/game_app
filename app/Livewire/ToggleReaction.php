<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\User;
use App\Services\AchievementService;
use App\Services\NotificationService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ToggleReaction extends Component
{
    public Post $post;

    public bool $isLiked = false;

    public bool $isDisliked = false;

    public int $likesCount = 0;

    public int $dislikesCount = 0;

    /** @var array<string, string> */
    protected $listeners = ['reactionSent' => '$refresh'];

    /**
     * Mount компонент.
     */
    public function mount(Post $post): void
    {
        $this->post = $post;

        if (auth()->check()) {
            $this->isLiked = auth()->user()->hasReacted($post, 'like');
            $this->isDisliked = auth()->user()->hasReacted($post, 'dislike');
            $this->likesCount = $post->likesCount();
            $this->dislikesCount = $post->dislikesCount();
        }
    }

    /**
     * Переключить лайк.
     */
    public function toggleLike(): void
    {
        if (! auth()->check()) {
            return;
        }

        $user = auth()->user();
        $service = app(NotificationService::class);

        if ($this->isLiked) {
            $user->removeReaction($this->post, 'like');
            $this->isLiked = false;
        } else {
            $user->react($this->post, 'like');
            $this->isLiked = true;
            // Убираем дизлайк при добавлении лайка
            if ($this->isDisliked) {
                $user->removeReaction($this->post, 'dislike');
                $this->isDisliked = false;
            }

            // Отправляем уведомление
            $service->postLiked($this->post, $user);
        }

        $this->syncProgress($user);

        $this->refreshCounts();
    }

    /**
     * Переключить дизлайк.
     */
    public function toggleDislike(): void
    {
        if (! auth()->check()) {
            return;
        }

        $user = auth()->user();
        $service = app(NotificationService::class);

        if ($this->isDisliked) {
            $user->removeReaction($this->post, 'dislike');
            $this->isDisliked = false;
        } else {
            $user->react($this->post, 'dislike');
            $this->isDisliked = true;
            // Убираем лайк при добавлении дизлайка
            if ($this->isLiked) {
                $user->removeReaction($this->post, 'like');
                $this->isLiked = false;
            }

            // Отправляем уведомление
            $service->postDisliked($this->post, $user);
        }

        $this->syncProgress($user);

        $this->refreshCounts();
    }

    /**
     * Обновить достижения и ранг пользователя.
     */
    protected function syncProgress(User $user): void
    {
        app(AchievementService::class)->sync($user);
        $user->assignRank();
    }

    /**
     * Обновить счётчики реакций.
     */
    protected function refreshCounts(): void
    {
        $this->likesCount = $this->post->likesCount();
        $this->dislikesCount = $this->post->dislikesCount();
    }

    public function render(): View
    {
        return view('livewire.toggle-reaction');
    }
}
