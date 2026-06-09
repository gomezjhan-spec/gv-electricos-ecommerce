@extends('layouts.app')
@section('title','GV Eléctricos y Acabados — Jamundí, Valle del Cauca')
@section('content')

{{-- HERO --}}
<section class="gv-hero">
    <div class="gv-hero-grid"></div>
    <div class="gv-hero-glow-blue"></div>
    <div class="gv-hero-glow-yellow"></div>

    <div class="gv-hero-inner">

        {{-- IZQUIERDA --}}
        <div class="gv-hero-left">
            <div class="gv-hero-badge anim-1">⚡ JAMUNDÍ, VALLE DEL CAUCA</div>

            <h1 class="anim-2">
                Todo para tu hogar e<br>
                <span>instalación eléctrica</span>
            </h1>

            <p class="gv-hero-desc anim-3">
                Iluminación, cables, acabados y obra blanca.
                Venta al detal y al por mayor para hogares,
                tiendas y constructoras en el Valle del Cauca.
            </p>

            <div class="gv-hero-btns anim-4">
                <a href="{{ url('/productos') }}" class="btn-primary">
                    Ver catálogo
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"
                         stroke-width="2.5" style="width:16px;height:16px">
                        <path d="m9 18 6-6-6-6"/>
                    </svg>
                </a>
                <a href="{{ url('/productos?disponible_mayoreo=1') }}" class="btn-outline-light">
                    Precios mayoreo
                </a>
            </div>

            <div class="gv-hero-stats anim-5">
                <div>
                    <p class="stat-num">+500</p>
                    <p class="stat-label">Productos</p>
                </div>
                <div>
                    <p class="stat-num">+120</p>
                    <p class="stat-label">Clientes frecuentes</p>
                </div>
                <div>
                    <p class="stat-num">100%</p>
                    <p class="stat-label">Calidad garantizada</p>
                </div>
            </div>
        </div>

        {{-- DERECHA --}}
        <div class="gv-hero-right anim-right">
            <div class="gv-hero-visual">
                <div class="gv-logo-glow"></div>
                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="GV Eléctricos"
                    class="gv-hero-logo"
                    onerror="this.style.display='none'"
                >
            </div>
        </div>

    </div>
</section>

{{-- BÚSQUEDA RÁPIDA --}}
<div class="gv-quicksearch">
    <div class="gv-quicksearch-inner">
        <form action="{{ url('/productos') }}" method="GET">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/>
                <path d="m21 21-4.35-4.35"/>
            </svg>
            <input type="text" name="q"
                   placeholder="¿Qué estás buscando? — lámparas, cables, pinturas..."
                   autocomplete="off">
        </form>
    </div>
</div>

{{-- CATEGORÍAS --}}
<div class="gv-section-mid">
    <div class="gv-wrap">
        <div class="gv-cats-header reveal">
            <span class="section-label-dark">Explorar</span>
            <h2 class="section-title-dark">¿Qué necesitas hoy?</h2>
        </div>
        <div class="gv-cats">
            @foreach(App\Models\Producto::categorias() as $i => [$slug => $info])
            @endforeach
            @php
                $cats = App\Models\Producto::categorias();
                $i = 0;
            @endphp
            @foreach($cats as $slug => $info)
            <a href="{{ url('/productos?categoria='.$slug) }}"
               class="gv-cat-card reveal reveal-delay-{{ ($i % 4) + 1 }}">
                <div class="gv-cat-icon">{{ $info['icon'] }}</div>
                <span class="gv-cat-name">{{ $info['label'] }}</span>
            </a>
            @php $i++ @endphp
            @endforeach
        </div>
    </div>
</div>

{{-- SERVICIOS --}}
<div class="gv-section-light">
    <div class="gv-wrap">
        <div class="gv-features-header reveal">
            <span class="section-label-light">Por qué elegirnos</span>
            <h2 class="section-title-light">Servicio que marca<br>la diferencia</h2>
        </div>
        <div class="gv-features-grid">
            @foreach([
                ['🚚','Entrega rápida','Llevamos tus pedidos a Jamundí y municipios cercanos del Valle del Cauca sin complicaciones.'],
                ['🏷️','Precios mayoreo','Tarifas especiales para tiendas, constructoras y clientes frecuentes. Consúltanos sin compromiso.'],
                ['⭐','Clientes VIP','Acumula puntos en cada compra y accede a descuentos y promociones exclusivas para clientes fieles.'],
            ] as $i => [$icon,$title,$desc])
            <div class="gv-feature-card reveal reveal-delay-{{ $i+1 }}">
                <div class="gv-feature-icon">{{ $icon }}</div>
                <h3>{{ $title }}</h3>
                <p>{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- PRODUCTOS DESTACADOS DESDE LA BD --}}
