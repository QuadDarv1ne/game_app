<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<!-- Фиксируем глобальный ультра-темный фон и отключаем дефолтные градиенты -->
<body class="min-h-screen bg-zinc-950 text-zinc-100 antialiased selection:bg-red-600 selection:text-white">

<!-- Главный флекс-контейнер центрирования формы -->
<div class="flex min-h-screen flex-col items-center justify-center gap-6 p-6 md:p-10 relative overflow-hidden">

    <!-- Глобальный фоновый рубиновый эмбиент-свет позади всей формы -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-red-600/5 blur-[120px] rounded-full pointer-events-none"></div>

    <div class="flex w-full max-w-sm flex-col gap-2 relative z-10">

        <!-- Область вывода контента (форм входа, регистрации и т.д.) -->
        <div class="flex flex-col gap-6">
            {{ $slot }}
        </div>

        <!-- Добавленная кнопка возврата на главную страницу -->
        <div class="w-full text-center pt-4 mt-2">
            <a href="/" class="inline-flex items-center justify-center text-xs font-mono uppercase tracking-wider text-zinc-500 hover:text-red-400 transition-colors py-2" wire:navigate>
                [ Вернуться на главную ]
            </a>
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
