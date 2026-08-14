<footer class="border-t border-zinc-800/60 bg-zinc-950">
    <div class="max-w-7xl mx-auto px-6 py-10">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 mb-8">
            {{-- Brand --}}
            <div class="space-y-3">
                <a href="/" class="flex items-center gap-2 text-lg font-mono font-bold tracking-wider text-red-600 uppercase">
                    <span class="flex items-center justify-center w-6 h-6 bg-red-700 rounded-sm text-white text-[10px] font-mono font-black">G</span>
                    Game<span class="text-zinc-500">.</span>
                </a>
                <p class="text-xs text-zinc-500 font-sans leading-relaxed">
                    Честные обзоры, инсайды и разборы игровых механик без цензуры.
                </p>
            </div>

            {{-- Links --}}
            <div class="space-y-3">
                <h3 class="text-[10px] font-mono text-zinc-500 uppercase tracking-widest font-bold">Навигация</h3>
                <div class="flex flex-col gap-2">
                    <a href="{{ route('posts.index') }}" class="text-xs font-mono text-zinc-400 hover:text-red-400 transition-colors">Посты</a>
                    <a href="{{ route('home') }}" class="text-xs font-mono text-zinc-400 hover:text-red-400 transition-colors">Главная</a>
                    @guest
                        <a href="{{ route('login') }}" class="text-xs font-mono text-zinc-400 hover:text-red-400 transition-colors">Войти</a>
                    @endguest
                </div>
            </div>

            {{-- Author --}}
            <div class="space-y-3">
                <h3 class="text-[10px] font-mono text-zinc-500 uppercase tracking-widest font-bold">Автор</h3>
                <p class="text-xs font-mono text-zinc-400">Дуплей Максим Игоревич</p>
                <p class="text-[10px] font-mono text-zinc-600">{{ date('Y') }}. Все права защищены.</p>
            </div>
        </div>

        <div class="pt-6 border-t border-zinc-800/40 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-[10px] font-mono text-zinc-600 uppercase tracking-wider">
                &copy; {{ date('Y') }} Game App
            </p>
            <div class="flex items-center gap-1.5 text-[10px] font-mono text-zinc-700">
                <span class="w-1 h-1 bg-emerald-500 rounded-full animate-pulse"></span>
                Система активна
            </div>
        </div>
    </div>
</footer>
