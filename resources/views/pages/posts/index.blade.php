<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Лента публикаций - {{ config('app.name', 'GameApp') }}</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-zinc-950 text-zinc-100 min-h-screen flex flex-col justify-between selection:bg-red-600 selection:text-white">

@include('partials.header')

<main class="flex-grow max-w-7xl mx-auto px-6 py-12 w-full space-y-10 relative overflow-hidden">
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-red-600/5 blur-[150px] rounded-full pointer-events-none"></div>

    <div class="border-b border-zinc-900 pb-6 relative z-10 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <div class="space-y-1">
            <p class="text-xs font-mono tracking-widest text-red-500 uppercase font-bold">// Терминал публикаций</p>
            <h1 class="text-2xl font-extrabold font-mono uppercase tracking-wide text-zinc-100">Лента материалов</h1>
        </div>

        @auth
            <a href="{{ route('posts.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-red-700 hover:bg-red-600 text-white font-mono uppercase font-bold text-xs tracking-wider rounded-sm shadow-md shadow-red-950/50 transition-all active:scale-[0.98]">
                [ + Создать пост ]
            </a>
        @endauth
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-950/40 border border-emerald-900/50 text-emerald-400 rounded-sm font-mono text-xs max-w-xl">
            // Системный лог: {{ session('success') }}
        </div>
    @endif

    <!-- Поиск и фильтры -->
    <div class="p-5 bg-zinc-900 border border-zinc-800/80 rounded-sm space-y-4 relative z-10">
        <div class="flex items-center justify-between">
            <h2 class="text-xs font-mono font-bold uppercase tracking-widest text-zinc-300">
                // Фильтры и поиск
            </h2>
            <a href="{{ route('posts.index') }}" 
               class="text-[10px] font-mono text-zinc-500 hover:text-red-400 uppercase tracking-wider transition-colors">
                [ Сбросить ]
            </a>
        </div>

        <form action="{{ route('posts.index') }}" method="GET" class="space-y-4">
            <!-- Поиск -->
            <div class="relative">
                <input 
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Поиск по заголовку, тексту или описанию..."
                    class="w-full bg-zinc-950 border border-zinc-800 rounded-sm p-3 text-xs text-zinc-100 placeholder-zinc-600 focus:outline-none focus:border-red-600 focus:ring-2 focus:ring-red-600/20 transition-all font-mono"
                >
                @if(request('search'))
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] font-mono text-red-500">●</span>
                @endif
            </div>

            <!-- Фильтры -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <!-- Категория -->
                <div class="space-y-1.5">
                    <label class="text-[9px] font-mono text-zinc-500 uppercase tracking-wider">Категория</label>
                    <select name="category_id" class="w-full bg-zinc-950 border border-zinc-800 rounded-sm p-2.5 text-xs text-zinc-100 focus:outline-none focus:border-red-600 transition-all font-mono">
                        <option value="">Все категории</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Тег -->
                <div class="space-y-1.5">
                    <label class="text-[9px] font-mono text-zinc-500 uppercase tracking-wider">Тег</label>
                    <select name="tag_id" class="w-full bg-zinc-950 border border-zinc-800 rounded-sm p-2.5 text-xs text-zinc-100 focus:outline-none focus:border-red-600 transition-all font-mono">
                        <option value="">Все теги</option>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}" {{ request('tag_id') == $tag->id ? 'selected' : '' }}>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Сортировка -->
                <div class="space-y-1.5">
                    <label class="text-[9px] font-mono text-zinc-500 uppercase tracking-wider">Сортировка</label>
                    <select name="sort" class="w-full bg-zinc-950 border border-zinc-800 rounded-sm p-2.5 text-xs text-zinc-100 focus:outline-none focus:border-red-600 transition-all font-mono">
                        <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Сначала новые</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Популярные</option>
                        <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>По алфавиту</option>
                    </select>
                </div>
            </div>

            <!-- Кнопка поиска -->
            <div class="flex justify-end pt-2">
                <button type="submit" class="px-5 py-2 bg-red-700 hover:bg-red-600 text-white font-mono uppercase font-bold text-xs tracking-wider rounded-sm shadow-md shadow-red-950/60 transition-all active:scale-[0.98]">
                    Применить фильтры
                </button>
            </div>
        </form>

        <!-- Активные фильтры -->
        @if(request('search') || request('category_id') || request('tag_id'))
        <div class="flex flex-wrap gap-2 pt-2 border-t border-zinc-950">
            @if(request('search'))
                <span class="text-[10px] font-mono bg-red-950/40 text-red-400 px-2 py-1 rounded-xs border border-red-900/30">
                    Поиск: "{{ request('search') }}"
                </span>
            @endif
            @if(request('category_id'))
                @php $cat = $categories->firstWhere('id', request('category_id')); @endphp
                <span class="text-[10px] font-mono bg-zinc-950 text-zinc-400 px-2 py-1 rounded-xs border border-zinc-800">
                    Категория: {{ $cat?->name }}
                </span>
            @endif
            @if(request('tag_id'))
                @php $tag = $tags->firstWhere('id', request('tag_id')); @endphp
                <span class="text-[10px] font-mono bg-zinc-950 text-zinc-400 px-2 py-1 rounded-xs border border-zinc-800">
                    Тег: {{ $tag?->name }}
                </span>
            @endif
        </div>
        @endif
    </div>

    @if($posts->isEmpty())
        <div class="text-center py-20 relative z-10 border border-zinc-900 bg-zinc-900/20 rounded-sm">
            <p class="text-xs font-mono uppercase tracking-widest text-zinc-500">// Архивы пусты. Ожидание первого материала...</p>
        </div>
    @else
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 relative z-10">
            @foreach($posts->loadCount(['comments', 'reactions']) as $post)
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

                        <!-- Счётчики: комментарии и реакции -->
                        <div class="flex items-center gap-4 pt-1 font-mono text-[10px] text-zinc-500 uppercase tracking-wider">
                            <span class="flex items-center gap-1">
                                <span class="text-zinc-600">💬</span>
                                <span>{{ $post->comments_count ?? 0 }}</span>
                            </span>
                            <span class="flex items-center gap-1">
                                <span class="text-zinc-600">⚡</span>
                                <span>{{ ($post->reactions_count ?? 0) > 0 ? ($post->reactions_count ?? 0) : '0' }}</span>
                            </span>
                        </div>

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
                                @if(auth()->id() === $post->user_id || auth()->user()->is_admin ?? false)
                                    <a href="{{ route('posts.edit', $post) }}"
                                       class="text-[10px] font-mono font-bold text-yellow-500 hover:text-yellow-400 transition-colors uppercase tracking-wider">
                                        [ Редактировать ]
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

        <div class="mt-10 pt-4 border-t border-zinc-900 font-mono text-xs [&_nav]:bg-transparent [&_a]:!bg-zinc-900 [&_a]:!border-zinc-800 [&_a]:!text-zinc-400 [&_span]:!bg-zinc-950 [&_span]:!border-zinc-800 [&_span]:!text-red-500">
            {{ $posts->links() }}
        </div>
    @endif
</main>

@include('partials.footer')

</body>
</html>
