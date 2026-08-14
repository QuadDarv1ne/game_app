<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Настройки безопасности')] class extends Component {
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function updatePassword(): void
    {
        $validated = $this->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (! Hash::check($validated['current_password'], Auth::user()->password)) {
            $this->addError('current_password', 'Неверный текущий пароль.');

            return;
        }

        Auth::user()->forceFill([
            'password' => Hash::make($validated['password']),
        ])->save();

        $this->current_password = '';
        $this->password = '';
        $this->password_confirmation = '';

        session()->flash('status', 'password-updated');
    }
}; ?>

<section class="w-full min-h-[85vh] flex flex-col items-center justify-center px-4">

    <flux:heading class="sr-only">Настройки безопасности</flux:heading>

    <div class="max-w-md w-full mx-auto">
        <x-pages::settings.layout :heading="'Безопасность'" :subheading="'Обновите пароль и настройки безопасности'">

            {{-- Password Update Section --}}
            <div class="space-y-6">
                <form wire:submit="updatePassword" class="my-6 w-full space-y-6">
                    <div class="space-y-1.5">
                        <h3 class="text-sm font-bold font-mono text-zinc-100 uppercase tracking-wide">
                            Update password
                        </h3>
                        <p class="text-xs font-sans text-zinc-400">
                            Убедитесь, что вы используете надежный пароль для защиты аккаунта.
                        </p>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <flux:input
                            wire:model="current_password"
                            :label="'Текущий пароль'"
                            type="password"
                            required
                            autocomplete="current-password"
                            placeholder="Введите текущий пароль"
                            class="!bg-zinc-950 !border-zinc-800 !text-zinc-100 placeholder-zinc-600 focus:!border-red-600 focus:!ring-2 focus:!ring-red-600/30"
                        />
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <flux:input
                            wire:model="password"
                            :label="'Новый пароль'"
                            type="password"
                            required
                            autocomplete="new-password"
                            placeholder="Введите новый пароль"
                            class="!bg-zinc-950 !border-zinc-800 !text-zinc-100 placeholder-zinc-600 focus:!border-red-600 focus:!ring-2 focus:!ring-red-600/30"
                        />
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <flux:input
                            wire:model="password_confirmation"
                            :label="'Подтвердите пароль'"
                            type="password"
                            required
                            autocomplete="new-password"
                            placeholder="Повторите новый пароль"
                            class="!bg-zinc-950 !border-zinc-800 !text-zinc-100 placeholder-zinc-600 focus:!border-red-600 focus:!ring-2 focus:!ring-red-600/30"
                        />
                    </div>

                    <div class="flex flex-col gap-3 pt-2">
                        <flux:button
                            variant="primary"
                            type="submit"
                            class="w-full !bg-red-700 hover:!bg-red-600 !text-white font-mono uppercase tracking-wider font-bold rounded-sm border-none shadow-lg shadow-red-950/60 h-11 transition-all active:scale-[0.99]"
                        >
                            Обновить пароль
                        </flux:button>
                    </div>

                    @if (session('status') === 'password-updated')
                        <div class="text-xs font-mono p-3 bg-emerald-950/30 border border-emerald-900/40 text-emerald-400 rounded-sm">
                            Пароль успешно обновлен.
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="text-xs font-mono p-3 bg-red-950/30 border border-red-900/40 text-red-400 rounded-sm">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                </form>
            </div>

        </x-pages::settings.layout>
    </div>
</section>
