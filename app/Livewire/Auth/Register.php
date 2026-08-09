<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Database\Seeders\CategorySeeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public bool $terms_accepted = false;

    public function register()
    {
        $d = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'same:password_confirmation'],
            'terms_accepted' => ['accepted'],
        ]);
        $u = User::create([
            'name' => $d['name'],
            'email' => $d['email'],
            'password' => Hash::make($d['password']),
            'terms_accepted_at' => now(),
            'terms_version' => config('legal.terms_version', '2026-08-09'),
        ]);
        CategorySeeder::seedFor($u);
        Auth::login($u);

        return $this->redirectRoute('dashboard', navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register')->layout('layouts.auth');
    }
}
