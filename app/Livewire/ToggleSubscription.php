<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class ToggleSubscription extends Component
{
    public User $user;

    public bool $isSubscribed = false;

    public int $subscribersCount = 0;

    /**
     * Mount компонент.
     */
    public function mount(User $user): void
    {
        $this->user = $user;

        if (auth()->check() && auth()->id() !== $user->id) {
            $this->isSubscribed = auth()->user()->isSubscribed($user);
            $this->subscribersCount = $user->subscribersCount();
        }
    }

    /**
     * Переключить подписку.
     */
    public function toggle(): void
    {
        if (!auth()->check() || auth()->id() === $this->user->id) {
            return;
        }

        $subscriber = auth()->user();

        if ($this->isSubscribed) {
            $subscriber->unsubscribe($this->user);
            $this->isSubscribed = false;
        } else {
            $subscriber->subscribe($this->user);
            $this->isSubscribed = true;
        }

        $this->subscribersCount = $this->user->subscribersCount();
    }

    public function render()
    {
        return view('livewire.toggle-subscription');
    }
}