<div class="gv-section-dark">
    <div class="gv-wrap">
        <div class="gv-products-header reveal">
            <div>
                <span class="section-label-dark">Destacados</span>
                <h2 class="section-title-dark">Productos más vendidos</h2>
            </div>
            <a href="{{ url('/productos') }}">
                Ver todos
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"
                     stroke-width="2.5" style="width:14px;height:14px">
                    <path d="m9 18 6-6-6-6"/>
                </svg>
            </a>
        </div>

        @if($destacados->isEmpty())
        <div class="cat-empty" style="padding:40px 20px;">
            <div class="cat-empty-icon">📦</div>
            <h3>Cargando catálogo</h3>
            <p>Pronto tendremos productos disponibles para ti.</p>
        </div>
        @else
        <div class="gv-products-grid">
            @php $bgs = ['gv-bg-blue','gv-bg-amber','gv-bg-green','gv-bg-red']; @endphp
            @foreach($destacados as $i => $producto)
            <div class="gv-product-card reveal reveal-delay-{{ ($i % 4) + 1 }}">

                <div class="gv-product-img {{ $bgs[$i % 4] }}">
                    @if($producto->imagen_url)
                        <img src="{{ $producto->imagen_url }}"
                             alt="{{ $producto->nombre }}"
                             class="cat-product-real-img">
                    @else
                        <span style="font-size:52px;">
                            {{ App\Models\Producto::categorias()[$producto->categoria]['icon'] ?? '📦' }}
                        </span>
                    @endif

                    @if($producto->badge)
                    <span class="gv-badge {{ $producto->badge === 'OFERTA' ? 'gv-badge-yellow' : 'gv-badge-navy' }}">
                        {{ $producto->badge }}
                    </span>
                    @endif
                </div>

                <div class="gv-product-info">
                    <div class="gv-product-tags">
                        <span class="gv-tag {{ $producto->disponible_mayoreo ? 'gv-tag-mayoreo' : 'gv-tag-detal' }}">
                            {{ $producto->disponible_mayoreo ? 'Mayoreo' : 'Detal' }}
                        </span>
                    </div>
                    <p class="gv-product-name">{{ $producto->nombre }}</p>
                    <p class="gv-product-ref">Ref. {{ $producto->referencia }}</p>
                    <div class="gv-product-footer">
                        <div class="gv-product-price">
                            <p class="price">{{ $producto->precio_formateado }}</p>
                            <p class="per">/ unidad</p>
                        </div>
                        <a href="{{ route('productos.show', $producto) }}"
                           class="gv-add-btn"
                           title="Ver producto"
                           style="text-decoration:none;font-size:16px;">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                 stroke-width="2.5" style="width:16px;height:16px">
                                <path d="m9 18 6-6-6-6"/>
                            </svg>
                        </a>
                    </div>
                </div>

            </div>
            @endforeach
        </div>
        @endif

    </div>
</div>

{{-- BANNER FIDELIZACIÓN --}}
<div class="gv-section-dark">
    <div class="gv-promo-wrap">
        <div class="gv-promo-container">
            <div class="gv-promo-inner reveal">
                <div class="gv-promo-glow"></div>
                <div class="gv-promo-bolt">⚡</div>
                <div class="gv-promo-content">
                    <div class="gv-promo-label">⭐ Programa de fidelización</div>
                    <h2 class="gv-promo-title">
                        Clientes frecuentes obtienen<br>descuentos exclusivos
                    </h2>
                    <p class="gv-promo-desc">
                        Regístrate, acumula puntos con cada compra y accede a
                        promociones únicas solo para clientes fieles de GV Eléctricos.
                    </p>
                    <div class="gv-loyalty-badge">
                        🎁 Hasta 15% de descuento para clientes VIP
                    </div>
                </div>
                <div class="gv-promo-action">
                    @auth
                    <a href="{{ url('/pedidos') }}" class="btn-yellow">
                        Mis pedidos ⚡
                    </a>
                    @else
                    <a href="{{ url('/register') }}" class="btn-yellow">
                        Registrarme gratis ⚡
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

@endsection