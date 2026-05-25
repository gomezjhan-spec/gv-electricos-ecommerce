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

            <div class="gv-hero-badge anim-1">
                ⚡ JAMUNDÍ, VALLE DEL CAUCA
            </div>

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

                    <svg
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2.5"
                        style="width:16px;height:16px"
                    >
                        <path d="m9 18 6-6-6-6"/>
                    </svg>

                </a>

                <a
                    href="{{ url('/mayoreo') }}"
                    class="btn-outline-light"
                >
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
                >

            </div>

        </div>

    </div>

</section>

{{-- BÚSQUEDA RÁPIDA --}}
<div class="gv-quicksearch">

    <div class="gv-quicksearch-inner">

        <form action="{{ url('/productos') }}" method="GET">

            <svg
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <circle cx="11" cy="11" r="8"/>
                <path d="m21 21-4.35-4.35"/>
            </svg>

            <input
                type="text"
                name="q"
                placeholder="¿Qué estás buscando? — lámparas, cables, pinturas..."
            >

        </form>

    </div>

</div>

{{-- CATEGORÍAS --}}
<div class="gv-section-mid">

    <div class="gv-wrap">

        <div class="gv-cats-header reveal">

            <span class="section-label-dark">
                Explorar
            </span>

            <h2 class="section-title-dark">
                ¿Qué necesitas hoy?
            </h2>

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

            <a
                href="{{ url('/productos?categoria='.$slug) }}"
                class="gv-cat-card reveal reveal-delay-{{ $i+1 }}"
            >

                <div class="gv-cat-icon">
                    {{ $icon }}
                </div>

                <span class="gv-cat-name">
                    {{ $name }}
                </span>

            </a>

            @endforeach

        </div>

    </div>

</div>

{{-- SERVICIOS --}}
<div class="gv-section-light">

    <div class="gv-wrap">

        <div class="gv-features-header reveal">

            <span class="section-label-light">
                Por qué elegirnos
            </span>

            <h2 class="section-title-light">
                Servicio que marca<br>
                la diferencia
            </h2>

        </div>

        <div class="gv-features-grid">

            @foreach([
                ['🚚','Entrega rápida','Llevamos tus pedidos a Jamundí y municipios cercanos del Valle del Cauca sin complicaciones.'],
                ['🏷️','Precios mayoreo','Tarifas especiales para tiendas, constructoras y clientes frecuentes. Consúltanos sin compromiso.'],
                ['⭐','Clientes VIP','Acumula puntos en cada compra y accede a descuentos y promociones exclusivas para clientes fieles.'],
            ] as $i => [$icon,$title,$desc])

            <div class="gv-feature-card reveal reveal-delay-{{ $i+1 }}">

                <div class="gv-feature-icon">
                    {{ $icon }}
                </div>

                <h3>
                    {{ $title }}
                </h3>

                <p>
                    {{ $desc }}
                </p>

            </div>

            @endforeach

        </div>

    </div>

</div>

@endsection