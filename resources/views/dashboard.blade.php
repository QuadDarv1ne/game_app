<x-layouts::app :title="'Панель управления'">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-sm">

        <div class="relative flex-1 min-h-[350px] flex flex-col items-center justify-center p-10 rounded-sm bg-zinc-900 border border-red-900/30 shadow-xl overflow-hidden">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-red-600/5 blur-[80px] rounded-full pointer-events-none"></div>

            <div class="max-w-md text-center space-y-8 relative z-10">
                <div class="space-y-2">
                    <span class="text-[11px] font-mono tracking-widest text-red-500 uppercase font-bold">// Терминал пользователя</span>
                    <h2 class="text-xl font-bold font-mono uppercase tracking-wide text-zinc-100">Управление аккаунтом</h2>
                    <p class="text-xs text-zinc-400 font-sans leading-relaxed">
                        Добро пожаловать, {{ auth()->user()->name }}. Отсюда вы можете изменить параметры безопасности, настроить профиль или перейти к чтению публикаций блога.
                    </p>
                </div>

                {{-- Статистика --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <a href="{{ route('profile') }}" class="p-3 bg-zinc-950 rounded-sm border border-zinc-800/60 hover:border-red-900/40 transition-all group">
                        <div class="text-lg font-bold font-mono text-red-500">{{ auth()->user()->posts()->count() }}</div>
                        <div class="text-[9px] font-mono text-zinc-500 uppercase tracking-wider mt-0.5">Постов</div>
                    </a>
                    <a href="{{ route('profile') }}" class="p-3 bg-zinc-950 rounded-sm border border-zinc-800/60 hover:border-red-900/40 transition-all group">
                        <div class="text-lg font-bold font-mono text-zinc-300">{{ auth()->user()->comments()->count() }}</div>
                        <div class="text-[9px] font-mono text-zinc-500 uppercase tracking-wider mt-0.5">Комментариев</div>
                    </a>
                    <a href="{{ route('profile') }}" class="p-3 bg-zinc-950 rounded-sm border border-zinc-800/60 hover:border-red-900/40 transition-all group">
                        <div class="text-lg font-bold font-mono text-amber-500">{{ auth()->user()->bookmarks()->count() }}</div>
                        <div class="text-[9px] font-mono text-zinc-500 uppercase tracking-wider mt-0.5">Избранного</div>
                    </a>
                    <a href="{{ route('profile') }}" class="p-3 bg-zinc-950 rounded-sm border border-zinc-800/60 hover:border-red-900/40 transition-all group">
                        <div class="text-lg font-bold font-mono text-purple-500">{{ auth()->user()->achievements()->count() }}</div>
                        <div class="text-[9px] font-mono text-zinc-500 uppercase tracking-wider mt-0.5">Достижений</div>
                    </a>
                </div>

                <div class="flex flex-col gap-4 pt-2">
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                        <a href="{{route('home')}}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-red-700 hover:bg-red-600 text-white font-mono uppercase font-bold text-xs tracking-wider rounded-sm shadow-md shadow-red-950/60 transition-all active:scale-[0.98] group">
                            Главная
                            <svg   viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5 transform group-hover:translate-x-0.5 transition-transform">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>

                        <a href="{{ route('posts.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 border border-zinc-800 bg-zinc-950 text-zinc-400 font-mono uppercase font-bold text-xs tracking-wider rounded-sm hover:border-red-900/60 hover:text-white transition-all active:scale-[0.98]">
                            Новый пост
                        </a>

                        <a href="{{ route('profile.edit') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 border border-zinc-800 bg-zinc-950 text-zinc-400 font-mono uppercase font-bold text-xs tracking-wider rounded-sm hover:border-red-900/60 hover:text-white transition-all active:scale-[0.98]">
                            Настройки профиля
                        </a>
                    </div>

                    <div class="pt-2 border-t border-zinc-800/40 w-full flex justify-center">
                        <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
                            @csrf
                            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2 text-xs font-mono uppercase tracking-wider text-zinc-500 hover:text-red-400 bg-transparent border border-transparent hover:border-red-900/30 rounded-sm transition-all cursor-pointer">
                                [ Выйти из системы ]
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-layouts::app>
