<header class="border-b border-red-950/40 bg-zinc-900/50 backdrop-blur-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
        <a href="/" class="text-lg font-mono font-bold tracking-wider text-red-600 hover:text-red-500 transition-colors uppercase">
            Game App<span class="text-zinc-500">.</span>
        </a>
        <nav class="flex items-center gap-6 font-mono text-sm">
            <a href="{{route('posts.index')}}" class="!text-zinc-300 hover:!text-red-500 font-bold transition-colors">
                Посты
            </a>

            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="!text-zinc-400 hover:!text-red-500 transition-colors">
                        [ Личный кабинет ]
                    </a>
                @else
                    <a href="{{ route('login') }}" class="!text-zinc-400 hover:!text-red-500 transition-colors">
                        Войти
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-3 py-1.5 border border-red-900/60 bg-red-950/30 text-red-400 hover:bg-red-600 hover:text-white transition-all rounded-sm">
                            Регистрация
                        </a>
                    @endif
                @endauth
            @endif
        </nav>
    </div>
</header>
