<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\PublicEventController;

Route::get('/', [PublicEventController::class, 'index'])->name('home');

Route::get('/events/{event}', [PublicEventController::class, 'show'])->name('events.show');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::prefix('admin')
    ->middleware(['auth', 'role:organizador'])
    ->name('admin.')
    ->group(function () {
        Route::resource('events', EventController::class)->except(['show']);
});

Route::middleware(['auth', 'role:participante'])->group(function () {
    Route::post('/events/{event}/enroll', [EnrollmentController::class, 'store'])
        ->name('events.enroll');

    Route::get('/minhas-inscricoes', [EnrollmentController::class, 'index'])
        ->name('enrollments.index');

    Route::delete('/minhas-inscricoes/{event}', [EnrollmentController::class, 'destroy'])
        ->name('enrollments.destroy');
});