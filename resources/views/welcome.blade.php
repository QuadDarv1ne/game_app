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

<main class="flex-grow flex items-center justify-center px-6 relative overflow-hidden">
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-red-600/5 blur-[120px] rounded-full pointer-events-none"></div>

    <div class="max-w-2xl text-center relative z-10 space-y-8">
        <div class="space-y-3">
            <p class="text-xs font-mono tracking-widest text-red-600 uppercase font-bold">// Добро пожаловать в {{config('app.name')}}</p>
            <h1 class="text-4xl md:text-5xl font-extrabold font-mono tracking-tight uppercase text-zinc-100">
                Игровой блог
            </h1>
        </div>

        <p class="text-zinc-400 font-sans leading-relaxed text-base max-w-lg mx-auto">
            Честные обзоры, инсайды и разборы игровых механик без цензуры.
        </p>

        <div class="pt-4">
            <a href="/posts" class="inline-flex items-center gap-3 px-8 py-4 bg-red-700 hover:bg-red-600 text-white font-mono uppercase font-bold tracking-wider rounded-sm shadow-lg shadow-red-950/50 hover:shadow-red-600/20 active:scale-[0.98] transition-all group">
                Перейти к постам
                <svg viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 transform group-hover:translate-x-1 transition-transform">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
            </a>
        </div>
    </div>

    @if($popularPosts->isNotEmpty())
        <section class="max-w-4xl mx-auto mt-16 relative z-10">
            <div class="space-y-4">
                <div class="text-center space-y-2">
                    <p class="text-xs font-mono tracking-widest text-red-500 uppercase font-bold">// Топ публикации</p>
                    <h2 class="text-xl font-bold font-mono uppercase tracking-wide text-zinc-100">Популярные посты</h2>
                </div>

                <div class="grid gap-4 md:grid-cols-3">
                    @foreach($popularPosts as $post)
                        <div class="p-5 bg-zinc-900 border border-zinc-800/80 hover:border-red-900/40 rounded-sm transition-all group">
                            <div class="space-y-3">
                                <div class="flex items-center justify-between font-mono text-[10px] text-zinc-500 uppercase">
                                    <span>[ {{ $post->category?->name ?? 'Без категории' }} ]</span>
                                    <span class="text-red-500">👍 {{ $post->reactions_count }}</span>
                                </div>

                                <h3 class="text-sm font-bold font-mono text-zinc-100 group-hover:text-red-500 transition-colors uppercase leading-snug">
                                    <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                                </h3>

                                <div class="flex items-center gap-2 text-[10px] font-mono text-zinc-400">
                                    <span class="text-zinc-500">Автор:</span> {{ $post->user?->name ?? 'Аноним' }}
                                </div>

                                <div class="pt-3 border-t border-zinc-950">
                                    <a href="{{ route('posts.show', $post) }}"
                                       class="text-[10px] font-mono font-bold text-red-500 hover:text-red-400 transition-colors uppercase tracking-wider">
                                        [ Читать ]
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if($popularTags->isNotEmpty())
        <section class="max-w-4xl mx-auto mt-12 relative z-10">
            <div class="text-center space-y-4">
                <p class="text-xs font-mono tracking-widest text-zinc-500 uppercase font-bold">// Темы</p>
                <div class="flex flex-wrap justify-center gap-2">
                    @foreach($popularTags as $tag)
                        <a href="/posts?tag_id={{ $tag->id }}"
                           class="px-4 py-2 bg-zinc-900 border border-zinc-800/80 hover:border-red-900/40 rounded-sm text-xs font-mono text-zinc-400 hover:text-red-400 transition-all uppercase">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</main>

@include('partials.footer')

</body>
</html>
