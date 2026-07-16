<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $seo['title'] ?? $post->title }}</title>
    <meta name="description" content="{{ $seo['description'] ?? '' }}">
    
    <!-- Open Graph -->
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $seo['title'] ?? $post->title }}">
    <meta property="og:description" content="{{ $seo['description'] ?? '' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $seo['title'] ?? $post->title }}">
    <meta name="twitter:description" content="{{ $seo['description'] ?? '' }}">

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-zinc-950 text-zinc-100 min-h-screen flex flex-col justify-between selection:bg-red-600 selection:text-white">

@include('partials.header')

<main class="flex-grow max-w-4xl mx-auto px-6 py-12 w-full space-y-10 relative overflow-hidden">
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[500px] h-[500px] bg-red-600/5 blur-[120px] rounded-full pointer-events-none"></div>

    <div class="relative z-10 font-mono text-xs">
        <a href="{{ route('posts.index') }}" class="text-zinc-500 hover:text-red-400 transition-colors uppercase tracking-wider">
            [ ← Вернуться к ленте ]
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-950/40 border border-emerald-900/50 text-emerald-400 rounded-sm font-mono text-xs relative z-10">
            // Системный лог: {{ session('success') }}
        </div>
    @endif

    <header class="space-y-4 border-b border-zinc-900 pb-6 relative z-10">
        <div class="flex flex-wrap items-center justify-between gap-2 font-mono text-xs text-zinc-500 uppercase tracking-wider">
            <div class="flex items-center gap-2">
                <span>[ {{ $post->category?->name ?? 'Без категории' }} ]</span>
                <span class="text-zinc-700">•</span>
                <span>Автор: {{ $post->user?->name ?? 'Аноним' }}</span>
            </div>
            <span>{{ $post->created_at->format('d.m.Y H:i') }}</span>
        </div>

        <h1 class="text-2xl md:text-3xl font-extrabold font-mono text-zinc-100 uppercase tracking-wide leading-tight">
            {{ $post->title }}
        </h1>

        <!-- Избранное -->
        @auth
            @livewire('toggle-bookmark', ['post' => $post])
        @endauth

        <!-- Реакции -->
        @auth
            @livewire('toggle-reaction', ['post' => $post])
        @endauth

        @if($post->tags->isNotEmpty())
            <div class="flex flex-wrap gap-2 pt-1">
                @foreach($post->tags as $tag)
                    <span class="text-[10px] font-mono bg-zinc-900 border border-zinc-800/80 px-2.5 py-0.5 text-zinc-400 rounded-xs">
                        #{{ $tag->name }}
                    </span>
                @endforeach
            </div>
        @endif
    </header>

    <article class="relative z-10 prose prose-invert max-w-none font-sans text-sm md:text-base text-zinc-300 leading-relaxed space-y-6">
        {!! nl2br(e($post->body)) !!}
    </article>

    @auth
        @if(auth()->id() === $post->user_id || (auth()->user()->is_admin ?? false))
            <div class="border-t border-zinc-900 pt-6 flex items-center justify-end gap-4 font-mono text-xs relative z-10">
                <!-- Кнопка Редактирования -->
                <a href="{{ route('posts.edit', $post) }}"
                   class="text-yellow-500 hover:text-yellow-400 uppercase tracking-wider transition-colors">
                    [ Редактировать пост ]
                </a>

                <span class="text-zinc-700">|</span>

                <form method="POST" action="{{ route('posts.destroy', $post) }}" onsubmit="return confirm('Ликвидировать этот материал безвозвратно?');" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-zinc-500 hover:text-red-500 uppercase tracking-wider transition-colors cursor-pointer bg-transparent border-none">
                        [ Уничтожить пост ]
                    </button>
                </form>
            </div>
        @endif
    @endauth

    <section class="border-t border-zinc-900 pt-10 space-y-6 relative z-10">
        <div class="space-y-1">
            <h2 class="text-sm font-bold font-mono uppercase tracking-wide text-zinc-100">// Канал комментариев</h2>
            <p class="text-xs text-zinc-500 font-sans">Обсуждение публикации авторизованными пользователями платформы.</p>
        </div>

        <div class="space-y-4">
            @if($post->comments && $post->comments->isNotEmpty())
                @foreach($post->comments as $comment)
                    <div class="p-4 bg-zinc-900 border border-zinc-800/60 rounded-sm space-y-2 group/item">
                        <div class="flex items-center justify-between font-mono text-[10px] text-zinc-500 uppercase">
                            <div class="flex items-center gap-2">
                                <span class="text-red-400 font-bold">{{ $comment->user?->name ?? 'Аноним' }}</span>
                                <span class="text-zinc-700">•</span>
                                <span>{{ $comment->created_at->format('d.m.Y H:i') }}</span>
                            </div>

                            @auth
                                @if(auth()->id() === $comment->user_id)
                                    <form method="POST" action="{{ route('comments.destroy', $comment) }}" onsubmit="return confirm('Удалить ваше сообщение?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="opacity-0 group-hover/item:opacity-100 text-zinc-600 hover:text-red-500 transition-all cursor-pointer bg-transparent border-none uppercase text-[9px] font-mono tracking-wider">
                                            [ Удалить ]
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                        <p class="text-xs text-zinc-300 font-sans leading-relaxed">
                            {{ $comment->content }}
                        </p>
                    </div>
                @endforeach
            @else
                <div class="p-4 bg-zinc-900/30 border border-zinc-900 rounded-sm text-center">
                    <p class="text-xs font-mono uppercase tracking-widest text-zinc-600">// Запись логов пуста. Нет активных обсуждений.</p>
                </div>
            @endif
        </div>

        @auth
            <div class="pt-2">
                <form action="{{ route('comments.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                    <div class="flex flex-col gap-2">
                        <label class="text-[10px] font-mono text-zinc-400 uppercase tracking-wider">// Оставить сообщение</label>
                        <textarea
                            name="content"
                            rows="3"
                            placeholder="Введите текст вашего сообщения..."
                            class="w-full bg-zinc-950 border border-zinc-800 rounded-sm p-3 text-xs text-zinc-100 placeholder-zinc-600 focus:outline-none focus:border-red-600 focus:ring-2 focus:ring-red-600/20 resize-none @error('content') border-red-600 @enderror"
                            required
                        >{{ old('content') }}</textarea>

                        @error('content')
                        <span class="text-[10px] font-mono text-red-500">// Ошибка: {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex justify-end">
                        <button
                            type="submit"
                            class="px-5 py-2 bg-red-700 hover:bg-red-600 text-white font-mono uppercase font-bold text-xs tracking-wider rounded-sm shadow-md shadow-red-950/60 transition-all active:scale-[0.98] cursor-pointer"
                        >
                            Отправить в терминал
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="text-center py-4 border border-dashed border-zinc-900 rounded-sm">
                <p class="text-xs font-mono text-zinc-500">
                    Чтобы принять участие в обсуждении, необходимо <a href="{{ route('login') }}" class="text-red-500 hover:underline font-bold">Войти</a> в аккаунт.
                </p>
            </div>
        @endauth
    </section>

    @if($similarPosts->isNotEmpty())
        <section class="border-t border-zinc-900 pt-10 space-y-6 relative z-10">
            <div class="space-y-1">
                <h2 class="text-sm font-bold font-mono uppercase tracking-wide text-zinc-100">// Похожие публикации</h2>
                <p class="text-xs text-zinc-500 font-sans">Другие материалы по этой теме.</p>
            </div>

            <div class="grid gap-4 md:grid-cols-3">
                @foreach($similarPosts as $similar)
                    <div class="p-4 bg-zinc-900 border border-zinc-800/60 rounded-sm hover:border-red-900/40 transition-all group">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between font-mono text-[10px] text-zinc-500 uppercase">
                                <span>[ {{ $similar->category?->name ?? 'Без категории' }} ]</span>
                                <span>{{ $similar->created_at->format('d.m.Y') }}</span>
                            </div>

                            <h3 class="text-xs font-bold font-mono text-zinc-100 group-hover:text-red-500 transition-colors uppercase leading-snug">
                                <a href="{{ route('posts.show', $similar) }}">{{ $similar->title }}</a>
                            </h3>

                            <p class="text-[10px] text-zinc-400 font-sans line-clamp-2">
                                {{ Str::limit($similar->body, 100) }}
                            </p>

                            <div class="pt-2 border-t border-zinc-950">
                                <a href="{{ route('posts.show', $similar) }}"
                                   class="text-[10px] font-mono font-bold text-red-500 hover:text-red-400 transition-colors uppercase tracking-wider">
                                    [ Читать ]
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</main>

@include('partials.footer')

</body>
</html>
