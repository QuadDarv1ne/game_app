<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Notification;
use App\Models\Post;
use App\Models\User;

class NotificationService
{
    /**
     * Отправить уведомление о лайке поста.
     */
    public function postLiked(Post $post, User $user): void
    {
        if ($post->user_id === $user->id) {
            return;
        }

        if (! $post->user) {
            return;
        }

        Notification::create([
            'user_id' => $post->user_id,
            'type' => 'like',
            'title' => 'Вам поставили лайк!',
            'message' => $user->name.' оценил ваш пост: '.$post->title,
            'link' => route('posts.show', $post),
        ]);
    }

    /**
     * Отправить уведомление о дизлайке поста.
     */
    public function postDisliked(Post $post, User $user): void
    {
        if ($post->user_id === $user->id) {
            return;
        }

        if (! $post->user) {
            return;
        }

        Notification::create([
            'user_id' => $post->user_id,
            'type' => 'dislike',
            'title' => 'Вам поставили дизлайк!',
            'message' => $user->name.' не оценил ваш пост: '.$post->title,
            'link' => route('posts.show', $post),
        ]);
    }

    /**
     * Отправить уведомление о комментарии.
     */
    public function postCommented(Post $post, User $user): void
    {
        if ($post->user_id === $user->id) {
            return;
        }

        Notification::create([
            'user_id' => $post->user_id,
            'type' => 'comment',
            'title' => 'Новый комментарий!',
            'message' => $user->name.' прокомментировал ваш пост: '.$post->title,
            'link' => route('posts.show', $post).'#comments',
        ]);
    }

    /**
     * Отправить уведомление о лайке комментария.
     */
    public function commentLiked(Comment $comment, User $user): void
    {
        if ($comment->user_id === $user->id) {
            return;
        }

        if (! $comment->post) {
            return;
        }

        Notification::create([
            'user_id' => $comment->user_id,
            'type' => 'like',
            'title' => 'Вам поставили лайк на комментарий!',
            'message' => $user->name.' оценил ваш комментарий',
            'link' => route('posts.show', $comment->post).'#comment-'.$comment->id,
        ]);
    }

    /**
     * Отправить уведомление о добавлении в избранное.
     */
    public function postBookmarked(Post $post, User $user): void
    {
        if ($post->user_id === $user->id) {
            return;
        }

        Notification::create([
            'user_id' => $post->user_id,
            'type' => 'bookmark',
            'title' => 'Ваш пост добавили в избранное!',
            'message' => $user->name.' добавил(а) ваш пост в избранное: '.$post->title,
            'link' => route('posts.show', $post),
        ]);
    }

    /**
     * Уведомить подписчиков о новой публикации автора.
     */
    public function postPublished(Post $post, User $subscriber): void
    {
        if ($post->user_id === $subscriber->id) {
            return;
        }

        Notification::create([
            'user_id' => $subscriber->id,
            'type' => 'post',
            'title' => 'Новая публикация!',
            'message' => $post->user?->name.' опубликовал новый пост: '.$post->title,
            'link' => route('posts.show', $post),
        ]);
    }
}
