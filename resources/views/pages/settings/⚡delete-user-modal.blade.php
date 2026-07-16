<?php

use App\Concerns\PasswordValidationRules;
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component {
    use PasswordValidationRules;

    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => $this->currentPasswordRules(),
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<flux:modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable class="max-w-lg !bg-zinc-900 border !border-red-900/40 rounded-sm p-6 shadow-2xl shadow-black">
    <form method="POST" wire:submit="deleteUser" class="space-y-6 [--flux-primary:#dc2626]">

        <div class="space-y-2">
            <flux:heading size="lg" class="!text-zinc-100 !font-mono !uppercase !tracking-wide !text-base font-bold">
                Вы уверены, что хотите удалить аккаунт?
            </flux:heading>

            <flux:subheading class="!text-zinc-400 !text-xs leading-relaxed">
                После удаления вашего профиля все связанные данные будут безвозвратно уничтожены. Пожалуйста, введите ваш действующий пароль для подтверждения операции.
            </flux:subheading>
        </div>

        <div class="flex flex-col gap-1.5">
            <flux:input
                wire:model="password"
                :label="'Подтвердите пароль'"
                type="password"
                viewable
                placeholder="••••••••"
                class="!bg-zinc-950 !border-zinc-800 !text-zinc-100 placeholder-zinc-600 focus:!border-red-600 focus:!ring-2 focus:!ring-red-600/30"
            />
        </div>

        <div class="flex justify-end gap-3 pt-2 font-mono text-xs">
            <!-- Отмена -->
            <flux:modal.close>
                <flux:button
                    variant="filled"
                    class="!bg-zinc-950 !border !border-zinc-800 !text-zinc-400 hover:!text-white hover:!border-zinc-600 uppercase tracking-wider font-bold rounded-sm h-10 px-4 transition-all"
                >
                    Отмена
                </flux:button>
            </flux:modal.close>

            <flux:button
                variant="danger"
                type="submit"
                class="!bg-red-700 hover:!bg-red-600 !text-white uppercase tracking-wider font-bold rounded-sm h-10 px-4 transition-all border-none shadow-md shadow-red-950/50"
                data-test="confirm-delete-user-button"
            >
                Удалить профиль
            </flux:button>
        </div>
    </form>
</flux:modal>
