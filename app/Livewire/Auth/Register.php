<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Services\AuditService;
use Database\Seeders\CategorySeeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Register extends Component
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public bool $terms_accepted = false;

    public mixed $admin = null;

    public function register()
    {
        $d = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'same:password_confirmation'],
            'terms_accepted' => ['accepted'],
            'admin' => ['nullable', 'boolean', Rule::notIn([true, 1, '1'])],
        ]);
        $u = User::create([
            'name' => $d['name'],
            'email' => $d['email'],
            'password' => Hash::make($d['password']),
            'role' => 'user',
            'terms_accepted_at' => now(),
            'terms_version' => config('legal.terms_version', '2026-08-09'),
        ]);
        CategorySeeder::seedFor($u);
        Auth::login($u);
        $u->forceFill(['last_login_at' => now()])->save();
        app(AuditService::class)->record($u, 'auth.register');

        return $this->redirectRoute('dashboard', navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register')->layout('layouts.auth');
    }
}
