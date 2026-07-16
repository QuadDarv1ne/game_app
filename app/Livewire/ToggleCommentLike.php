<?php

namespace App\Livewire;

use App\Models\Comment;
use Livewire\Component;

class ToggleCommentLike extends Component
{
    public Comment $comment;

    public bool $isLiked = false;

    public int $likesCount = 0;

    /**
     * Mount компонент.
     */
    public function mount(Comment $comment): void
    {
        $this->comment = $comment;

        if (auth()->check()) {
            $this->isLiked = auth()->user()->commentLikes()->where('comment_id', $comment->id)->exists();
            $this->likesCount = $comment->likesCount();
        }
    }

    /**
     * Переключить лайк.
     */
    public function toggle(): void
    {
        if (!auth()->check()) {
            return;
        }

        $user = auth()->user();

        if ($this->isLiked) {
            $user->commentLikes()->where('comment_id', $this->comment->id)->delete();
            $this->isLiked = false;
        } else {
            $user->commentLikes()->create(['comment_id' => $this->comment->id]);
            $this->isLiked = true;
        }

        $this->likesCount = $this->comment->likesCount();
    }

    public function render()
    {
        return view('livewire.toggle-comment-like');
    }
}
