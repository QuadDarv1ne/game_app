<header class="border-b border-zinc-800/60 bg-zinc-950/80 backdrop-blur-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 h-14 flex items-center justify-between">

        {{-- Logo --}}
        <a href="/" class="flex items-center gap-2.5 text-lg font-mono font-bold tracking-wider text-red-600 hover:text-red-500 transition-colors uppercase">
            <span class="flex items-center justify-center w-7 h-7 bg-red-700 rounded-sm text-white text-xs font-mono font-black">
                G
            </span>
            Game<span class="text-zinc-500">.</span>
        </a>

        {{-- Center nav --}}
        <nav class="hidden sm:flex items-center gap-1 font-mono text-xs uppercase tracking-wider">
            <a href="{{ route('posts.index') }}" class="px-3 py-1.5 text-zinc-400 hover:text-red-400 hover:bg-zinc-900 rounded-sm transition-all font-bold">
                Посты
            </a>
            @auth
                <a href="{{ route('posts.create') }}" class="px-3 py-1.5 text-zinc-400 hover:text-red-400 hover:bg-zinc-900 rounded-sm transition-all font-bold">
                    Создать
                </a>
            @endauth
        </nav>

        {{-- Right side --}}
        <nav class="flex items-center gap-3 font-mono text-xs">
            @auth
                @livewire('notifications-panel')

                <a href="{{ route('profile') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 text-zinc-400 hover:text-red-400 hover:bg-zinc-900 rounded-sm transition-all uppercase tracking-wider">
                    Профиль
                </a>
                <a href="{{ url('/dashboard') }}" class="px-3 py-1.5 bg-zinc-900 border border-zinc-800 hover:border-red-900/40 text-zinc-300 hover:text-red-400 rounded-sm transition-all uppercase tracking-wider font-bold">
                    ЛК
                </a>
            @else
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="px-3 py-1.5 text-zinc-400 hover:text-red-400 transition-colors uppercase tracking-wider">
                        Войти
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-3 py-1.5 border border-red-900/60 bg-red-950/30 text-red-400 hover:bg-red-600 hover:text-white hover:border-red-600 transition-all rounded-sm uppercase tracking-wider font-bold">
                            Регистрация
                        </a>
                    @endif
                @endif
            @endauth
        </nav>

        {{-- Mobile nav --}}
        <nav class="sm:hidden flex items-center gap-2 font-mono text-xs">
            <a href="{{ route('posts.index') }}" class="px-2 py-1.5 text-zinc-400 hover:text-red-400 transition-colors font-bold">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/></svg>
            </a>
        </nav>
    </div>
</header>
