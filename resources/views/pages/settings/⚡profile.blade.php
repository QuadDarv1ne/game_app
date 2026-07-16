<?php

use App\Concerns\ProfileValidationRules;
/* @chisel-email-verification */
use Illuminate\Contracts\Auth\MustVerifyEmail;
/* @end-chisel-email-verification */
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Настройки профиля')] class extends Component {
    use ProfileValidationRules;

    public string $name = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate($this->profileRules($user->id));

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        Flux::toast(variant: 'success', text: 'Профиль успешно обновлен.');
    }

    /* @chisel-email-verification */
    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    #[Computed]
    public function hasUnverifiedEmail(): bool
    {
        return Auth::user() instanceof MustVerifyEmail && ! Auth::user()->hasVerifiedEmail();
    }

    #[Computed]
    public function showDeleteUser(): bool
    {
        return ! Auth::user() instanceof MustVerifyEmail
            || (Auth::user() instanceof MustVerifyEmail && Auth::user()->hasVerifiedEmail());
    }
    /* @end-chisel-email-verification */
}; ?>

<section class="w-full min-h-[85vh] flex flex-col items-center justify-center px-4">

    <flux:heading class="sr-only">Настройки профиля</flux:heading>

    <div class="max-w-md w-full mx-auto">
        <x-pages::settings.layout :heading="'Профиль'" :subheading="'Обновите ваше имя и адрес электронной почты'">
            <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6 [--flux-primary:#dc2626]">

                <div class="flex flex-col gap-1.5">
                    <flux:input
                        wire:model="name"
                        :label="'Имя или никнейм'"
                        type="text"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="Имя пользователя"
                        class="!bg-zinc-950 !border-zinc-800 !text-zinc-100 placeholder-zinc-600 focus:!border-red-600 focus:!ring-2 focus:!ring-red-600/30"
                    />
                </div>

                <div class="flex flex-col gap-1.5">
                    <flux:input
                        wire:model="email"
                        :label="'Электронная почта'"
                        type="email"
                        required
                        autocomplete="email"
                        placeholder="name@example.com"
                        class="!bg-zinc-950 !border-zinc-800 !text-zinc-100 placeholder-zinc-600 focus:!border-red-600 focus:!ring-2 focus:!ring-red-600/30"
                    />

                    @if ($this->hasUnverifiedEmail)
                        <div class="mt-4 p-4 bg-zinc-950 border border-red-950/40 rounded-sm space-y-2">
                            <flux:text class="!text-zinc-400 text-xs font-mono uppercase tracking-wide">
                                // Ваш адрес электронной почты не подтвержден.
                            </flux:text>

                            <div>
                                <flux:link class="text-xs text-red-500 hover:text-red-400 font-bold transition-colors cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                    [ Нажмите здесь, чтобы отправить письмо повторно ]
                                </flux:link>
                            </div>

                            @if (session('status') === 'verification-link-sent')
                                <div class="mt-2 text-xs font-mono p-2 bg-emerald-950/30 border border-emerald-900/40 text-emerald-400 rounded-sm">
                                    Новая ссылка для подтверждения отправлена на ваш Email.
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="flex flex-col gap-3 pt-2">
                    <flux:button
                        variant="primary"
                        type="submit"
                        class="w-full !bg-red-700 hover:!bg-red-600 !text-white font-mono uppercase tracking-wider font-bold rounded-sm border-none shadow-lg shadow-red-950/60 h-11 transition-all active:scale-[0.99]"
                        data-test="update-profile-button"
                    >
                        Сохранить изменения
                    </flux:button>

                    <div class="w-full text-center pt-1">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center text-xs font-mono uppercase tracking-wider text-zinc-500 hover:text-red-400 transition-colors py-2">
                            [ Вернуться в панель управления ]
                        </a>
                    </div>
                </div>
            </form>

            @if ($this->showDeleteUser)
                <div class="border-t border-zinc-800/80 pt-6 mt-6">
                    <livewire:pages::settings.delete-user-form />
                </div>
            @endif
        </x-pages::settings.layout>
    </div>
</section>
