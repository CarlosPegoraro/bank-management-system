<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\CategoriesPage;
use App\Livewire\Dashboard;
use App\Livewire\FinancialAccountsPage;
use App\Livewire\TransactionsPage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route(Auth::check() ? 'dashboard' : 'login'));
Route::get('/entrar', Login::class)->middleware('guest')->name('login');
Route::get('/criar-conta', Register::class)->middleware('guest')->name('register');
Route::post('/sair', function () { Auth::logout(); request()->session()->invalidate(); request()->session()->regenerateToken(); return redirect()->route('login'); })->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/transacoes', TransactionsPage::class)->name('transactions');
    Route::get('/contas-e-cartoes', FinancialAccountsPage::class)->name('accounts');
    Route::get('/categorias', CategoriesPage::class)->name('categories');
});
