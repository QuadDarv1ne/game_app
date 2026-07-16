<x-layouts::auth :title="'Установка нового пароля'">
    <!-- Карточка формы: строгий графитовый фон с тонкой темно-красной рамкой -->
    <div class="flex flex-col gap-6 p-8 rounded-sm bg-zinc-900 border border-red-900/40 relative shadow-2xl shadow-black/90 max-w-md w-full mx-auto">

        <!-- Шапка формы (Чистый контрастный HTML вместо x-auth-header) -->
        <div class="text-center space-y-1">
            <h1 class="text-2xl font-extrabold font-mono uppercase tracking-wider text-zinc-100">
                Новый пароль
            </h1>
            <p class="text-sm font-sans text-zinc-400 font-medium">
                Пожалуйста, введите и подтвердите ваш новый пароль ниже
            </p>
        </div>

        <!-- Статус сессии / Ошибки -->
        <x-auth-session-status class="text-center text-red-500 font-mono text-sm font-semibold" :status="session('status')" />

        <!-- Форма с принудительными темными стилями для Flux UI -->
        <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-5 [--flux-primary:#dc2626] [--flux-accent:#ef4444]">
            @csrf

            <!-- Скрытый токен восстановления -->
            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <!-- Электронная почта -->
            <div class="flex flex-col gap-1.5">
                <flux:input
                    name="email"
                    value="{{ request('email') }}"
                    :label="'Электронная почта'"
                    type="email"
                    required
                    autocomplete="email"
                    class="!bg-zinc-950 !border-zinc-800 !text-zinc-100 placeholder-zinc-600 focus:!border-red-600 focus:!ring-2 focus:!ring-red-600/30"
                />
            </div>

            <!-- Новый пароль -->
            <div class="flex flex-col gap-1.5">
                <flux:input
                    name="password"
                    :label="'Новый пароль'"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Минимум 8 символов"
                    passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                    viewable
                    class="!bg-zinc-950 !border-zinc-800 !text-zinc-100 placeholder-zinc-600 focus:!border-red-600 focus:!ring-2 focus:!ring-red-600/30"
                />
            </div>

            <!-- Подтверждение пароля -->
            <div class="flex flex-col gap-1.5">
                <flux:input
                    name="password_confirmation"
                    :label="'Подтвердите пароль'"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Повторите новый пароль"
                    passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                    viewable
                    class="!bg-zinc-950 !border-zinc-800 !text-zinc-100 placeholder-zinc-600 focus:!border-red-600 focus:!ring-2 focus:!ring-red-600/30"
                />
            </div>

            <!-- Кнопка сохранения -->
            <div class="pt-2">
                <flux:button
                    type="submit"
                    variant="primary"
                    class="w-full !bg-red-700 hover:!bg-red-600 !text-white font-mono uppercase tracking-wider font-bold rounded-sm border-none shadow-lg shadow-red-950/60 h-11 transition-all active:scale-[0.99]"
                    data-test="reset-password-button"
                >
                    Сохранить новый пароль
                </flux:button>
            </div>
        </form>
    </div>
</x-layouts::auth>
