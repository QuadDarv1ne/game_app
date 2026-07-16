<?php

use Livewire\Component;

new class extends Component {}; ?>

<section class="space-y-6">
    <div class="relative space-y-1">
        <flux:heading class="!text-zinc-100 !text-lg !font-bold !font-mono !uppercase !tracking-wide">
            Удаление аккаунта
        </flux:heading>
        <flux:subheading class="!text-zinc-400 !text-sm !font-sans">
            Персональный профиль и все связанные данные будут безвозвратно удалены.
        </flux:subheading>
    </div>

    <div class="pt-2">
        <flux:modal.trigger name="confirm-user-deletion">
            <flux:button
                variant="danger"
                class="!bg-red-950/40 hover:!bg-red-700 !text-red-400 hover:!text-white border !border-red-900/60 font-mono text-xs uppercase tracking-wider font-bold rounded-sm px-4 py-2.5 transition-all cursor-pointer"
                data-test="delete-user-button"
            >
                [ Удалить аккаунт ]
            </flux:button>
        </flux:modal.trigger>
    </div>

    <livewire:pages::settings.delete-user-modal />
</section>
