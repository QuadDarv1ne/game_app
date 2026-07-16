<?php

use Livewire\Component;
use Livewire\Attributes\Title;

new #[Title('Настройки внешнего вида')] class extends Component {
    //
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">Настройки внешнего вида</flux:heading>

    <x-pages::settings.layout :heading="'Внешний вид'" :subheading="'Управление визуальным стилем вашего аккаунта'">
        <div class="space-y-4">
            <p class="text-xs font-mono text-zinc-400 leading-relaxed uppercase tracking-wider">
                // Визуальный режим платформы
            </p>
            <p class="text-sm text-zinc-300 font-sans">
                Интерфейс игрового блога оптимизирован для работы в условиях низкой освещенности. Темный режим зафиксирован по умолчанию для поддержания единой атмосферы андеграунда.
            </p>

            <div class="mt-4 pt-2">
                <div class="inline-flex items-center gap-3 px-4 py-2.5 bg-zinc-950 border border-red-900/40 text-red-500 font-mono text-xs uppercase tracking-widest rounded-sm">
                    <svg  viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                    </svg>
                    Активен: Темный строгий стиль
                </div>
            </div>
        </div>
    </x-pages::settings.layout>
</section>
