@extends('layouts.app')
@section('title','Inicio')
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
                <a href="{{ url('/mayoreo') }}" class="btn-outline-light">
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
                   placeholder="¿Qué estás buscando? — lámparas, cables, pinturas...">
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
            @foreach([
                ['💡','Iluminación',  'iluminacion'],
                ['🔌','Tomas',        'tomas'],
                ['🔶','Cables',       'cables'],
                ['🏠','Obra blanca',  'obra-blanca'],
                ['🎨','Pinturas',     'pinturas'],
                ['🔧','Herramientas', 'herramientas'],
            ] as $i => [$icon,$name,$slug])
            <a href="{{ url('/productos?categoria='.$slug) }}"
               class="gv-cat-card reveal reveal-delay-{{ $i+1 }}">
                <div class="gv-cat-icon">{{ $icon }}</div>
                <span class="gv-cat-name">{{ $name }}</span>
            </a>
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

{{-- PRODUCTOS DESTACADOS --}}
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
        <div class="gv-products-grid">
            @foreach([
                ['💡','Bombillo LED 9W E27',      'GV-BL-009', '$4.800',  'gv-bg-blue',  'OFERTA', 'gv-badge-yellow', true],
                ['🔦','Panel LED 18W Embutir',    'GV-LP-018', '$32.000', 'gv-bg-amber', 'NUEVO',  'gv-badge-navy',   true],
                ['🕯️','Lámpara Colgante Moderna', 'GV-LC-001', '$89.000', 'gv-bg-green',  null,     null,              true],
                ['⚡','Cable THHN 12 AWG x100m',  'GV-CA-012', '$145.000','gv-bg-red',   'TOP',    'gv-badge-navy',   false],
            ] as $i => [$icon,$name,$ref,$price,$bg,$badge,$badgeClass,$mayoreo])
            <div class="gv-product-card reveal reveal-delay-{{ $i+1 }}">
                <div class="gv-product-img {{ $bg }}">
                    {{ $icon }}
                    @if($badge)
                    <span class="gv-badge {{ $badgeClass }}">{{ $badge }}</span>
                    @endif
                </div>
                <div class="gv-product-info">
                    <div class="gv-product-tags">
                        <span class="gv-tag {{ $mayoreo ? 'gv-tag-mayoreo' : 'gv-tag-detal' }}">
                            {{ $mayoreo ? 'Mayoreo' : 'Detal' }}
                        </span>
                    </div>
                    <p class="gv-product-name">{{ $name }}</p>
                    <p class="gv-product-ref">Ref. {{ $ref }}</p>
                    <div class="gv-product-footer">
                        <div class="gv-product-price">
                            <p class="price">{{ $price }}</p>
                            <p class="per">/ unidad</p>
                        </div>
                        <button class="gv-add-btn"
                                onclick="gvToast('✅ {{ $name }} agregado al carrito')">+</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
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
                    <a href="{{ url('/register') }}" class="btn-yellow">
                        Registrarme gratis ⚡
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection