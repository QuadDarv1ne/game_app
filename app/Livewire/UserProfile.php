<?php

namespace App\Livewire;

use App\Models\Achievement;
use App\Models\Bookmark;
use App\Models\Post;
use App\Models\Reaction;
use App\Models\User;
use App\Models\UserRank;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class UserProfile extends Component
{
    use WithPagination;

    public User $user;

    public string $activeTab = 'posts'; // posts, bookmarks, reactions

    public function mount(User $user): void
    {
        $this->user = $user;
    }

    /**
     * Получить посты пользователя.
     *
     * @return LengthAwarePaginator<int, Post>
     */
    public function getPostsProperty(): LengthAwarePaginator
    {
        return Post::with(['user', 'category', 'tags', 'comments'])
            ->where('user_id', $this->user->id)
            ->latest()
            ->paginate(12);
    }

    /**
     * Получить избранные посты пользователя.
     *
     * @return LengthAwarePaginator<int, Bookmark>
     */
    public function getBookmarksProperty(): LengthAwarePaginator
    {
        return Bookmark::with(['post.user', 'post.category', 'post.tags'])
            ->where('user_id', $this->user->id)
            ->latest()
            ->paginate(12);
    }

    /**
     * Получить реакции пользователя.
     *
     * @return LengthAwarePaginator<int, Reaction>
     */
    public function getReactionsProperty(): LengthAwarePaginator
    {
        return Reaction::with(['post.user', 'post.category', 'post.tags'])
            ->where('user_id', $this->user->id)
            ->latest()
            ->paginate(12);
    }

    /**
     * Получить все достижения с отметкой о получении.
     *
     * @return Collection<int, array{achievement: Achievement, unlocked: bool}>
     */
    public function getAchievementsProperty(): Collection
    {
        $ownedIds = $this->user->achievements()->pluck('achievements.id')->toArray();

        return Achievement::query()
            ->get()
            ->map(fn (Achievement $achievement): array => [
                'achievement' => $achievement,
                'unlocked' => in_array($achievement->id, $ownedIds, true),
            ])
            ->sortByDesc('unlocked')
            ->values();
    }

    /**
     * Получить текущий ранг, следующий ранг и процент прогресса.
     *
     * @return array{current: ?UserRank, next: ?UserRank, percent: int}
     */
    public function getRankProgressProperty(): array
    {
        $currentRank = $this->user->rank;

        $user = $this->user->loadCount([
            'posts',
            'comments',
            'reactions',
        ]);

        $nextRank = UserRank::query()
            ->where('level', '>', $currentRank->level ?? 0)
            ->orderBy('level')
            ->first();

        if ($nextRank === null) {
            return ['current' => $currentRank, 'next' => null, 'percent' => 100];
        }

        $requirements = [
            'posts' => $nextRank->required_posts,
            'comments' => $nextRank->required_comments,
            'reactions' => $nextRank->required_reactions,
        ];

        $percents = collect($requirements)
            ->filter(fn (int $required): bool => $required > 0)
            ->map(fn (int $required, string $metric): int => (int) min(100, ($user->getAttributes()[$metric.'_count'] / $required) * 100));

        $percent = $percents->isEmpty() ? 100 : (int) round($percents->avg());

        return ['current' => $currentRank, 'next' => $nextRank, 'percent' => $percent];
    }

    /**
     * Переключить вкладку.
     */
    public function setActiveTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function render(): View
    {
        return view('livewire.user-profile', [
            'stats' => $this->user->getStats(),
            'rankProgress' => $this->getRankProgressProperty(),
        ]);
    }
}
