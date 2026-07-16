<header class="border-b border-red-950/40 bg-zinc-900/50 backdrop-blur-md sticky top-0 z-50">
    <!-- Добавлен класс relative для точного выравнивания элементов по центру -->
    <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between relative">

        <!-- ЛЕВАЯ ЧАСТЬ: Логотип / Название -->
        <a href="/" class="text-lg font-mono font-bold tracking-wider text-red-600 hover:text-red-500 transition-colors uppercase z-10">
            Game App<span class="text-zinc-500">.</span>
        </a>

        <!-- ЦЕНТРАЛЬНАЯ ЧАСТЬ: Кнопка Посты (Идеальное центрирование по оси X) -->
        <div class="absolute left-1/2 -translate-x-1/2 z-10">
            <a href="{{route('posts.index')}}" class="!text-zinc-200 hover:!text-red-500 font-mono text-sm uppercase tracking-wider font-bold transition-colors">
                Посты
            </a>
        </div>

        <!-- ПРАВАЯ ЧАСТЬ: Навигация (Авторизация) без повторов -->
        <nav class="flex items-center gap-6 font-mono text-sm z-10">
            @if (Route::has('login'))
                @auth
                    <a href="{{ route('profile') }}" class="text-zinc-400 hover:text-red-500 transition-colors">
                        [ Профиль ]
                    </a>
                    <a href="{{ url('/dashboard') }}" class="text-zinc-400 hover:text-red-500 transition-colors">
                        [ ЛК ]
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-zinc-400 hover:text-red-500 transition-colors">
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
