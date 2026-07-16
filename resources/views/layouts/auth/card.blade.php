<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<!-- Фиксируем глобальный ультра-темный фон и отключаем дефолтные градиенты -->
<body class="min-h-screen bg-zinc-950 text-zinc-100 antialiased selection:bg-red-600 selection:text-white">

<!-- Главный флекс-контейнер центрирования карточки -->
<div class="flex min-h-screen flex-col items-center justify-center gap-6 p-6 md:p-10 relative overflow-hidden">

    <!-- Глобальный фоновый рубиновый эмбиент-свет позади всей формы -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-red-600/5 blur-[120px] rounded-full pointer-events-none"></div>

    <div class="flex w-full max-w-md flex-col gap-6 relative z-10">

        <!-- Основной контейнер карточки формы -->
        <div class="flex flex-col gap-6">
            <!-- Заменили белые фоны bg-white/stone-950 и скругления rounded-xl на строгий графитовый bg-zinc-900 с тонкой красной рамкой -->
            <div class="rounded-sm border border-red-900/30 bg-zinc-900 shadow-2xl shadow-black/80">
                <div class="px-8 py-8 md:px-10">

                    <!-- Вывод формы авторизации/регистрации -->
                    {{ $slot }}

                    <!-- Интегрированная кнопка возврата на главную страницу -->
                    <div class="w-full text-center pt-5 mt-5 border-t border-zinc-800/60">
                        <a href="/" class="inline-flex items-center justify-center text-xs font-mono uppercase tracking-wider text-zinc-500 hover:text-red-400 transition-colors py-2" wire:navigate>
                            [ Вернуться на главную ]
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<!-- Всплывающие уведомления системы (тосты) -->
@persist('toast')
<flux:toast.group>
    <flux:toast class="!bg-zinc-900 !border-red-900/40 !text-zinc-100" />
</flux:toast.group>
@endpersist

@fluxScripts
</body>
</html>
