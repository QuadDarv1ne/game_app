<?php

namespace App\Livewire;

use App\Models\Notification;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator as LengthAwarePaginatorInstance;
use Livewire\Component;
use Livewire\WithPagination;

class NotificationsPanel extends Component
{
    use WithPagination;

    public bool $showPanel = false;

    public string $filter = 'all'; // all, unread

    /**
     * Получить уведомления текущего пользователя.
     *
     * @return LengthAwarePaginator<int, Notification>
     */
    public function getNotificationsProperty(): LengthAwarePaginator
    {
        $user = auth()->user();

        if (! $user) {
            return new LengthAwarePaginatorInstance([], 0, 10, null, [
                'path' => request()->path(),
            ]);
        }

        $query = $user->notifications()->latest();

        if ($this->filter === 'unread') {
            $query->where('is_read', false);
        }

        return $query->paginate(10);
    }

    /**
     * Переключить видимость панели.
     */
    public function toggle(): void
    {
        $this->showPanel = ! $this->showPanel;
    }

    /**
     * Отметить уведомление как прочитанное.
     */
    public function markAsRead(int $notificationId): void
    {
        $user = auth()->user();

        if (! $user) {
            return;
        }

        Notification::where('id', $notificationId)
            ->where('user_id', $user->id)
            ->update(['is_read' => true]);
    }

    /**
     * Отметить все уведомления как прочитанные.
     */
    public function markAllAsRead(): void
    {
        $user = auth()->user();

        if (! $user) {
            return;
        }

        $user->notifications()->where('is_read', false)
            ->update(['is_read' => true]);
    }

    /**
     * Удалить уведомление.
     */
    public function delete(int $notificationId): void
    {
        $user = auth()->user();

        if (! $user) {
            return;
        }

        Notification::where('id', $notificationId)
            ->where('user_id', $user->id)
            ->delete();
    }

    /**
     * Установить фильтр.
     */
    public function setFilter(string $filter): void
    {
        $this->filter = $filter;
    }

    public function render(): View
    {
        return view('livewire.notifications-panel');
    }
}
