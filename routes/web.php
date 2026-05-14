<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// ── Rutas públicas (solo invitados) ──────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::post('/logear', [AuthController::class, 'logear'])->name('logear');
});

// ── Rutas del Veterinario ────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/home', [AuthController::class, 'home'])->name('home');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

// ── Rutas del Administrador ──────────────────────────────────────
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'adminDashboard'])->name('dashboard');
});
