<?php

use App\Http\Controllers\Comment\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Post\PostController;
use App\Livewire\ToggleBookmark;
use App\Livewire\UserProfile;
use App\Models\Notification;
use Illuminate\Support\Facades\Route;

// Главная страница
Route::get('/', [HomeController::class, 'index'])->name('home');

// Публичные маршруты (Доступны всем без авторизации)
Route::get('posts', [PostController::class, 'index'])->name('posts.index');
Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('feed', [PostController::class, 'feed'])->name('posts.feed');

// Маршруты, доступные только авторизованным пользователям
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    // Профиль текущего пользователя
    Route::get('profile', function () {
        return redirect()->route('profile.show', auth()->id());
    })->name('profile');

    // Просмотр профиля пользователя
    Route::get('profile/{user}', UserProfile::class)->name('profile.show');

    // Переключатель избранного
    Route::post('posts/{post}/bookmark', ToggleBookmark::class)->name('posts.bookmark');

    // Защищенный CRUD для постов (Явно прописываем форму создания перед другими роутами)
    // Изменили URL с 'posts/create' на 'publish-post'
    Route::get('publish-post', [PostController::class, 'create'])->name('posts.create');

    Route::post('posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Ресурсные маршруты для комментариев
    Route::resource('comments', CommentController::class);

    // Открыть уведомление (помечает прочитанным и ведёт по ссылке)
    Route::get('notifications/{notification}/open', function (Notification $notification) {
        abort_unless($notification->user_id === auth()->id(), 403);

        $notification->markAsRead();

        return $notification->link
            ? redirect($notification->link)
            : redirect()->route('posts.index');
    })->name('notifications.open');
});

require __DIR__.'/settings.php';
