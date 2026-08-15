<?php

namespace App\Livewire\Auth;

use App\Services\AuditService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Component;

class Login extends Component
{
    public string $email = '';

    public string $password = '';

    public bool $remember = false;

    protected function messages(): array
    {
        return [
            'email.required' => 'Informe seu e-mail.',
            'email.email' => 'Informe um e-mail válido.',
            'password.required' => 'Informe sua senha.',
        ];
    }

    public function login()
    {
        $data = $this->validate(['email' => ['required', 'email'], 'password' => ['required']]);
        $key = Str::transliterate(Str::lower($this->email).'|'.request()->ip());
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $this->addError('email', 'Muitas tentativas. Aguarde um minuto e tente novamente.');

            return;
        }

        if (! Auth::attempt($data, $this->remember)) {
            RateLimiter::hit($key, 60);
            $this->addError('email', 'E-mail ou senha inválidos.');

            return;
        }
        RateLimiter::clear($key);
        request()->session()->regenerate();
        $user = auth()->user();
        $user->forceFill(['last_login_at' => now()])->save();
        app(AuditService::class)->record($user, 'auth.login');

        return $this->redirectRoute('dashboard', navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.auth');
    }
}
