<?php

namespace App\Livewire;

use App\Models\Post;
use App\Services\NotificationService;
use Livewire\Component;

class ToggleReaction extends Component
{
    public Post $post;

    public bool $isLiked = false;

    public bool $isDisliked = false;

    public int $likesCount = 0;

    public int $dislikesCount = 0;

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
        if (!auth()->check()) {
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

        $this->likesCount = $this->post->likesCount();
        $this->dislikesCount = $this->post->dislikesCount();
    }

    /**
     * Переключить дизлайк.
     */
    public function toggleDislike(): void
    {
        if (!auth()->check()) {
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

        $this->likesCount = $this->post->likesCount();
        $this->dislikesCount = $this->post->dislikesCount();
    }

    public function render()
    {
        return view('livewire.toggle-reaction');
    }
}
