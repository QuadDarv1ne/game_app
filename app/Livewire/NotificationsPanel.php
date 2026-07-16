<?php

namespace App\Livewire;

use App\Models\Notification;
use Livewire\Component;
use Livewire\WithPagination;

class NotificationsPanel extends Component
{
    use WithPagination;

    public $showPanel = false;
    public $filter = 'all'; // all, unread

    /**
     * Получить уведомления текущего пользователя.
     */
    public function getNotificationsProperty()
    {
        $query = auth()->user()->notifications()->latest();

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
        $this->showPanel = !$this->showPanel;
    }

    /**
     * Отметить уведомление как прочитанное.
     */
    public function markAsRead($notificationId): void
    {
        Notification::where('id', $notificationId)
            ->where('user_id', auth()->id())
            ->update(['is_read' => false]);
    }

    /**
     * Отметить все уведомления как прочитанные.
     */
    public function markAllAsRead(): void
    {
        auth()->user()->notifications()->where('is_read', false)
            ->update(['is_read' => true]);
    }

    /**
     * Удалить уведомление.
     */
    public function delete($notificationId): void
    {
        Notification::where('id', $notificationId)
            ->where('user_id', auth()->id())
            ->delete();
    }

    /**
     * Установить фильтр.
     */
    public function setFilter($filter): void
    {
        $this->filter = $filter;
    }

    public function render()
    {
        return view('livewire.notifications-panel');
    }
}
