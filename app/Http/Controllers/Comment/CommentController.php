<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Models\Comment;
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
        Comment::create($request->validated());

        return back()->with('success', 'Комментарий успешно добавлен!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCommentRequest $request, Comment $comment): RedirectResponse
    {
        if (auth()->user()->id !== $comment->user_id) {
            abort(403, 'Вы не можете редактировать этот комментарий!');
        }
        $comment->update($request->validated());

        return back()->with('success', 'Коментарий изменен!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        if (auth()->user()->id !== $comment->user_id) {
            abort(403, 'Вы не можете редактировать этот комментарий!');
        }
        $comment->delete();

        return back()->with('success', 'Комментарий удален!');
    }
}
