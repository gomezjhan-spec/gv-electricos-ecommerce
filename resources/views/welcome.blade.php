<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        GV Eléctricos | Ecommerce Profesional
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body>

<!-- =========================================================
NAVBAR
========================================================= -->

<nav class="gv-nav">

    <div class="gv-nav-inner">

        <!-- LOGO -->
        <a href="#" class="gv-logo">

            <div class="gv-logo-icon">

                <!-- ICONO PEQUEÑO -->
                <img
                    src="{{ asset('images/icono.png') }}"
                    alt="GV"
                    class="gv-logo-img"
                >

            </div>

            <div class="gv-logo-text">

                <span class="brand">
                    GV ELÉCTRICOS
                </span>

                <span class="sub">
                    Y ACABADOS
                </span>

            </div>

        </a>

        <!-- SEARCH -->
        <div class="gv-search-wrap">

            <form
                action="#"
                method="GET"
                class="gv-search-form"
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="2"
                    stroke="currentColor"
                    class="gv-search-icon"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m21 21-4.35-4.35m0 0
                        A7.95 7.95 0 1 0 5.4 5.4
                        a7.95 7.95 0 0 0 11.25 11.25Z"
                    />

                </svg>

                <input
                    type="text"
                    class="gv-search"
                    placeholder="Buscar lámparas, cables, breakers..."
                >

            </form>

        </div>

        <!-- LINKS -->
        <ul class="gv-nav-links">

            <li>
                <a href="#" class="active">
                    Inicio
                </a>
            </li>

            <li>
                <a href="#">
                    Catálogo
                </a>
            </li>

            <li>
                <a href="#">
                    Mayoreo
                </a>
            </li>

            <li>
                <a href="#">
                    Promociones
                </a>
            </li>

        </ul>

        <!-- ACTIONS -->
        <div class="gv-nav-actions">

            <!-- CART -->
            <a href="#" class="gv-cart-btn">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="2"
                    stroke="currentColor"
                    class="gv-cart-icon"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M2.25 3h1.386a1.5
                        1.5 0 0 1 1.415
                        1.022L5.383 5.25m0 0
                        L7.5 14.25h9.75m-11.867-9
                        h13.364a1.5 1.5 0 0 1
                        1.464 1.825l-1.5
                        7.5a1.5 1.5 0 0 1
                        -1.464 1.175H7.5m0 0
                        a2.25 2.25 0 1 0 4.5 0m-4.5
                        0a2.25 2.25 0 1 0 4.5 0"
                    />

                </svg>

                <span class="gv-cart-badge">
                    0
                </span>

            </a>

            <!-- LOGIN -->
            <a href="#" class="btn-outline-light gv-login-btn">
                Ingresar
            </a>

            <!-- REGISTER -->
            <a href="#" class="btn-navy btn-premium">
                Registrarse
            </a>

        </div>

    </div>

</nav>

<!-- =========================================================
HERO
========================================================= -->

<section class="gv-hero">

    <!-- GRID -->
    <div class="gv-hero-grid"></div>

    <!-- GLOW -->
    <div class="gv-hero-glow-blue"></div>
    <div class="gv-hero-glow-yellow"></div>

    <!-- CONTENT -->
    <div class="gv-hero-inner">

        <!-- LEFT -->
        <div class="gv-hero-left">

            <div class="gv-hero-badge">
                ⚡ JAMUNDÍ, VALLE DEL CAUCA
            </div>

            <h1>
                Todo para tu
                hogar e

                <span>
                    instalación
                    eléctrica
                </span>
            </h1>

            <p class="gv-hero-desc">

                Iluminación, cables, acabados y obra blanca.
                Venta al detal y al por mayor para hogares,
                tiendas y constructoras en el Valle del Cauca.

            </p>

            <!-- BUTTONS -->
            <div class="gv-hero-btns">

                <a href="#" class="btn-yellow">
                    Ver catálogo
                </a>

                <a href="#" class="btn-outline-light">
                    Precios mayoreo
                </a>

            </div>

            <!-- STATS -->
            <div class="gv-hero-stats">

                <div class="gv-stat-box">

                    <div class="stat-num">
                        +500
                    </div>

                    <div class="stat-label">
                        Productos
                    </div>

                </div>

                <div class="gv-stat-box">

                    <div class="stat-num">
                        +120
                    </div>

                    <div class="stat-label">
                        Clientes frecuentes
                    </div>

                </div>

                <div class="gv-stat-box">

                    <div class="stat-num">
                        100%
                    </div>

                    <div class="stat-label">
                        Calidad garantizada
                    </div>

                </div>

            </div>

        </div>

        <!-- RIGHT -->
        <div class="gv-hero-right">

            <div class="gv-hero-logo-container">

                <div class="gv-logo-glow"></div>

                <!-- LOGO HORIZONTAL GRANDE -->
                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="GV Eléctricos"
                    class="gv-main-logo"
                >

            </div>

        </div>

    </div>

</section>

<!-- =========================================================
FEATURES
========================================================= -->

<section class="gv-features-section">

    <div class="gv-features-grid">

        <!-- CARD -->
        <div class="gv-feature-card">

            <div class="gv-feature-icon">
                ⚡
            </div>

            <h3>
                Productos Premium
            </h3>

            <p>
                Materiales eléctricos certificados
                para proyectos profesionales.
            </p>

        </div>

        <!-- CARD -->
        <div class="gv-feature-card">

            <div class="gv-feature-icon">
                🚚
            </div>

            <h3>
                Entrega Rápida
            </h3>

            <p>
                Distribución eficiente para hogares,
                negocios y constructoras.
            </p>

        </div>

        <!-- CARD -->
        <div class="gv-feature-card">

            <div class="gv-feature-icon">
                🛠️
            </div>

            <h3>
                Asesoría Técnica
            </h3>

            <p>
                Atención especializada para ayudarte
                en cada proyecto.
            </p>

        </div>

    </div>

</section>

</body>

</html>