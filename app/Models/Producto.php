<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'nombre', 'referencia', 'descripcion',
        'precio_detal', 'precio_mayoreo',
        'cantidad_minima_mayoreo', 'stock',
        'imagen', 'categoria',
        'disponible_mayoreo', 'activo',
        'destacado', 'badge',
    ];

    protected $casts = [
        'disponible_mayoreo' => 'boolean',
        'activo'             => 'boolean',
        'destacado'          => 'boolean',
        'precio_detal'       => 'float',
        'precio_mayoreo'     => 'float',
    ];

    public static function categorias(): array
    {
        return [
            'iluminacion'  => ['label' => 'Iluminación',  'icon' => '💡'],
            'tomas'        => ['label' => 'Tomas',         'icon' => '🔌'],
            'cables'       => ['label' => 'Cables',        'icon' => '🔶'],
            'obra-blanca'  => ['label' => 'Obra blanca',   'icon' => '🏠'],
            'pinturas'     => ['label' => 'Pinturas',      'icon' => '🎨'],
            'herramientas' => ['label' => 'Herramientas',  'icon' => '🔧'],
        ];
    }

    public function getPrecioFormateadoAttribute(): string
    {
        return '$' . number_format($this->precio_detal, 0, ',', '.');
    }

    public function getPrecioMayoreoFormateadoAttribute(): string
    {
        if (!$this->precio_mayoreo) return '';
        return '$' . number_format($this->precio_mayoreo, 0, ',', '.');
    }

    public function getImagenUrlAttribute(): string
    {
        if ($this->imagen) {
            return asset('storage/' . $this->imagen);
        }
        return '';
    }
}