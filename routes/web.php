<?php

use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', [AuthController::class, 'index'])->name('auth.index');
Route::get('/register', [AuthController::class, 'create'])->name('auth.create');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

Route::get('/transaction/extract', [TransactionController::class, 'extract'])->name('transaction.extract');
Route::resource('/transaction', TransactionController::class)->middleware('auth');

Route::resource('/card', CardController::class)->middleware('auth');
Route::resource('/analysis', AnalysisController::class)->middleware('auth');

Route::get('/new-content', function () {
    return view('new-content');
})->middleware('auth')->name('new-content');




