<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ __('Welcome') }} - {{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-zinc-950 text-zinc-100 min-h-screen flex flex-col justify-between selection:bg-red-600 selection:text-white">

@include('partials.header')

<main class="flex-grow">

    {{-- Hero Section --}}
    <section class="relative overflow-hidden">
        {{-- Background effects --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[600px] bg-red-600/[0.07] blur-[160px] rounded-full"></div>
            <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-red-900/[0.04] blur-[120px] rounded-full"></div>
            {{-- Grid pattern --}}
            <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:64px_64px]"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 pt-20 pb-16 relative z-10">
            <div class="max-w-3xl mx-auto text-center space-y-8">
                {{-- Badge --}}
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-red-950/40 border border-red-900/30 rounded-full">
                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span>
                    <span class="text-[11px] font-mono text-red-400 uppercase tracking-wider">Платформа активна</span>
                </div>

                {{-- Heading --}}
                <div class="space-y-4">
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold font-mono tracking-tight uppercase leading-[0.9]">
                        <span class="text-zinc-100">Игровой</span>
                        <br>
                        <span class="bg-gradient-to-r from-red-500 via-red-400 to-red-600 bg-clip-text text-transparent">Блог</span>
                    </h1>
                    <p class="text-zinc-400 font-sans leading-relaxed text-lg max-w-md mx-auto">
                        Честные обзоры, инсайды и разборы игровых механик без цензуры.
                    </p>
                </div>

                {{-- CTA Buttons --}}
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-2">
                    <a href="{{ route('posts.index') }}" class="inline-flex items-center gap-3 px-8 py-3.5 bg-red-700 hover:bg-red-600 text-white font-mono uppercase font-bold text-sm tracking-wider rounded-sm shadow-lg shadow-red-950/50 hover:shadow-red-600/30 active:scale-[0.98] transition-all group">
                        Перейти к постам
                        <svg viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 group-hover:translate-x-1 transition-transform">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-3.5 border border-zinc-700 hover:border-red-900/60 bg-zinc-900/50 hover:bg-red-950/30 text-zinc-300 hover:text-red-400 font-mono uppercase font-bold text-sm tracking-wider rounded-sm transition-all">
                            Регистрация
                        </a>
                    @endguest
                </div>
            </div>
        </div>

        {{-- Stats bar --}}
        <div class="border-t border-zinc-800/60 bg-zinc-900/30 backdrop-blur-sm">
            <div class="max-w-5xl mx-auto px-6 py-6">
                <div class="grid grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="text-2xl md:text-3xl font-extrabold font-mono text-red-500">{{ number_format($stats['posts']) }}</div>
                        <div class="text-[10px] font-mono text-zinc-500 uppercase tracking-widest mt-1">Публикаций</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl md:text-3xl font-extrabold font-mono text-zinc-300">{{ number_format($stats['users']) }}</div>
                        <div class="text-[10px] font-mono text-zinc-500 uppercase tracking-widest mt-1">Пользователей</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl md:text-3xl font-extrabold font-mono text-amber-500">{{ number_format($stats['comments']) }}</div>
                        <div class="text-[10px] font-mono text-zinc-500 uppercase tracking-widest mt-1">Комментариев</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-6 py-16 space-y-20">

        {{-- Popular Posts --}}
        @if($popularPosts->isNotEmpty())
            <section>
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <p class="text-[10px] font-mono tracking-widest text-red-500 uppercase font-bold mb-1">// Топ публикации</p>
                        <h2 class="text-2xl font-extrabold font-mono uppercase tracking-wide text-zinc-100">Популярные посты</h2>
                    </div>
                    <a href="{{ route('posts.index') }}" class="hidden sm:inline-flex items-center gap-1.5 text-xs font-mono text-zinc-500 hover:text-red-400 transition-colors uppercase tracking-wider">
                        Все посты
                        <svg viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>

                <div class="grid gap-5 md:grid-cols-3">
                    @foreach($popularPosts as $post)
                        <a href="{{ route('posts.show', $post) }}" class="group relative flex flex-col p-6 bg-zinc-900 border border-zinc-800/80 hover:border-red-900/40 rounded-sm transition-all duration-300 hover:shadow-lg hover:shadow-red-950/10">
                            {{-- Top row: category + likes --}}
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-[10px] font-mono text-zinc-500 uppercase tracking-wider bg-zinc-950 px-2.5 py-1 rounded-xs border border-zinc-800/60">
                                    {{ $post->category?->name ?? 'Без категории' }}
                                </span>
                                <span class="flex items-center gap-1 text-[10px] font-mono text-red-400">
                                    <svg viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3"><path d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 016 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75 2.25 2.25 0 012.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23h-.777zM2.331 10.727a.75.75 0 00.564.938A23.648 23.648 0 0012 15.75c2.239 0 4.424-.387 6.438-1.085a.75.75 0 00.565-.938A15.795 15.795 0 0012 12a15.795 15.795 0 00-9.669-1.273z"/></svg>
                                    {{ $post->reactions_count }}
                                </span>
                            </div>

                            {{-- Title --}}
                            <h3 class="text-base font-bold font-mono text-zinc-100 group-hover:text-red-500 transition-colors uppercase leading-snug mb-3 line-clamp-2">
                                {{ $post->title }}
                            </h3>

                            {{-- Description --}}
                            <p class="text-xs text-zinc-500 font-sans leading-relaxed line-clamp-2 mb-4">
                                {{ $post->description ?? Str::limit(strip_tags($post->body), 120) }}
                            </p>

                            {{-- Bottom row --}}
                            <div class="mt-auto pt-4 border-t border-zinc-800/60 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-5 h-5 bg-zinc-800 rounded-full flex items-center justify-center text-[8px] font-mono font-bold text-zinc-400">
                                        {{ $post->user?->initials() ?? '?' }}
                                    </div>
                                    <span class="text-[10px] font-mono text-zinc-500">{{ $post->user?->name ?? 'Аноним' }}</span>
                                </div>
                                <div class="flex items-center gap-3 text-[10px] font-mono text-zinc-600">
                                    <span class="flex items-center gap-1">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-3 h-3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 01-.923 1.785A5.969 5.969 0 006 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337z"/></svg>
                                        {{ $post->comments_count }}
                                    </span>
                                    <span>{{ $post->created_at->format('d.m') }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- Latest Posts --}}
        @if($latestPosts->isNotEmpty())
            <section>
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <p class="text-[10px] font-mono tracking-widest text-zinc-500 uppercase font-bold mb-1">// Свежее</p>
                        <h2 class="text-2xl font-extrabold font-mono uppercase tracking-wide text-zinc-100">Последние публикации</h2>
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    @foreach($latestPosts as $post)
                        <a href="{{ route('posts.show', $post) }}" class="group flex items-start gap-4 p-5 bg-zinc-900/50 border border-zinc-800/60 hover:border-zinc-700 rounded-sm transition-all duration-200">
                            {{-- Number --}}
                            <span class="text-3xl font-extrabold font-mono text-zinc-800 group-hover:text-red-900/60 transition-colors leading-none select-none">
                                {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                            </span>

                            <div class="flex-1 min-w-0 space-y-1.5">
                                <div class="flex items-center gap-2 text-[10px] font-mono text-zinc-500 uppercase tracking-wider">
                                    <span class="text-zinc-600">{{ $post->category?->name ?? '—' }}</span>
                                    <span class="text-zinc-700">·</span>
                                    <span>{{ $post->created_at->format('d.m.Y') }}</span>
                                </div>
                                <h3 class="text-sm font-bold font-mono text-zinc-200 group-hover:text-red-400 transition-colors uppercase leading-snug line-clamp-1">
                                    {{ $post->title }}
                                </h3>
                                <p class="text-xs text-zinc-500 font-sans line-clamp-1">
                                    {{ $post->description ?? Str::limit(strip_tags($post->body), 100) }}
                                </p>
                            </div>

                            {{-- Stats --}}
                            <div class="flex flex-col items-end gap-1 text-[10px] font-mono text-zinc-600 shrink-0">
                                <span class="flex items-center gap-1">
                                    <svg viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3 text-red-900"><path d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 016 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75 2.25 2.25 0 012.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23h-.777zM2.331 10.727a.75.75 0 00.564.938A23.648 23.648 0 0012 15.75c2.239 0 4.424-.387 6.438-1.085a.75.75 0 00.565-.938A15.795 15.795 0 0012 12a15.795 15.795 0 00-9.669-1.273z"/></svg>
                                    {{ $post->reactions_count }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-3 h-3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 01-.923 1.785A5.969 5.969 0 006 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337z"/></svg>
                                    {{ $post->comments_count }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-3 h-3"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ number_format($post->views) }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- Tags --}}
        @if($popularTags->isNotEmpty())
            <section>
                <div class="text-center mb-8">
                    <p class="text-[10px] font-mono tracking-widest text-zinc-500 uppercase font-bold mb-1">// Навигация по темам</p>
                    <h2 class="text-2xl font-extrabold font-mono uppercase tracking-wide text-zinc-100">Популярные теги</h2>
                </div>

                <div class="flex flex-wrap justify-center gap-2.5 max-w-3xl mx-auto">
                    @foreach($popularTags as $tag)
                        <a href="{{ route('posts.index', ['tag_id' => $tag->id]) }}"
                           class="group inline-flex items-center gap-2 px-4 py-2.5 bg-zinc-900/50 border border-zinc-800/60 hover:border-red-900/40 hover:bg-red-950/20 rounded-sm transition-all duration-200">
                            <span class="text-xs font-mono text-zinc-500 group-hover:text-red-400 transition-colors">#</span>
                            <span class="text-xs font-mono text-zinc-300 group-hover:text-red-300 transition-colors uppercase">{{ $tag->name }}</span>
                            <span class="text-[9px] font-mono text-zinc-700 group-hover:text-red-800 transition-colors">({{ $tag->posts_count }})</span>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- CTA for guests --}}
        @guest
            <section class="relative overflow-hidden">
                <div class="absolute inset-0 pointer-events-none">
                    <div class="absolute inset-0 bg-gradient-to-r from-red-950/20 via-red-900/10 to-red-950/20 rounded-sm"></div>
                </div>
                <div class="relative z-10 text-center py-12 px-6 border border-red-900/20 rounded-sm">
                    <p class="text-[10px] font-mono tracking-widest text-red-500 uppercase font-bold mb-3">// Присоединяйтесь</p>
                    <h2 class="text-2xl font-extrabold font-mono uppercase tracking-wide text-zinc-100 mb-3">
                        Начните писать
                    </h2>
                    <p class="text-sm text-zinc-400 font-sans mb-6 max-w-md mx-auto">
                        Создайте аккаунт, чтобы публиковать посты, комментировать и ставить реакции.
                    </p>
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-3.5 bg-red-700 hover:bg-red-600 text-white font-mono uppercase font-bold text-sm tracking-wider rounded-sm shadow-lg shadow-red-950/50 hover:shadow-red-600/30 active:scale-[0.98] transition-all">
                        Зарегистрироваться
                    </a>
                </div>
            </section>
        @endguest
    </div>
</main>

@include('partials.footer')

</body>
</html>
