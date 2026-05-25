@extends('layouts.app')
@section('title', $producto->nombre)
@section('content')

<div class="gv-section-dark">
    <div class="gv-wrap">

        {{-- Breadcrumb --}}
        <div class="cat-breadcrumb">
            <a href="{{ route('productos.index') }}">Catálogo</a>
            <span>›</span>
            <a href="{{ route('productos.index', ['categoria' => $producto->categoria]) }}">
                {{ App\Models\Producto::categorias()[$producto->categoria]['label'] ?? $producto->categoria }}
            </a>
            <span>›</span>
            <span>{{ $producto->nombre }}</span>
        </div>

        {{-- Detalle --}}
        <div class="cat-detail-grid">

            {{-- Imagen --}}
         <div class="cat-detail-img-wrap">

    <div class="cat-detail-img {{ ['gv-bg-blue','gv-bg-amber','gv-bg-green','gv-bg-red'][crc32($producto->categoria) % 4] }}">

        @if($producto->imagen_url)

            <img
                src="{{ $producto->imagen_url }}"
                alt="{{ $producto->nombre }}"
                style="
                    width:100%;
                    max-width:520px;
                    height:520px;
                    object-fit:contain;
                    display:block;
                    margin:auto;
                "
            >

        @else

            <span style="font-size:80px;">
                {{ App\Models\Producto::categorias()[$producto->categoria]['icon'] ?? '📦' }}
            </span>

        @endif
                    @if($producto->badge)
                    <span class="gv-badge {{ $producto->badge === 'OFERTA' ? 'gv-badge-yellow' : 'gv-badge-navy' }}"
                          style="position:absolute;top:20px;left:20px;">
                        {{ $producto->badge }}
                    </span>
                    @endif
                </div>
            </div>

            {{-- Info --}}
            <div class="cat-detail-info anim-1">

                <div class="gv-product-tags" style="margin-bottom:16px;">
                    @if($producto->disponible_mayoreo)
                    <span class="gv-tag gv-tag-mayoreo">Mayoreo disponible</span>
                    @endif
                    <span class="gv-tag" style="background:rgba(255,255,255,.06);color:#94a3b8;border:1px solid rgba(255,255,255,.1);">
                        {{ App\Models\Producto::categorias()[$producto->categoria]['label'] ?? $producto->categoria }}
                    </span>
                </div>

                <h1 class="cat-detail-title">{{ $producto->nombre }}</h1>
                <p class="cat-detail-ref">Ref. {{ $producto->referencia }}</p>

                @if($producto->descripcion)
                <p class="cat-detail-desc">{{ $producto->descripcion }}</p>
                @endif

                {{-- Precios --}}
                <div class="cat-price-box">
                    <div class="cat-price-row">
                        <span class="cat-price-label">Precio detal</span>
                        <span class="cat-price-big">{{ $producto->precio_formateado }}</span>
                        <span class="cat-price-unit">/ unidad</span>
                    </div>
                    @if($producto->precio_mayoreo)
                    <div class="cat-price-row mayoreo">
                        <span class="cat-price-label">Precio mayoreo</span>
                        <span class="cat-price-big mayoreo">{{ $producto->precio_mayoreo_formateado }}</span>
                        <span class="cat-price-unit">mín. {{ $producto->cantidad_minima_mayoreo }} unidades</span>
                    </div>
                    @endif
                </div>

                {{-- Stock --}}
                <div class="cat-stock-row">
                    @if($producto->stock > 10)
                        <span class="cat-stock-dot green"></span>
                        <span style="color:#34d399;font-weight:700;font-size:13px;">En stock ({{ $producto->stock }} disponibles)</span>
                    @elseif($producto->stock > 0)
                        <span class="cat-stock-dot yellow"></span>
                        <span style="color:#facc15;font-weight:700;font-size:13px;">Últimas {{ $producto->stock }} unidades</span>
                    @else
                        <span class="cat-stock-dot red"></span>
                        <span style="color:#f87171;font-weight:700;font-size:13px;">Sin stock</span>
                    @endif
                </div>

                {{-- Acciones --}}
                <div class="cat-detail-actions">
                    @if($producto->stock > 0)
                    <button class="btn-primary" onclick="gvToast('✅ {{ addslashes($producto->nombre) }} agregado al carrito')" style="flex:1;">
                        Agregar al carrito
                    </button>
                    @else
                    <button class="btn-primary" disabled style="flex:1;opacity:.4;cursor:not-allowed;">
                        Sin stock
                    </button>
                    @endif
                    <a href="https://wa.me/573022099810?text=Hola,%20quiero%20información%20sobre%20{{ urlencode($producto->nombre) }}"
                       target="_blank"
                       class="cat-btn-whatsapp">
                        📱 Consultar por WhatsApp
                    </a>
                </div>

            </div>
        </div>

        {{-- Relacionados --}}
        @if($relacionados->isNotEmpty())
        <div style="margin-top:80px;">
            <span class="section-label-dark">Más productos</span>
            <h2 class="section-title-dark" style="margin-bottom:32px;">
                También te puede interesar
            </h2>
            <div class="gv-products-grid">
                @foreach($relacionados as $p)
                <div class="gv-product-card">
                    <div class="gv-product-img {{ ['gv-bg-blue','gv-bg-amber','gv-bg-green','gv-bg-red'][$loop->index % 4] }}">
                        @if($p->imagen_url)
                            <img src="{{ $p->imagen_url }}" alt="{{ $p->nombre }}" class="cat-product-real-img">
                        @else
                            <span style="font-size:48px;">{{ App\Models\Producto::categorias()[$p->categoria]['icon'] ?? '📦' }}</span>
                        @endif
                    </div>
                    <div class="gv-product-info">
                        <p class="gv-product-name">{{ $p->nombre }}</p>
                        <p class="gv-product-ref">Ref. {{ $p->referencia }}</p>
                        <div class="gv-product-footer">
                            <div class="gv-product-price">
                                <p class="price">{{ $p->precio_formateado }}</p>
                                <p class="per">/ unidad</p>
                            </div>
                            <a href="{{ route('productos.show', $p) }}" class="gv-add-btn" style="text-decoration:none;font-size:16px;">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="width:16px;height:16px">
                                    <path d="m9 18 6-6-6-6"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>

@endsection



<style>

.cat-detail-grid{
    display:grid;
    grid-template-columns: 1fr 1fr;
    gap:60px;
    align-items:center;
    padding:40px 0;
}

.cat-detail-img-wrap{
    width:100%;
}

.cat-detail-img{
    width:100%;
    min-height:600px;
    border-radius:24px;
    background:#081120;
    display:flex;
    align-items:center;
    justify-content:center;
    overflow:hidden;
    padding:40px;
}

.cat-detail-info{
    width:100%;
}

@media(max-width:900px){

    .cat-detail-grid{
        grid-template-columns:1fr;
    }

    .cat-detail-img{
        min-height:auto;
        padding:20px;
    }

}

</style>