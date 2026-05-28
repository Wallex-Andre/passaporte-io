<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');



Route::get('/admin', function () {
    return 'Painel do organizador';
})->middleware(['auth', 'role:organizador'])->name('admin.dashboard');

Route::get('/teste-participante', function () {
    return 'Área permitida para participante';
})->middleware(['auth', 'role:participante'])->name('participant.test');