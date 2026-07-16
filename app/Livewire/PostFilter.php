<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Livewire\Component;
use Livewire\WithPagination;

class PostFilter extends Component
{
    use WithPagination;

    public string $search = '';
    public ?int $categoryId = null;
    public ?int $tagId = null;
    public string $sortBy = 'latest'; // latest, popular, title

    /**
     * Получить отфильтрованные посты.
     */
    public function getPostsProperty()
    {
        $query = Post::with(['user', 'category', 'tags'])
            ->when($this->search, function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('body', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->categoryId, function ($q) {
                $q->where('category_id', $this->categoryId);
            })
            ->when($this->tagId, function ($q) {
                $q->whereHas('tags', function ($q) {
                    $q->where('tags.id', $this->tagId);
                });
            });

        // Сортировка
        match ($this->sortBy) {
            'popular' => $query->withCount('bookmarks')->orderBy('bookmarks_count', 'desc'),
            'title' => $query->orderBy('title', 'asc'),
            default => $query->latest(),
        };

        return $query->paginate(12);
    }

    /**
     * Сбросить фильтры.
     */
    public function resetFilters(): void
    {
        $this->search = '';
        $this->categoryId = null;
        $this->tagId = null;
        $this->sortBy = 'latest';
    }

    public function render()
    {
        return view('livewire.post-filter', [
            'posts' => $this->posts,
            'categories' => Category::all(),
            'tags' => Tag::all(),
        ]);
    }
}
