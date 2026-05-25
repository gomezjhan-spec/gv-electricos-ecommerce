<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

// ─────────────────────────────────────────────
// HOME
// ─────────────────────────────────────────────

Route::get('/', function () {
    return view('home.index');
})->name('home');

// ─────────────────────────────────────────────
// CATÁLOGO PÚBLICO
// ─────────────────────────────────────────────

Route::get('/productos', [ProductoController::class, 'index'])
    ->name('productos.index');

Route::get('/productos/{producto}', [ProductoController::class, 'show'])
    ->name('productos.show');

// ─────────────────────────────────────────────
// ADMIN PRODUCTOS
// ─────────────────────────────────────────────

Route::prefix('admin')->name('admin.')->group(function () {

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