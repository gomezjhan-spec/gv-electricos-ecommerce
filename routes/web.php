<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CarritoController;

// ── HOME ──────────────────────────────────────────────────────────────────────
Route::get('/', function () {
    $destacados = \App\Models\Producto::where('activo', true)
        ->where('destacado', true)
        ->orderByDesc('created_at')
        ->take(4)
        ->get();

    if ($destacados->isEmpty()) {
        $destacados = \App\Models\Producto::where('activo', true)
            ->orderByDesc('created_at')
            ->take(4)
            ->get();
    }

    return view('home.index', compact('destacados'));
})->name('home');

// ── CATÁLOGO ──────────────────────────────────────────────────────────────────
Route::get('/productos', [ProductoController::class, 'index'])
    ->name('productos.index');

Route::get('/productos/{producto}', [ProductoController::class, 'show'])
    ->name('productos.show');

// ── MAYOREO ───────────────────────────────────────────────────────────────────
Route::get('/mayoreo', function () {
    $productos = \App\Models\Producto::where('activo', true)
        ->where('disponible_mayoreo', true)
        ->orderByDesc('destacado')
        ->orderByDesc('created_at')
        ->paginate(12);
    return view('mayoreo.index', compact('productos'));
})->name('mayoreo');

// ── PROMOCIONES ───────────────────────────────────────────────────────────────
Route::get('/promociones', function () {
    $productos = \App\Models\Producto::where('activo', true)
        ->whereNotNull('badge')
        ->orderByDesc('created_at')
        ->paginate(12);
    return view('promociones.index', compact('productos'));
})->name('promociones');

// ── CARRITO ───────────────────────────────────────────────────────────────────
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
Route::post('/carrito/agregar/{producto}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::post('/carrito/actualizar/{id}', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
Route::post('/carrito/quitar/{id}', [CarritoController::class, 'quitar'])->name('carrito.quitar');
Route::post('/carrito/vaciar', [CarritoController::class, 'vaciar'])->name('carrito.vaciar');

// ── PÁGINAS INFORMATIVAS ──────────────────────────────────────────────────────
Route::get('/quienes-somos', fn() => view('info.quienes-somos'))->name('quienes-somos');
Route::get('/contacto',      fn() => view('info.contacto'))->name('contacto');
Route::get('/fidelizacion',  fn() => view('info.fidelizacion'))->name('fidelizacion');

// ── AUTH ──────────────────────────────────────────────────────────────────────
require __DIR__.'/auth.php';

// ── RUTAS AUTENTICADAS ────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/perfil',  fn() => view('perfil.index'))->name('perfil');
    Route::get('/pedidos', fn() => view('pedidos.index'))->name('pedidos.index');
});

// ── ADMIN ─────────────────────────────────────────────────────────────────────
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