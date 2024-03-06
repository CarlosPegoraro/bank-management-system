<?php

use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

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



Route::get('/', function () {
    return to_route('debt.index');
});
Route::get('/login', [AuthController::class, 'index'])->name('auth.index');
Route::get('/register', [AuthController::class, 'create'])->name('auth.create');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/debt/extract', [DebtController::class, 'extract'])->name('debt.extract');
    Route::resource('/debt', DebtController::class);

    Route::get('/notification/get-json', [NotificationController::class, 'getNotification'])->name('notification.get-json');

    Route::resource('/card', CardController::class);
    Route::resource('/analysis', AnalysisController::class);

    Route::get('/new-content', function () {return view('new-content');})->name('new-content');
});
