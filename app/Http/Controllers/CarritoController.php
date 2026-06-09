<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    private function getCarrito(): array
    {
        return session('carrito', []);
    }

    private function saveCarrito(array $carrito): void
    {
        session(['carrito' => $carrito]);
    }

    public function index()
    {
        $carrito = $this->getCarrito();
        $total   = collect($carrito)->sum(fn($item) => $item['precio'] * $item['cantidad']);
        return view('carrito.index', compact('carrito', 'total'));
    }

    public function agregar(Request $request, Producto $producto)
    {
        $cantidad = (int) $request->input('cantidad', 1);

        if (!$producto->activo || $producto->stock === 0) {
            return back()->with('error', '❌ Producto no disponible.');
        }

        $carrito = $this->getCarrito();
        $id      = (string) $producto->id;

        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad'] = min($carrito[$id]['cantidad'] + $cantidad, $producto->stock);
        } else {
            $carrito[$id] = [
                'id'       => $producto->id,
                'nombre'   => $producto->nombre,
                'ref'      => $producto->referencia,
                'precio'   => $producto->precio_detal,
                'imagen'   => $producto->imagen_url,
                'emoji'    => \App\Models\Producto::categorias()[$producto->categoria]['icon'] ?? '📦',
                'stock'    => $producto->stock,
                'cantidad' => $cantidad,
            ];
        }

        $this->saveCarrito($carrito);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'count'   => collect($carrito)->sum('cantidad'),
                'message' => '✅ ' . $producto->nombre . ' agregado.',
            ]);
        }

        return back()->with('success', '✅ ' . $producto->nombre . ' agregado al carrito.');
    }

    public function actualizar(Request $request, $id)
    {
        $carrito = $this->getCarrito();
        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad'] = min((int) $request->cantidad, $carrito[$id]['stock']);
        }
        $this->saveCarrito($carrito);
        return back();
    }

    public function quitar($id)
    {
        $carrito = $this->getCarrito();
        unset($carrito[$id]);
        $this->saveCarrito($carrito);
        return back()->with('success', '🗑️ Producto eliminado del carrito.');
    }

    public function vaciar()
    {
        $this->saveCarrito([]);
        return back()->with('success', '🗑️ Carrito vaciado.');
    }
}