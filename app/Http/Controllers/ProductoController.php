<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index(Request $request)
{
    $categorias      = Producto::categorias();
    $categoriaActual = $request->get('categoria', '');
    $busqueda        = $request->get('q', '');
    $soloMayoreo     = $request->boolean('disponible_mayoreo');
    $badge           = $request->get('badge', '');

    $query = Producto::where('activo', true);

    if ($categoriaActual && array_key_exists($categoriaActual, $categorias)) {
        $query->where('categoria', $categoriaActual);
    }

    if ($busqueda) {
        $query->where(function ($q) use ($busqueda) {
            $q->where('nombre', 'like', "%$busqueda%")
              ->orWhere('referencia', 'like', "%$busqueda%")
              ->orWhere('descripcion', 'like', "%$busqueda%");
        });
    }

    if ($soloMayoreo) {
        $query->where('disponible_mayoreo', true);
    }

    if ($badge) {
        $query->where('badge', strtoupper($badge));
    }

    $productos = $query->orderByDesc('destacado')
                       ->orderByDesc('created_at')
                       ->paginate(12);

    return view('productos.index', compact(
        'productos', 'categorias', 'categoriaActual', 'busqueda', 'soloMayoreo', 'badge'
    ));
}

    public function show(Producto $producto)
    {
        abort_unless($producto->activo, 404);

        $relacionados = Producto::where('categoria', $producto->categoria)
                                ->where('id', '!=', $producto->id)
                                ->where('activo', true)
                                ->take(4)->get();

        return view('productos.show', compact('producto', 'relacionados'));
    }

    public function adminIndex()
    {
        $productos = Producto::orderByDesc('created_at')->paginate(20);
        return view('admin.productos.index', compact('productos'));
    }

    public function create()
    {
        $categorias = Producto::categorias();
        $producto   = null;
        return view('admin.productos.form', compact('categorias', 'producto'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'                  => 'required|string|max:255',
            'referencia'              => 'required|string|unique:productos',
            'descripcion'             => 'nullable|string',
            'precio_detal'            => 'required|numeric|min:0',
            'precio_mayoreo'          => 'nullable|numeric|min:0',
            'cantidad_minima_mayoreo' => 'nullable|integer|min:1',
            'stock'                   => 'required|integer|min:0',
            'categoria'               => 'required|string',
            'disponible_mayoreo'      => 'nullable|boolean',
            'destacado'               => 'nullable|boolean',
            'badge'                   => 'nullable|string|max:20',
            'imagen'                  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')
                                      ->store('productos', 'public');
        }

        $data['disponible_mayoreo'] = $request->boolean('disponible_mayoreo');
        $data['destacado']          = $request->boolean('destacado');
        $data['activo']             = true;

        Producto::create($data);

        // ✅ CORREGIDO: redirigir al panel admin, no al catálogo público
        return redirect()->route('admin.productos.index')
                         ->with('success', '✅ Producto creado correctamente.');
    }

    public function edit(Producto $producto)
    {
        $categorias = Producto::categorias();
        return view('admin.productos.form', compact('producto', 'categorias'));
    }

    public function update(Request $request, Producto $producto)
    {
        $data = $request->validate([
            'nombre'                  => 'required|string|max:255',
            'referencia'              => 'required|string|unique:productos,referencia,'.$producto->id,
            'descripcion'             => 'nullable|string',
            'precio_detal'            => 'required|numeric|min:0',
            'precio_mayoreo'          => 'nullable|numeric|min:0',
            'cantidad_minima_mayoreo' => 'nullable|integer|min:1',
            'stock'                   => 'required|integer|min:0',
            'categoria'               => 'required|string',
            'disponible_mayoreo'      => 'nullable|boolean',
            'destacado'               => 'nullable|boolean',
            'badge'                   => 'nullable|string|max:20',
            'imagen'                  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $data['imagen'] = $request->file('imagen')
                                      ->store('productos', 'public');
        }

        $data['disponible_mayoreo'] = $request->boolean('disponible_mayoreo');
        $data['destacado']          = $request->boolean('destacado');

        $producto->update($data);

        // ✅ CORREGIDO: redirigir al panel admin
        return redirect()->route('admin.productos.index')
                         ->with('success', '✅ Producto actualizado.');
    }

    public function destroy(Producto $producto)
    {
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }
        $producto->delete();

        return redirect()->route('admin.productos.index')
                         ->with('success', '🗑️ Producto eliminado.');
    }
}