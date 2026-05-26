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
    Route::get('/usuarios', [\App\Http\Controllers\Admin\UsuariosController::class, 'index'])->name('users.index');
    Route::get('/usuarios/crear', [\App\Http\Controllers\Admin\UsuariosController::class, 'create'])->name('users.create');
    Route::post('/usuarios', [\App\Http\Controllers\Admin\UsuariosController::class, 'store'])->name('users.store');
    Route::get('/usuarios/{usuario}/editar', [\App\Http\Controllers\Admin\UsuariosController::class, 'edit'])->name('users.edit');
    Route::put('/usuarios/{usuario}', [\App\Http\Controllers\Admin\UsuariosController::class, 'update'])->name('users.update');
    Route::get('/usuarios/{usuario}', [\App\Http\Controllers\Admin\UsuariosController::class, 'show'])->name('users.show');
    Route::delete('/usuarios/{usuario}', [\App\Http\Controllers\Admin\UsuariosController::class, 'destroy'])->name('users.destroy');
    
    // Expedientes
    Route::get('/expedientes', [\App\Http\Controllers\Admin\ExpedientesController::class, 'index'])->name('expedientes.index');
    Route::get('/expedientes/buscar', [\App\Http\Controllers\Admin\ExpedientesController::class, 'search'])->name('expedientes.search');
    Route::get('/expedientes/nuevo', [\App\Http\Controllers\Admin\ExpedientesController::class, 'create'])->name('expedientes.create');
    Route::post('/expedientes', [\App\Http\Controllers\Admin\ExpedientesController::class, 'store'])->name('expedientes.store');
    Route::get('/expedientes/{mascota}/consultas', [\App\Http\Controllers\Admin\ExpedientesController::class, 'consultas'])->name('expedientes.consultas');
    Route::get('/expedientes/{mascota}/consultas/{consulta}', [\App\Http\Controllers\Admin\ExpedientesController::class, 'detalleConsulta'])->name('expedientes.consultas.show');
    Route::get('/expedientes/{mascota}/consultas/{consulta}/diagnostico', [\App\Http\Controllers\Admin\ExpedientesController::class, 'diagnostico'])->name('expedientes.consultas.diagnostico');
    Route::post('/expedientes/{mascota}/consultas/{consulta}/diagnostico', [\App\Http\Controllers\Admin\ExpedientesController::class, 'guardarDiagnostico'])->name('expedientes.consultas.diagnostico.store');
    
    Route::get('/expedientes/{mascota}/consultas/{consulta}/tratamiento', [\App\Http\Controllers\Admin\ExpedientesController::class, 'tratamiento'])->name('expedientes.consultas.tratamiento');
    Route::post('/expedientes/{mascota}/consultas/{consulta}/tratamiento', [\App\Http\Controllers\Admin\ExpedientesController::class, 'guardarTratamiento'])->name('expedientes.consultas.tratamiento.store');
});
