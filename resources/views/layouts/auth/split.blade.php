<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<!-- Зафиксировали глобальный ультра-темный фон для всего экрана -->
<body class="min-h-screen bg-zinc-950 text-zinc-100 antialiased selection:bg-red-600 selection:text-white">
<div class="relative grid h-screen flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">

    <!-- ЛЕВАЯ ПАНЕЛЬ: Игровой манифест (показывается на десктопах) -->
    <div class="relative hidden h-full flex-col p-10 text-white lg:flex border-e border-zinc-900 bg-zinc-900/40 overflow-hidden">
        <!-- Фоновое рубиновое свечение внутри панели -->
        <div class="absolute -bottom-20 -left-20 w-96 h-96 bg-red-600/5 blur-[100px] rounded-full pointer-events-none"></div>

        <!-- Динамическая цитата Laravel Inspiring, оформленная в терминальном стиле -->
        @php
            [$message, $author] = str(Illuminate\Foundation\Inspiring::quotes()->random())->explode('-');
        @endphp

        <div class="relative z-20 mt-auto border-l-2 border-red-700 pl-6 py-2">
            <blockquote class="space-y-3">
                <p class="text-base font-medium font-mono text-zinc-200 leading-relaxed italic">
                    &ldquo;{{ trim($message) }}&rdquo;
                </p>
                <footer>
                    <p class="text-xs font-mono tracking-wider text-red-500 uppercase font-bold">
                        // {{ trim($author) }}
                    </p>
                </footer>
            </blockquote>
        </div>
    </div>

    <!-- ПРАВАЯ ПАНЕЛЬ: Рабочая область вывода форм -->
    <div class="w-full lg:p-8 relative">
        <!-- Небольшой фоновый отблеск за формой для атмосферы -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-red-600/5 blur-2xl rounded-full pointer-events-none"></div>

        <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px] relative z-10">
            <!-- Мобильное название (появляется только на смартфонах) без логотипов и иконок -->
            <a href="/" class="z-20 flex flex-col items-center gap-1 font-mono font-bold tracking-widest text-red-600 lg:hidden uppercase text-xs" wire:navigate>
                Game App<span class="text-zinc-600">.</span>
            </a>

            <!-- Контент формы (Вход / Регистрация) -->
            {{ $slot }}

            <!-- Добавленная кнопка возврата на главную страницу -->
            <div class="w-full text-center pt-4 mt-2 border-t border-zinc-900">
                <a href="/" class="inline-flex items-center justify-center text-xs font-mono uppercase tracking-wider text-zinc-500 hover:text-red-400 transition-colors py-2" wire:navigate>
                    [ Вернуться на главную ]
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Всплывающие уведомления системы -->
@persist('toast')
<flux:toast.group>
    <flux:toast class="!bg-zinc-900 !border-red-900/40 !text-zinc-100" />
</flux:toast.group>
@endpersist

@fluxScripts
</body>
</html>
