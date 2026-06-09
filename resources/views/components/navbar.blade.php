<nav class="gv-nav">
    <div class="gv-nav-inner">

        {{-- LOGO --}}
        <a href="{{ url('/') }}" class="gv-logo">
            <img
                src="{{ asset('images/icono.png') }}"
                alt="GV"
                class="gv-logo-icon-img"
                onerror="this.style.display='none'"
            >
            <div class="gv-logo-text">
                <span class="brand">GV ELÉCTRICOS</span>
                <span class="sub">Y ACABADOS</span>
            </div>
        </a>

        {{-- SEARCH --}}
        <div class="gv-search-wrap">
            <form action="{{ url('/productos') }}" method="GET" class="gv-search-form">
                <svg class="gv-search-icon" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="m21 21-4.35-4.35"/>
                </svg>
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Buscar lámparas, cables, breakers..."
                    class="gv-search"
                    autocomplete="off"
                >
            </form>
        </div>

        {{-- LINKS --}}
        <ul class="gv-nav-links">
            <li>
                <a href="{{ url('/') }}"
                   class="{{ request()->is('/') ? 'active' : '' }}">
                    Inicio
                </a>
            </li>
            <li>
                <a href="{{ url('/productos') }}"
                   class="{{ request()->is('productos*') && !request('disponible_mayoreo') && !request('badge') ? 'active' : '' }}">
                    Catálogo
                </a>
            </li>
            <li>
                <a href="{{ url('/productos?disponible_mayoreo=1') }}"
                   class="{{ request('disponible_mayoreo') ? 'active' : '' }}">
                    Mayoreo
                </a>
            </li>
            <li>
                <a href="{{ url('/productos?badge=OFERTA') }}"
                   class="{{ request('badge') === 'OFERTA' ? 'active' : '' }}">
                    Promociones
                </a>
            </li>
        </ul>

        {{-- ACTIONS --}}
        <div class="gv-nav-actions">

            {{-- CARRITO: abre mini-panel lateral en vez de ir a ruta inexistente --}}
            <button type="button" class="gv-cart-btn" title="Carrito"
                    onclick="gvToast('🛒 El carrito estará disponible próximamente')">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9"  cy="21" r="1"/>
                    <circle cx="20" cy="21" r="1"/>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                </svg>
                <span class="gv-cart-badge">0</span>
            </button>

            {{-- SESIÓN --}}
            @auth

                <div class="gv-user-menu">
                    <button id="user-dd-btn" class="gv-user-btn" type="button">
                        <span class="gv-user-avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>
                        <span>{{ Str::limit(auth()->user()->name, 10) }}</span>
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2.5">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>

                    <div id="user-dropdown" class="gv-dropdown">

                        @hasrole('admin')
                        <a href="{{ route('admin.dashboard') }}">⚡ Panel admin</a>
                        <a href="{{ route('admin.productos.create') }}">➕ Nuevo producto</a>
                        <div class="gv-dropdown-divider"></div>
                        @endhasrole

                        <a href="{{ url('/perfil') }}">👤 Mi perfil</a>
                        <a href="{{ url('/pedidos') }}">📦 Mis pedidos</a>

                        @hasanyrole('mayorista|cliente')
                        <a href="#">⭐ Mis puntos</a>
                        @endhasanyrole

                        <div class="gv-dropdown-divider"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">🚪 Cerrar sesión</button>
                        </form>

                    </div>
                </div>

            @else
                <a href="{{ url('/login') }}" class="btn-outline-light">Ingresar</a>
                <a href="{{ url('/register') }}" class="btn-navy">Registrarse</a>
            @endauth

        </div>

    </div>
</nav>