<div class="space-y-6">
    <!-- Поиск и фильтры -->
    <div class="p-5 bg-zinc-900 border border-zinc-800/80 rounded-sm space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-xs font-mono font-bold uppercase tracking-widest text-zinc-300">
                // Фильтры и поиск
            </h2>
            <button 
                wire:click="resetFilters" 
                class="text-[10px] font-mono text-zinc-500 hover:text-red-400 uppercase tracking-wider transition-colors"
            >
                [ Сбросить ]
            </button>
        </div>

        <!-- Поиск -->
        <div class="relative">
            <input 
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Поиск по заголовку, тексту или описанию..."
                class="w-full bg-zinc-950 border border-zinc-800 rounded-sm p-3 text-xs text-zinc-100 placeholder-zinc-600 focus:outline-none focus:border-red-600 focus:ring-2 focus:ring-red-600/20 transition-all font-mono"
            >
            @if($search)
            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] font-mono text-red-500">●</span>
            @endif
        </div>

        <!-- Фильтры -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <!-- Категория -->
            <div class="space-y-1.5">
                <label class="text-[9px] font-mono text-zinc-500 uppercase tracking-wider">Категория</label>
                <select 
                    wire:model.live="categoryId"
                    class="w-full bg-zinc-950 border border-zinc-800 rounded-sm p-2.5 text-xs text-zinc-100 focus:outline-none focus:border-red-600 transition-all font-mono"
                >
                    <option value="">Все категории</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Тег -->
            <div class="space-y-1.5">
                <label class="text-[9px] font-mono text-zinc-500 uppercase tracking-wider">Тег</label>
                <select 
                    wire:model.live="tagId"
                    class="w-full bg-zinc-950 border border-zinc-800 rounded-sm p-2.5 text-xs text-zinc-100 focus:outline-none focus:border-red-600 transition-all font-mono"
                >
                    <option value="">Все теги</option>
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Сортировка -->
            <div class="space-y-1.5">
                <label class="text-[9px] font-mono text-zinc-500 uppercase tracking-wider">Сортировка</label>
                <select 
                    wire:model.live="sortBy"
                    class="w-full bg-zinc-950 border border-zinc-800 rounded-sm p-2.5 text-xs text-zinc-100 focus:outline-none focus:border-red-600 transition-all font-mono"
                >
                    <option value="latest">Сначала новые</option>
                    <option value="popular">Популярные</option>
                    <option value="title">По алфавиту</option>
                </select>
            </div>
        </div>

        <!-- Активные фильтры -->
        @if($search || $categoryId || $tagId)
        <div class="flex flex-wrap gap-2 pt-2 border-t border-zinc-950">
            @if($search)
                <span class="text-[10px] font-mono bg-red-950/40 text-red-400 px-2 py-1 rounded-xs border border-red-900/30">
                    Поиск: "{{ $search }}"
                </span>
            @endif
            @if($categoryId)
                @php $cat = $categories->firstWhere('id', $categoryId); @endphp
                <span class="text-[10px] font-mono bg-zinc-950 text-zinc-400 px-2 py-1 rounded-xs border border-zinc-800">
                    Категория: {{ $cat?->name }}
                </span>
            @endif
            @if($tagId)
                @php $tag = $tags->firstWhere('id', $tagId); @endphp
                <span class="text-[10px] font-mono bg-zinc-950 text-zinc-400 px-2 py-1 rounded-xs border border-zinc-800">
                    Тег: {{ $tag?->name }}
                </span>
            @endif
        </div>
        @endif
    </div>

    <!-- Результат поиска -->
    @if($search || $categoryId || $tagId)
    <div class="font-mono text-xs text-zinc-500">
        Найдено постов: <span class="text-red-400 font-bold">{{ $posts->total() }}</span>
    </div>
    @endif

    <!-- Список постов -->
    @if($posts->isEmpty())
        <div class="text-center py-16 border border-zinc-900 bg-zinc-900/20 rounded-sm">
            <p class="text-xs font-mono uppercase tracking-widest text-zinc-500">
                // Посты не найдены. Попробуйте изменить фильтры.
            </p>
        </div>
    @else
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($posts as $post)
                <article class="flex flex-col justify-between p-6 bg-zinc-900 border border-zinc-800/80 hover:border-red-900/40 rounded-sm shadow-md hover:shadow-red-950/20 transition-all duration-300 group">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between font-mono text-[10px] text-zinc-500 uppercase tracking-wider">
                            <span>[ {{ $post->category?->name ?? 'Без категории' }} ]</span>
                            <span>{{ $post->created_at->format('d.m.Y') }}</span>
                        </div>

                        <h2 class="text-base font-bold font-mono text-zinc-100 group-hover:text-red-500 transition-colors uppercase leading-snug">
                            <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                        </h2>

                        <div class="flex flex-wrap gap-1.5 items-center text-[10px] font-mono text-zinc-400">
                            <span class="text-zinc-500">Автор:</span> {{ $post->user?->name ?? 'Аноним' }}
                        </div>

                        <p class="text-xs text-zinc-400 font-sans leading-relaxed line-clamp-3">
                            {{ Str::limit($post->body, 180) }}
                        </p>

                        @if($post->tags->isNotEmpty())
                            <div class="flex flex-wrap gap-1 pt-1">
                                @foreach($post->tags as $tag)
                                    <span class="text-[9px] font-mono bg-zinc-950 px-2 py-0.5 text-zinc-500 border border-zinc-900 rounded-xs">
                                        #{{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="pt-5 border-t border-zinc-950 mt-5 flex items-center justify-between">
                        <span class="text-[10px] font-mono text-zinc-600 uppercase tracking-widest group-hover:text-zinc-400 transition-colors">
                            // ID: {{ str_pad($post->id, 4, '0', STR_PAD_LEFT) }}
                        </span>

                        <div class="flex items-center gap-3">
                            @auth
                                @if(auth()->id() === $post->user_id || (auth()->user()->is_admin ?? false))
                                    <a href="{{ route('posts.edit', $post) }}"
                                       class="text-[10px] font-mono font-bold text-yellow-500 hover:text-yellow-400 transition-colors uppercase tracking-wider">
                                        [ Править ]
                                    </a>
                                @endif
                            @endauth

                            <a href="{{ route('posts.show', $post) }}"
                               class="text-xs font-mono font-bold text-red-500 hover:text-red-400 transition-colors uppercase tracking-wider">
                                [ Читать ]
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <!-- Пагинация -->
        <div class="mt-10 pt-4 border-t border-zinc-900 font-mono text-xs [&_nav]:bg-transparent [&_a]:!bg-zinc-900 [&_a]:!border-zinc-800 [&_a]:!text-zinc-400 [&_span]:!bg-zinc-950 [&_span]:!border-zinc-800 [&_span]:!text-red-500">
            {{ $posts->links() }}
        </div>
    @endif
</div>
