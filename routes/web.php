<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('home.index');
})->name('home');

Route::get('/productos', [ProductoController::class, 'index'])
    ->name('productos.index');

Route::get('/productos/{producto}', [ProductoController::class, 'show'])
    ->name('productos.show');

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/perfil', function () {
        return view('perfil.index');
    })->name('perfil');

    Route::get('/pedidos', function () {
        return view('pedidos.index');
    })->name('pedidos.index');
});

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('dashboard');

    Route::get('/productos', [ProductoController::class, 'adminIndex'])
        ->name('productos.index');

    Route::get('/productos/crear', [ProductoController::class, 'create'])
        ->name('productos.create');

    Route::post('/productos', [ProductoController::class, 'store'])
        ->name('productos.store');

    Route::get('/productos/{producto}/editar', [ProductoController::class, 'edit'])
        ->name('productos.edit');

    Route::put('/productos/{producto}', [ProductoController::class, 'update'])
        ->name('productos.update');

    Route::delete('/productos/{producto}', [ProductoController::class, 'destroy'])
        ->name('productos.destroy');
});