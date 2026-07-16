<x-layouts::auth :title="'Подтверждение электронной почты'">
    <!-- Карточка формы: строгий графитовый фон с тонкой темно-красной рамкой -->
    <div class="flex flex-col gap-6 p-8 rounded-sm bg-zinc-900 border border-red-900/40 relative shadow-2xl shadow-black/90 max-w-md w-full mx-auto">

        <!-- Шапка формы -->
        <div class="text-center space-y-1">
            <h1 class="text-2xl font-extrabold font-mono uppercase tracking-wider text-zinc-100">
                Верификация
            </h1>
        </div>

        <!-- Основной текст инструкции (сделан светлым и читаемым) -->
        <div class="text-center text-sm font-sans text-zinc-300 leading-relaxed">
            Пожалуйста, подтвердите свой адрес электронной почты, перейдя по ссылке, которую мы только что отправили вам в письме.
        </div>

        <!-- Уведомление об успешной повторной отправке ссылки (вместо ядовито-зеленого — строгий приглушенный зеленый, хорошо читаемый на темном) -->
        @if (session('status') == 'verification-link-sent')
            <div class="text-center text-sm font-mono p-3 bg-emerald-950/40 border border-emerald-900/50 text-emerald-400 rounded-sm">
                Новая ссылка для подтверждения была отправлена на Email, указанный при регистрации.
            </div>
        @endif

        <!-- Блок управления (Кнопка и Выход) -->
        <div class="flex flex-col items-center gap-4 pt-2">
            <!-- Форма отправки письма -->
            <form method="POST" action="{{ route('verification.send') }}" class="w-full [--flux-primary:#dc2626]">
                @csrf
                <flux:button
                    type="submit"
                    variant="primary"
                    class="w-full !bg-red-700 hover:!bg-red-600 !text-white font-mono uppercase tracking-wider font-bold rounded-sm border-none shadow-lg shadow-red-950/60 h-11 transition-all active:scale-[0.99]"
                >
                    Отправить письмо повторно
                </flux:button>
            </form>

            <!-- Кнопка Выйти (Стилизована под строгую текстовую ссылку в скобках) -->
            <form method="POST" action="{{ route('logout') }}" class="w-full text-center">
                @csrf
                <button
                    type="submit"
                    class="text-xs font-mono text-zinc-500 hover:text-red-400 transition-colors bg-transparent border-none cursor-pointer uppercase tracking-wider"
                    data-test="logout-button"
                >
                    [ Выйти из аккаунда ]
                </button>
            </form>
        </div>
    </div>
</x-layouts::auth>
