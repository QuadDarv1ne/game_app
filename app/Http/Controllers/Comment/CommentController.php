<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Models\Comment;
use App\Services\AchievementService;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): RedirectResponse
    {
        return redirect()->route('posts.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request): RedirectResponse
    {
        $user = auth()->user();

        $comment = Comment::create(array_merge($request->validated(), [
            'user_id' => $user->id,
        ]));

        $comment->load('post');

        $notificationService = app(NotificationService::class);
        $notificationService->postCommented($comment->post, $user);

        app(AchievementService::class)->sync($user);
        $user->assignRank();

        return back()->with('success', 'Комментарий успешно добавлен!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCommentRequest $request, Comment $comment): RedirectResponse
    {
        $this->authorize('update', $comment);

        $comment->update($request->validated());

        return back()->with('success', 'Комментарий изменен!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return back()->with('success', 'Комментарий удален!');
    }
}
