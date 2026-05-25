@extends('layouts.app')
@section('title', 'Catálogo')
@section('content')

{{-- HERO CATÁLOGO --}}
<div class="cat-hero">
    <div class="cat-hero-glow"></div>
    <div class="cat-hero-inner">
        <div class="anim-1">
            <span class="cat-hero-label">⚡ CATÁLOGO</span>
            <h1 class="cat-hero-title">
                @if($categoriaActual && isset(App\Models\Producto::categorias()[$categoriaActual]))
                    {{ App\Models\Producto::categorias()[$categoriaActual]['icon'] }}
                    {{ App\Models\Producto::categorias()[$categoriaActual]['label'] }}
                @elseif($busqueda)
                    Resultados para "{{ $busqueda }}"
                @else
                    Todos los productos
                @endif
            </h1>
            <p class="cat-hero-desc">
                {{ $productos->total() }} producto{{ $productos->total() !== 1 ? 's' : '' }} disponible{{ $productos->total() !== 1 ? 's' : '' }}
            </p>
        </div>
    </div>
</div>

{{-- BARRA BÚSQUEDA --}}
<div class="cat-bar">
    <div class="cat-bar-inner">
        <form action="{{ route('productos.index') }}" method="GET" class="cat-search-form">
            @if($categoriaActual)
                <input type="hidden" name="categoria" value="{{ $categoriaActual }}">
            @endif
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <input type="text" name="q" value="{{ $busqueda }}"
                   placeholder="Buscar productos...">
        </form>

        @if($categoriaActual || $busqueda)
        <div class="cat-filters-active">
            @if($categoriaActual)
            <a href="{{ route('productos.index', $busqueda ? ['q' => $busqueda] : []) }}"
               class="cat-filter-chip">
                {{ App\Models\Producto::categorias()[$categoriaActual]['icon'] ?? '' }}
                {{ App\Models\Producto::categorias()[$categoriaActual]['label'] ?? $categoriaActual }}
                <span>✕</span>
            </a>
            @endif
            @if($busqueda)
            <a href="{{ route('productos.index', $categoriaActual ? ['categoria' => $categoriaActual] : []) }}"
               class="cat-filter-chip">
                "{{ $busqueda }}" <span>✕</span>
            </a>
            @endif
        </div>
        @endif
    </div>
</div>

{{-- PILLS CATEGORÍAS --}}
<div class="cat-cats-bar">
    <div class="cat-cats-inner">
        <a href="{{ route('productos.index', $busqueda ? ['q'=>$busqueda] : []) }}"
           class="cat-pill {{ !$categoriaActual ? 'active' : '' }}">
            Todos
        </a>
        @foreach(App\Models\Producto::categorias() as $slug => $info)
        <a href="{{ route('productos.index', array_merge($busqueda ? ['q'=>$busqueda] : [], ['categoria'=>$slug])) }}"
           class="cat-pill {{ $categoriaActual === $slug ? 'active' : '' }}">
            {{ $info['icon'] }} {{ $info['label'] }}
        </a>
        @endforeach
    </div>
</div>

