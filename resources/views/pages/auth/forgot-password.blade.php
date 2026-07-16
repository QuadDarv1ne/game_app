<x-layouts::auth :title="'Восстановление пароля'">
    <!-- Карточка формы: строгий графитовый фон с тонкой темно-красной рамкой -->
    <div class="flex flex-col gap-6 p-8 rounded-sm bg-zinc-900 border border-red-900/40 relative shadow-2xl shadow-black/90 max-w-md w-full mx-auto">

        <!-- Шапка формы (Чистый контрастный HTML вместо x-auth-header) -->
        <div class="text-center space-y-1">
            <h1 class="text-2xl font-extrabold font-mono uppercase tracking-wider text-zinc-100">
                Забыли пароль?
            </h1>
            <p class="text-sm font-sans text-zinc-400 font-medium">
                Введите свой Email для получения ссылки на сброс пароля
            </p>
        </div>

        <!-- Статус сессии / Успешная отправка ссылки -->
        <x-auth-session-status class="text-center text-red-500 font-mono text-sm font-semibold" :status="session('status')" />

        <!-- Форма с принудительными темными стилями для Flux UI -->
        <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-5 [--flux-primary:#dc2626] [--flux-accent:#ef4444]">
            @csrf

            <!-- Электронная почта -->
            <div class="flex flex-col gap-1.5">
                <flux:input
                    name="email"
                    :label="'Электронная почта'"
                    type="email"
                    required
                    autofocus
                    placeholder="name@example.com"
                    class="!bg-zinc-950 !border-zinc-800 !text-zinc-100 placeholder-zinc-600 focus:!border-red-600 focus:!ring-2 focus:!ring-red-600/30"
                />
            </div>

            <!-- Кнопка отправки ссылки -->
            <div class="pt-2">
                <flux:button
                    variant="primary"
                    type="submit"
                    class="w-full !bg-red-700 hover:!bg-red-600 !text-white font-mono uppercase tracking-wider font-bold rounded-sm border-none shadow-lg shadow-red-950/60 h-11 transition-all active:scale-[0.99]"
                    data-test="email-password-reset-link-button"
                >
                    Сбросить пароль
                </flux:button>
            </div>
        </form>

        <!-- Ссылка возврата на страницу входа -->
        <div class="text-xs text-center font-mono text-zinc-400 border-t border-zinc-800/80 pt-4 mt-1">
            <span>Или вернитесь на страницу</span>
            <flux:link :href="route('login')" wire:navigate class="text-red-500 hover:text-red-400 font-bold transition-colors ml-1">[ Авторизации ]</flux:link>
        </div>
    </div>
</x-layouts::auth>
