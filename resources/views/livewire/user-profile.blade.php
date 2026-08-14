<div class="space-y-8">
    <!-- Профиль пользователя -->
    <div class="p-6 bg-zinc-900 border border-zinc-800/80 rounded-sm">
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
            <!-- Аватар -->
            <div class="w-20 h-20 bg-gradient-to-br from-red-700 to-red-900 rounded-sm flex items-center justify-center text-2xl font-bold font-mono text-white shadow-lg shadow-red-950/40">
                {{ $user->initials() }}
            </div>

            <div class="flex-1 space-y-2">
                <div class="flex flex-wrap items-center gap-3">
                    <h1 class="text-xl font-bold font-mono text-zinc-100 uppercase tracking-wide">
                        {{ $user->name }}
                    </h1>

                    @if($user->rank)
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-zinc-950 border border-zinc-800 rounded-xs font-mono text-[10px] font-bold uppercase tracking-wider"
                              style="color: {{ $user->rank->color }}">
                            <span class="text-sm leading-none">{{ $user->rank->icon }}</span>
                            {{ $user->rank->name }}
                            <span class="opacity-50">Lv.{{ $user->rank->level }}</span>
                        </span>
                    @endif
                </div>
                <p class="text-xs font-mono text-zinc-500">
                    {{ $user->email }}
                </p>
                <p class="text-[10px] font-mono text-zinc-600 uppercase tracking-wider">
                    На платформе с {{ $user->created_at->format('d.m.Y') }}
                </p>
            </div>
        </div>

        <!-- Прогресс до следующего ранга -->
        @if($rankProgress['next'])
            <div class="mt-6 space-y-2">
                <div class="flex items-center justify-between font-mono text-[10px] text-zinc-500 uppercase tracking-wider">
                    <span>
                        Прогресс до звания
                        <span class="text-zinc-300">{{ $rankProgress['next']->icon }} {{ $rankProgress['next']->name }}</span>
                    </span>
                    <span class="text-zinc-400">{{ $rankProgress['percent'] }}%</span>
                </div>
                <div class="h-1.5 bg-zinc-950 border border-zinc-900/60 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-red-700 to-red-500 transition-all duration-500"
                         style="width: {{ $rankProgress['percent'] }}%"></div>
                </div>
            </div>
        @endif

        <!-- Статистика -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mt-6 pt-6 border-t border-zinc-950">
            <div class="text-center p-3 bg-zinc-950 rounded-sm border border-zinc-900/50">
                <div class="text-lg font-bold font-mono text-red-500">{{ $stats['posts_count'] }}</div>
                <div class="text-[10px] font-mono text-zinc-500 uppercase tracking-wider mt-1">Постов</div>
            </div>
            <div class="text-center p-3 bg-zinc-950 rounded-sm border border-zinc-900/50">
                <div class="text-lg font-bold font-mono text-zinc-300">{{ $stats['comments_count'] }}</div>
                <div class="text-[10px] font-mono text-zinc-500 uppercase tracking-wider mt-1">Комментариев</div>
            </div>
                <div class="text-center p-3 bg-zinc-950 rounded-sm border border-zinc-900/50">
                    <div class="text-lg font-bold font-mono text-amber-500">{{ $stats['bookmarks_count'] }}</div>
                    <div class="text-[10px] font-mono text-zinc-500 uppercase tracking-wider mt-1">Избранного</div>
                </div>
                <div class="text-center p-3 bg-zinc-950 rounded-sm border border-zinc-900/50">
                    <div class="text-lg font-bold font-mono text-green-500">{{ $stats['reactions_count'] ?? 0 }}</div>
                    <div class="text-[10px] font-mono text-zinc-500 uppercase tracking-wider mt-1">Реакций</div>
                </div>
                <div class="text-center p-3 bg-zinc-950 rounded-sm border border-zinc-900/50">
                    <div class="text-lg font-bold font-mono text-blue-500">{{ $user->subscribersCount() }}</div>
                    <div class="text-[10px] font-mono text-zinc-500 uppercase tracking-wider mt-1">Подписчиков</div>
                </div>
            </div>
        </div>

        <!-- Кнопка подписки -->
        @auth
            @if(auth()->id() !== $user->id)
                <div class="mt-6 pt-6 border-t border-zinc-950">
                    @livewire('toggle-subscription', ['user' => $user])
                </div>
            @endif
        @endauth

    <!-- Вкладки -->
    <div class="border-b border-zinc-900">
        <div class="flex gap-1 font-mono text-xs">
            <button 
                wire:click="setActiveTab('posts')"
                class="px-4 py-2.5 uppercase tracking-wider transition-all {{ $activeTab === 'posts' ? 'text-red-500 border-b-2 border-red-500 bg-red-950/20' : 'text-zinc-500 hover:text-zinc-300' }}"
            >
                [ Посты ] <span class="text-zinc-600">({{ $stats['posts_count'] }})</span>
            </button>
            <button 
                wire:click="setActiveTab('bookmarks')"
                class="px-4 py-2.5 uppercase tracking-wider transition-all {{ $activeTab === 'bookmarks' ? 'text-amber-500 border-b-2 border-amber-500 bg-amber-950/20' : 'text-zinc-500 hover:text-zinc-300' }}"
            >
                [ Избранное ] <span class="text-zinc-600">({{ $stats['bookmarks_count'] }})</span>
            </button>
            <button 
                wire:click="setActiveTab('reactions')"
                class="px-4 py-2.5 uppercase tracking-wider transition-all {{ $activeTab === 'reactions' ? 'text-green-500 border-b-2 border-green-500 bg-green-950/20' : 'text-zinc-500 hover:text-zinc-300' }}"
            >
                [ Реакции ] <span class="text-zinc-600">({{ $stats['reactions_count'] ?? 0 }})</span>
            </button>
            <button 
                wire:click="setActiveTab('achievements')"
                class="px-4 py-2.5 uppercase tracking-wider transition-all {{ $activeTab === 'achievements' ? 'text-purple-500 border-b-2 border-purple-500 bg-purple-950/20' : 'text-zinc-500 hover:text-zinc-300' }}"
            >
                [ Достижения ] <span class="text-zinc-600">({{ $user->achievements()->count() }})</span>
            </button>
        </div>
    </div>

    <!-- Содержимое вкладок -->
    @if($activeTab === 'posts')
        @if($this->posts->isEmpty())
            <div class="text-center py-16 border border-zinc-900 bg-zinc-900/20 rounded-sm">
                <p class="text-xs font-mono uppercase tracking-widest text-zinc-500">
                    // У пользователя пока нет публикаций.
                </p>
            </div>
        @else
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($this->posts as $post)
                    <article class="flex flex-col justify-between p-6 bg-zinc-900 border border-zinc-800/80 hover:border-red-900/40 rounded-sm shadow-md hover:shadow-red-950/20 transition-all duration-300 group">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between font-mono text-[10px] text-zinc-500 uppercase tracking-wider">
                                <span>[ {{ $post->category?->name ?? 'Без категории' }} ]</span>
                                <span>{{ $post->created_at->format('d.m.Y') }}</span>
                            </div>

                            <h2 class="text-base font-bold font-mono text-zinc-100 group-hover:text-red-500 transition-colors uppercase leading-snug">
                                <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                            </h2>

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
                            <span class="text-[10px] font-mono text-zinc-600 uppercase tracking-widest">
                                // {{ $post->comments->count() }} комм.
                            </span>
                            <a href="{{ route('posts.show', $post) }}"
                               class="text-xs font-mono font-bold text-red-500 hover:text-red-400 transition-colors uppercase tracking-wider">
                                [ Читать ]
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-10 pt-4 border-t border-zinc-900 font-mono text-xs [&_nav]:bg-transparent [&_a]:!bg-zinc-900 [&_a]:!border-zinc-800 [&_a]:!text-zinc-400 [&_span]:!bg-zinc-950 [&_span]:!border-zinc-800 [&_span]:!text-red-500">
                {{ $this->posts->links() }}
            </div>
        @endif
    @elseif($activeTab === 'bookmarks')
        @if($this->bookmarks->isEmpty())
            <div class="text-center py-16 border border-zinc-900 bg-zinc-900/20 rounded-sm">
                <p class="text-xs font-mono uppercase tracking-widest text-zinc-500">
                    // В избранном пока пусто. Добавляйте интересные посты!
                </p>
            </div>
        @else
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($this->bookmarks as $bookmark)
                    @php $post = $bookmark->post; @endphp
                    <article class="flex flex-col justify-between p-6 bg-zinc-900 border border-amber-900/20 hover:border-amber-900/40 rounded-sm shadow-md hover:shadow-amber-950/20 transition-all duration-300 group">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between font-mono text-[10px] text-amber-500/60 uppercase tracking-wider">
                                <span>★ В избранном</span>
                                <span>{{ $post->created_at->format('d.m.Y') }}</span>
                            </div>

                            <h2 class="text-base font-bold font-mono text-zinc-100 group-hover:text-amber-500 transition-colors uppercase leading-snug">
                                <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                            </h2>

                            <div class="flex items-center gap-2 text-[10px] font-mono text-zinc-400">
                                <span class="text-zinc-500">Автор:</span> {{ $post->user?->name ?? 'Аноним' }}
                            </div>

                            <p class="text-xs text-zinc-400 font-sans leading-relaxed line-clamp-3">
                                {{ Str::limit($post->body, 180) }}
                            </p>
                        </div>

                        <div class="pt-5 border-t border-zinc-950 mt-5 flex items-center justify-between">
                            <span class="text-[10px] font-mono text-amber-600/60 uppercase tracking-widest">
                                ★ {{ $post->bookmarksCount() }} отметок
                            </span>
                            <a href="{{ route('posts.show', $post) }}"
                               class="text-xs font-mono font-bold text-amber-500 hover:text-amber-400 transition-colors uppercase tracking-wider">
                                [ Читать ]
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-10 pt-4 border-t border-zinc-900 font-mono text-xs [&_nav]:bg-transparent [&_a]:!bg-zinc-900 [&_a]:!border-zinc-800 [&_a]:!text-zinc-400 [&_span]:!bg-zinc-950 [&_span]:!border-zinc-800 [&_span]:!text-amber-500">
                {{ $this->bookmarks->links() }}
            </div>
        @endif
    @elseif($activeTab === 'reactions')
        @if($this->reactions->isEmpty())
            <div class="text-center py-16 border border-zinc-900 bg-zinc-900/20 rounded-sm">
                <p class="text-xs font-mono uppercase tracking-widest text-zinc-500">
                    // Вы ещё не оставили ни одной реакции.
                </p>
            </div>
        @else
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($this->reactions as $reaction)
                    @php $post = $reaction->post; @endphp
                    <article class="flex flex-col justify-between p-6 bg-zinc-900 border border-green-900/20 hover:border-green-900/40 rounded-sm shadow-md hover:shadow-green-950/20 transition-all duration-300 group">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between font-mono text-[10px] text-green-500/60 uppercase tracking-wider">
                                <span>{{ $reaction->isLike() ? '👍 Лайк' : '👎 Дизлайк' }}</span>
                                <span>{{ $reaction->created_at->format('d.m.Y') }}</span>
                            </div>

                            <h2 class="text-base font-bold font-mono text-zinc-100 group-hover:text-green-500 transition-colors uppercase leading-snug">
                                <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                            </h2>

                            <div class="flex items-center gap-2 text-[10px] font-mono text-zinc-400">
                                <span class="text-zinc-500">Автор:</span> {{ $post->user?->name ?? 'Аноним' }}
                            </div>

                            <p class="text-xs text-zinc-400 font-sans leading-relaxed line-clamp-3">
                                {{ Str::limit($post->body, 180) }}
                            </p>
                        </div>

                        <div class="pt-5 border-t border-zinc-950 mt-5 flex items-center justify-between">
                            <span class="text-[10px] font-mono text-green-600/60 uppercase tracking-widest">
                                {{ $post->likesCount() }} 👍 / {{ $post->dislikesCount() }} 👎
                            </span>
                            <a href="{{ route('posts.show', $post) }}"
                               class="text-xs font-mono font-bold text-green-500 hover:text-green-400 transition-colors uppercase tracking-wider">
                                [ Читать ]
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-10 pt-4 border-t border-zinc-900 font-mono text-xs [&_nav]:bg-transparent [&_a]:!bg-zinc-900 [&_a]:!border-zinc-800 [&_a]:!text-zinc-400 [&_span]:!bg-zinc-950 [&_span]:!border-zinc-800 [&_span]:!text-green-500">
                {{ $this->reactions->links() }}
            </div>
        @endif
    @elseif($activeTab === 'achievements')
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($this->achievements as $item)
                @php
                    $achievement = $item['achievement'];
                    $unlocked = $item['unlocked'];
                @endphp
                <div class="p-5 border rounded-sm transition-all duration-300 flex flex-col gap-3
                    {{ $unlocked
                        ? 'bg-purple-950/10 border-purple-900/40 hover:border-purple-700/60'
                        : 'bg-zinc-900/30 border-zinc-900 opacity-45' }}">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl {{ $unlocked ? '' : 'grayscale' }}">{{ $achievement->icon }}</span>
                        <div class="space-y-0.5">
                            <h3 class="text-xs font-bold font-mono text-zinc-100 uppercase tracking-wide">
                                {{ $achievement->name }}
                            </h3>
                            <span class="text-[9px] font-mono uppercase tracking-widest
                                {{ $unlocked ? 'text-purple-400' : 'text-zinc-600' }}">
                                [ {{ $unlocked ? 'Получено' : 'Заблокировано' }} ]
                            </span>
                        </div>
                    </div>
                    <p class="text-[10px] text-zinc-400 font-sans leading-relaxed flex-1">
                        {{ $achievement->description }}
                    </p>
                    @if(! $unlocked)
                        <div class="text-[9px] font-mono text-zinc-600 uppercase tracking-wider border-t border-zinc-950 pt-2">
                            Требуется: {{ $achievement->required_count }} ед.
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