{{-- GRID PRODUCTOS --}}
<div class="gv-section-dark">
    <div class="gv-wrap" style="padding-top:48px; padding-bottom:88px;">

        @if($productos->isEmpty())
        <div class="cat-empty">
            <div class="cat-empty-icon">🔍</div>
            <h3>No encontramos productos</h3>
            <p>Intenta con otra categoría o término de búsqueda.</p>
            <a href="{{ route('productos.index') }}" class="btn-primary"
               style="margin-top:24px; display:inline-flex;">
                Ver todos los productos
            </a>
        </div>

        @else
        <div class="cat-products-grid">
            @foreach($productos as $producto)
            <div class="gv-product-card reveal reveal-delay-{{ ($loop->index % 4) + 1 }}">

                {{-- Imagen --}}
                <div class="gv-product-img {{ ['gv-bg-blue','gv-bg-amber','gv-bg-green','gv-bg-red'][$loop->index % 4] }}">
                    @if($producto->imagen_url)
                        <img src="{{ $producto->imagen_url }}"
                             alt="{{ $producto->nombre }}"
                             class="cat-product-real-img">
                    @else
                        <span class="cat-product-emoji">
                            {{ App\Models\Producto::categorias()[$producto->categoria]['icon'] ?? '📦' }}
                        </span>
                    @endif

                    @if($producto->badge)
                    <span class="gv-badge {{ $producto->badge === 'OFERTA' ? 'gv-badge-yellow' : 'gv-badge-navy' }}">
                        {{ $producto->badge }}
                    </span>
                    @endif

                    @if($producto->stock === 0)
                    <div class="cat-no-stock">Sin stock</div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="gv-product-info">
                    <div class="gv-product-tags">
                        @if($producto->disponible_mayoreo)
                        <span class="gv-tag gv-tag-mayoreo">Mayoreo</span>
                        @else
                        <span class="gv-tag gv-tag-detal">Detal</span>
                        @endif
                        @if($producto->stock > 0 && $producto->stock <= 5)
                        <span class="gv-tag"
                              style="background:rgba(239,68,68,.1);color:#f87171;border:1px solid rgba(239,68,68,.2)">
                            Últimas {{ $producto->stock }} uds
                        </span>
                        @endif
                    </div>

                    <p class="gv-product-name">{{ $producto->nombre }}</p>
                    <p class="gv-product-ref">Ref. {{ $producto->referencia }}</p>

                    <div class="gv-product-footer">
                        <div class="gv-product-price">
                            <p class="price">{{ $producto->precio_formateado }}</p>
                            <p class="per">/ unidad — detal</p>
                            @if($producto->precio_mayoreo)
                            <p class="cat-price-mayoreo">
                                {{ $producto->precio_mayoreo_formateado }}
                                <span>mayoreo x{{ $producto->cantidad_minima_mayoreo }}</span>
                            </p>
                            @endif
                        </div>
                        <div class="cat-card-actions">
                            {{-- Botón ojo: abre modal --}}
                            <a href="#"
                               class="cat-btn-detail"
                               title="Vista rápida"
                               onclick="abrirModal(event, {
                                   nombre:        '{{ addslashes($producto->nombre) }}',
                                   ref:           '{{ $producto->referencia }}',
                                   desc:          '{{ addslashes($producto->descripcion ?? '') }}',
                                   precio:        '{{ $producto->precio_formateado }}',
                                   precioMayoreo: '{{ $producto->precio_mayoreo_formateado }}',
                                   minMayoreo:    '{{ $producto->cantidad_minima_mayoreo }}',
                                   mayoreo:       {{ $producto->disponible_mayoreo ? 'true' : 'false' }},
                                   stock:         {{ $producto->stock }},
                                   badge:         '{{ $producto->badge }}',
                                   imagen:        '{{ $producto->imagen_url }}',
                                   emoji:         '{{ App\Models\Producto::categorias()[$producto->categoria]["icon"] ?? "📦" }}',
                                   bg:            '{{ ["gv-bg-blue","gv-bg-amber","gv-bg-green","gv-bg-red"][$loop->index % 4] }}',
                                   detalle:       '{{ route("productos.show", $producto) }}'
                               })">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                     stroke-width="2" style="width:16px;height:16px">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </a>

                            {{-- Botón agregar al carrito --}}
                            @if($producto->stock > 0)
                            <button class="gv-add-btn"
                                    onclick="gvToast('✅ {{ addslashes($producto->nombre) }} agregado al carrito')">
                                +
                            </button>
                            @else
                            <button class="gv-add-btn" disabled
                                    style="opacity:.3;cursor:not-allowed;">+</button>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
            @endforeach
        </div>

        {{-- Paginación --}}
        @if($productos->hasPages())
        <div class="cat-pagination">
            {{ $productos->appends(request()->query())->links('pagination::simple-bootstrap-4') }}
        </div>
        @endif

        @endif

    </div>
</div>

{{-- MODAL PREVISUALIZACIÓN --}}
<div id="gv-modal" class="gv-modal-overlay" onclick="cerrarModal(event)">
    <div class="gv-modal-box">

        <button class="gv-modal-close" onclick="cerrarModal()">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"
                 style="width:18px;height:18px">
                <path d="M18 6 6 18M6 6l12 12"/>
            </svg>
        </button>

        <div class="gv-modal-inner">

            {{-- Imagen modal --}}
            <div class="gv-modal-img-wrap">
                <div id="modal-img-container" class="gv-modal-img gv-bg-blue">
                    <img id="modal-img" src="" alt="" style="display:none;width:100%;height:100%;object-fit:cover;">
                    <span id="modal-emoji" style="font-size:72px;"></span>
                </div>
                <span id="modal-badge" class="gv-badge gv-badge-yellow"
                      style="display:none;position:absolute;top:16px;left:16px;"></span>
            </div>

            {{-- Info modal --}}
            <div class="gv-modal-info">

                <div id="modal-tags" style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:16px;"></div>

                <h2 id="modal-nombre" class="gv-modal-title"></h2>
                <p  id="modal-ref"    class="gv-modal-ref"></p>
                <p  id="modal-desc"   class="gv-modal-desc"></p>

                <div class="gv-modal-price-box">
                    <div class="gv-modal-price-row">
                        <span class="gv-modal-price-label">Precio detal</span>
                        <span id="modal-precio" class="gv-modal-price-big"></span>
                        <span class="gv-modal-price-unit">/ unidad</span>
                    </div>
                    <div id="modal-mayoreo-row" class="gv-modal-price-row" style="display:none;">
                        <span class="gv-modal-price-label">Precio mayoreo</span>
                        <span id="modal-precio-mayoreo" class="gv-modal-price-big mayoreo"></span>
                        <span id="modal-min-mayoreo" class="gv-modal-price-unit"></span>
                    </div>
                </div>

                <div id="modal-stock-row" class="gv-modal-stock-row"></div>

                <div class="gv-modal-actions">
                    <button id="modal-btn-agregar" class="btn-primary" style="flex:1;"
                            onclick="agregarDesdeModal()">
                        Agregar al carrito
                    </button>
                    <a id="modal-btn-detalle" href="#" class="btn-outline-light">
                        Ver detalle completo
                    </a>
                    <a id="modal-btn-whatsapp" href="#" target="_blank"
                       class="gv-modal-whatsapp">
                        📱 WhatsApp
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.querySelectorAll('.gv-product-card').forEach((el, i) => {
    setTimeout(() => el.classList.add('visible'), i * 60);
});

