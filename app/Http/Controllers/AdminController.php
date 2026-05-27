<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'productos'  => Producto::count(),
            'activos'    => Producto::where('activo', true)->count(),
            'sin_stock'  => Producto::where('stock', 0)->count(),
            'usuarios'   => User::count(),
            'admins'     => User::role('admin')->count(),
            'mayoristas' => User::role('mayorista')->count(),
            'clientes'   => User::role('cliente')->count(),
        ];

        $productos_recientes = Producto::orderByDesc('created_at')->take(5)->get();
        $usuarios_recientes  = User::orderByDesc('created_at')->take(5)->get();

        return view('admin.dashboard', compact(
            'stats', 'productos_recientes', 'usuarios_recientes'
        ));
    }
}