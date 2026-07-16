<x-layouts::auth :title="'Вход в систему'">
    <!-- Карточка формы: строгий графитовый фон с тонкой темно-красной рамкой -->
    <div class="flex flex-col gap-6 p-8 rounded-sm bg-zinc-900 border border-red-900/40 relative shadow-2xl shadow-black/90 max-w-md w-full mx-auto">

        <!-- Шапка формы без использования x-auth-header (Чистый, контрастный HTML) -->
        <div class="text-center space-y-1">
            <h1 class="text-2xl font-extrabold font-mono uppercase tracking-wider text-zinc-100">
                Авторизация
            </h1>
            <p class="text-sm font-sans text-zinc-400 font-medium">
                Введите свой Email и пароль для доступа к блогу
            </p>
        </div>

        <!-- Статус сессии -->
        <x-auth-session-status class="text-center text-red-500 font-mono text-sm font-semibold" :status="session('status')" />

        <!-- Форма с принудительными темными стилями для Flux UI -->
        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-5 [--flux-primary:#dc2626] [--flux-accent:#ef4444]">
            @csrf

            <!-- Электронная почта -->
            <div class="flex flex-col gap-1.5">
                <flux:input
                    name="email"
                    :label="'Электронная почта'"
                    :value="old('email')"
                    type="email"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="name@example.com"
                    class="!bg-zinc-950 !border-zinc-800 !text-zinc-100 placeholder-zinc-600 focus:!border-red-600 focus:!ring-2 focus:!ring-red-600/30"
                />
            </div>

            <!-- Пароль -->
            <div class="flex flex-col gap-1.5 relative">
                <flux:input
                    name="password"
                    :label="'Пароль'"
                    type="password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                    viewable
                    class="!bg-zinc-950 !border-zinc-800 !text-zinc-100 placeholder-zinc-600 focus:!border-red-600 focus:!ring-2 focus:!ring-red-600/30"
                />

                @if (Route::has('password.request'))
                    <flux:link class="absolute top-0 text-xs end-0 text-zinc-400 hover:text-red-400 font-mono transition-colors" :href="route('password.request')" wire:navigate>
                        Забыли пароль?
                    </flux:link>
                @endif
            </div>

            <!-- Запомнить меня -->
            <div class="pt-1">
                <flux:checkbox
                    name="remember"
                    :label="'Запомнить меня'"
                    :checked="old('remember')"
                    class="text-zinc-300 font-mono text-xs tracking-wide cursor-pointer"
                />
            </div>

            <!-- Кнопка войти -->
            <div class="pt-2">
                <flux:button
                    variant="primary"
                    type="submit"
                    class="w-full !bg-red-700 hover:!bg-red-600 !text-white font-mono uppercase tracking-wider font-bold rounded-sm border-none shadow-lg shadow-red-950/60 h-11 transition-all active:scale-[0.99]"
                    data-test="login-button"
                >
                    Войти в аккаунт
                </flux:button>
            </div>
        </form>

        <!-- Ссылка на регистрацию -->
        <div class="text-xs text-center font-mono text-zinc-400 border-t border-zinc-800/80 pt-4 mt-1">
            <span>Еще нет аккаунта?</span>
            <flux:link :href="route('register')" wire:navigate class="text-red-500 hover:text-red-400 font-bold transition-colors ml-1">[ Создать аккаунт ]</flux:link>
        </div>
    </div>
</x-layouts::auth>