let nombreModal = '';

function abrirModal(e, p) {
    e.preventDefault();
    nombreModal = p.nombre;

    const img   = document.getElementById('modal-img');
    const emoji = document.getElementById('modal-emoji');
    const cont  = document.getElementById('modal-img-container');
    cont.className = 'gv-modal-img ' + p.bg;

    if (p.imagen) {
        img.src = p.imagen;
        img.style.display = 'block';
        emoji.style.display = 'none';
    } else {
        img.style.display = 'none';
        emoji.textContent = p.emoji;
        emoji.style.display = 'block';
    }

    const badge = document.getElementById('modal-badge');
    if (p.badge) {
        badge.textContent = p.badge;
        badge.className = 'gv-badge ' + (p.badge === 'OFERTA' ? 'gv-badge-yellow' : 'gv-badge-navy');
        badge.style.display = 'inline-flex';
    } else {
        badge.style.display = 'none';
    }

    document.getElementById('modal-tags').innerHTML = p.mayoreo
        ? '<span class="gv-tag gv-tag-mayoreo">Mayoreo</span>'
        : '<span class="gv-tag gv-tag-detal">Detal</span>';

    document.getElementById('modal-nombre').textContent = p.nombre;
    document.getElementById('modal-ref').textContent    = 'Ref. ' + p.ref;
    document.getElementById('modal-desc').textContent   = p.desc || '';
    document.getElementById('modal-precio').textContent = p.precio;

    const rowMayoreo = document.getElementById('modal-mayoreo-row');
    if (p.precioMayoreo && p.mayoreo) {
        document.getElementById('modal-precio-mayoreo').textContent = p.precioMayoreo;
        document.getElementById('modal-min-mayoreo').textContent    = 'mín. ' + p.minMayoreo + ' uds';
        rowMayoreo.style.display = 'flex';
    } else {
        rowMayoreo.style.display = 'none';
    }

    const stockRow = document.getElementById('modal-stock-row');
    if (p.stock > 10) {
        stockRow.innerHTML = '<span style="width:8px;height:8px;border-radius:50%;background:#34d399;box-shadow:0 0 8px rgba(52,211,153,.5);flex-shrink:0;display:inline-block;margin-right:8px;"></span><span style="color:#34d399;font-weight:700;font-size:13px;">En stock (' + p.stock + ' disponibles)</span>';
    } else if (p.stock > 0) {
        stockRow.innerHTML = '<span style="width:8px;height:8px;border-radius:50%;background:#facc15;box-shadow:0 0 8px rgba(250,204,21,.5);flex-shrink:0;display:inline-block;margin-right:8px;"></span><span style="color:#facc15;font-weight:700;font-size:13px;">Últimas ' + p.stock + ' unidades</span>';
    } else {
        stockRow.innerHTML = '<span style="width:8px;height:8px;border-radius:50%;background:#f87171;box-shadow:0 0 8px rgba(248,113,113,.5);flex-shrink:0;display:inline-block;margin-right:8px;"></span><span style="color:#f87171;font-weight:700;font-size:13px;">Sin stock</span>';
    }

    const btnAgregar = document.getElementById('modal-btn-agregar');
    if (p.stock > 0) {
        btnAgregar.disabled = false;
        btnAgregar.style.opacity = '1';
        btnAgregar.style.cursor = 'pointer';
        btnAgregar.textContent = 'Agregar al carrito';
    } else {
        btnAgregar.disabled = true;
        btnAgregar.style.opacity = '.4';
        btnAgregar.style.cursor = 'not-allowed';
        btnAgregar.textContent = 'Sin stock';
    }

    document.getElementById('modal-btn-detalle').href =  p.detalle;
    document.getElementById('modal-btn-whatsapp').href =
        'https://wa.me/573022099810?text=Hola,%20quiero%20información%20sobre%20' + encodeURIComponent(p.nombre);

    document.getElementById('gv-modal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function cerrarModal(e) {
    if (e && e.target !== document.getElementById('gv-modal') && !e.target.closest('.gv-modal-close')) return;
    document.getElementById('gv-modal').classList.remove('active');
    document.body.style.overflow = '';
}

function agregarDesdeModal() {
    gvToast('✅ ' + nombreModal + ' agregado al carrito');
    document.getElementById('gv-modal').classList.remove('active');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        document.getElementById('gv-modal').classList.remove('active');
        document.body.style.overflow = '';
    }
});
</script>
@endpush

@endsection