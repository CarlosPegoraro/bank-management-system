<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\CategoriesPage;
use App\Livewire\Dashboard;
use App\Livewire\FinancialAccountsPage;
use App\Livewire\ProfileSettings;
use App\Livewire\TransactionsPage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route(Auth::check() ? 'dashboard' : 'login'));
Route::get('/login', Login::class)->middleware('guest')->name('login');
Route::get('/register', Register::class)->middleware('guest')->name('register');
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('login');
})->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/transactions', TransactionsPage::class)->name('transactions');
    Route::get('/accounts-and-cards', FinancialAccountsPage::class)->name('accounts');
    Route::get('/categories', CategoriesPage::class)->name('categories');
    Route::get('/profile', ProfileSettings::class)->name('profile');
});
