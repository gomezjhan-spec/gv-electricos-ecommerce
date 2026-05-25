<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GV Eléctricos y Acabados')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/icono.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>

    /* ══ RESET ══════════════════════════════════════════════════ */
    *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
    html { scroll-behavior:smooth; }
    body { font-family:'Inter',system-ui,sans-serif; background:#020617; color:white; overflow-x:hidden; }
    svg  { flex-shrink:0; }

    /* ══ ANIMACIONES ═════════════════════════════════════════════ */
    @keyframes fadeInUp   { from{opacity:0;transform:translateY(28px)} to{opacity:1;transform:translateY(0)} }
    @keyframes fadeInRight{ from{opacity:0;transform:translateX(40px)} to{opacity:1;transform:translateX(0)} }
    @keyframes float      { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-16px)} }
    @keyframes countUp    { from{opacity:0;transform:scale(.7)} to{opacity:1;transform:scale(1)} }

    .anim-1{animation:fadeInUp .65s .05s both cubic-bezier(.22,1,.36,1)}
    .anim-2{animation:fadeInUp .65s .15s both cubic-bezier(.22,1,.36,1)}
    .anim-3{animation:fadeInUp .65s .25s both cubic-bezier(.22,1,.36,1)}
    .anim-4{animation:fadeInUp .65s .35s both cubic-bezier(.22,1,.36,1)}
    .anim-5{animation:fadeInUp .65s .45s both cubic-bezier(.22,1,.36,1)}
    .anim-right{animation:fadeInRight .8s .2s both cubic-bezier(.22,1,.36,1)}
    .float{animation:float 5s ease-in-out infinite}

    .reveal{opacity:0;transform:translateY(32px);transition:opacity .7s cubic-bezier(.22,1,.36,1),transform .7s cubic-bezier(.22,1,.36,1)}
    .reveal.visible{opacity:1;transform:translateY(0)}
    .reveal-delay-1{transition-delay:.08s}
    .reveal-delay-2{transition-delay:.16s}
    .reveal-delay-3{transition-delay:.24s}
    .reveal-delay-4{transition-delay:.32s}

    /* ══ NAVBAR ══════════════════════════════════════════════════ */
    .gv-nav{
        position:fixed;top:0;left:0;width:100%;height:72px;
        background:rgba(2,6,23,.93);backdrop-filter:blur(20px);
        border-bottom:1px solid rgba(255,255,255,.06);z-index:999;
        transition:background .3s,box-shadow .3s;
    }
    .gv-nav.scrolled{background:rgba(2,6,23,.99);box-shadow:0 4px 40px rgba(0,0,0,.5)}
    .gv-nav-inner{
        width:100%;max-width:1280px;height:100%;margin:auto;
        padding:0 28px;display:flex;align-items:center;
        justify-content:space-between;gap:20px;
    }
    .gv-logo{display:flex;align-items:center;gap:12px;text-decoration:none;flex-shrink:0}
    .gv-logo-icon{
        width:44px;height:44px;border-radius:13px;
        background:linear-gradient(135deg,#0f1f3d,#1a3460);
        border:1px solid rgba(37,99,235,.35);
        display:flex;align-items:center;justify-content:center;
        transition:transform .3s,box-shadow .3s;
    }
    .gv-logo:hover .gv-logo-icon{transform:scale(1.07);box-shadow:0 0 22px rgba(37,99,235,.4)}
    .gv-logo-icon svg{width:24px;height:24px}
    .brand{display:block;font-size:14px;font-weight:800;color:white;letter-spacing:.2px}
    .sub{display:block;font-size:9px;font-weight:700;color:#60a5fa;letter-spacing:3px;margin-top:2px}
    .gv-search-wrap{flex:1;max-width:380px}
    .gv-search-form{position:relative}
    .gv-search-icon{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#64748b;width:15px;height:15px;pointer-events:none}
    .gv-search{
        width:100%;height:44px;background:#0b1628;
        border:1px solid rgba(255,255,255,.08);border-radius:13px;
        padding:0 16px 0 42px;color:white;outline:none;font-size:13px;
        transition:border-color .2s,box-shadow .2s;
    }
    .gv-search:focus{border-color:rgba(37,99,235,.5);box-shadow:0 0 0 3px rgba(37,99,235,.12)}
    .gv-search::placeholder{color:#475569}
    .gv-nav-links{display:flex;align-items:center;gap:30px;list-style:none}
    .gv-nav-links a{
        text-decoration:none;color:#94a3b8;font-size:13px;font-weight:600;
        position:relative;padding-bottom:3px;transition:color .25s;
    }
    .gv-nav-links a::after{
        content:'';position:absolute;bottom:0;left:0;width:0;height:2px;
        background:linear-gradient(90deg,#2563eb,#60a5fa);border-radius:2px;
        transition:width .3s cubic-bezier(.22,1,.36,1);
    }
    .gv-nav-links a:hover,.gv-nav-links a.active{color:white}
    .gv-nav-links a:hover::after,.gv-nav-links a.active::after{width:100%}
    .gv-nav-actions{display:flex;align-items:center;gap:10px}
    .gv-cart-btn{
        width:44px;height:44px;border-radius:13px;background:#0b1628;
        border:1px solid rgba(255,255,255,.08);display:flex;align-items:center;
        justify-content:center;position:relative;text-decoration:none;color:white;
        transition:border-color .2s,background .2s,transform .2s;
    }
    .gv-cart-btn svg{width:18px;height:18px}
    .gv-cart-btn:hover{border-color:rgba(37,99,235,.5);background:rgba(37,99,235,.1);transform:translateY(-1px)}
    .gv-cart-badge{
        position:absolute;top:-5px;right:-5px;width:18px;height:18px;
        border-radius:50%;background:#2563eb;border:2px solid #020617;
        display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:800;
    }
    .btn-outline-light{
        height:44px;padding:0 20px;border-radius:13px;
        border:1px solid rgba(255,255,255,.1);display:flex;align-items:center;
        text-decoration:none;color:#cbd5e1;font-size:13px;font-weight:600;
        transition:border-color .2s,color .2s,background .2s;white-space:nowrap;
    }
    .btn-outline-light:hover{border-color:rgba(255,255,255,.3);color:white;background:rgba(255,255,255,.05)}
    .btn-navy{
        height:44px;padding:0 20px;border-radius:13px;
        background:linear-gradient(135deg,#2563eb,#3b82f6);
        display:flex;align-items:center;text-decoration:none;color:white;
        font-size:13px;font-weight:700;box-shadow:0 4px 16px rgba(37,99,235,.35);
        transition:transform .2s,box-shadow .2s;white-space:nowrap;
    }
    .btn-navy:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(37,99,235,.5)}
    .btn-yellow{
        display:inline-flex;align-items:center;gap:8px;
        background:linear-gradient(135deg,#facc15,#fbbf24);color:#0f172a;
        font-size:14px;font-weight:800;padding:14px 32px;border-radius:16px;
        border:none;cursor:pointer;text-decoration:none;
        box-shadow:0 4px 20px rgba(250,204,21,.3);
        transition:transform .2s,box-shadow .2s;white-space:nowrap;
    }
    .btn-yellow:hover{transform:translateY(-2px);box-shadow:0 8px 28px rgba(250,204,21,.45)}
    .btn-primary{
        display:inline-flex;align-items:center;gap:8px;
        background:linear-gradient(135deg,#2563eb,#3b82f6);color:white;
        font-size:14px;font-weight:700;padding:14px 32px;border-radius:16px;
        border:none;cursor:pointer;text-decoration:none;
        box-shadow:0 4px 20px rgba(37,99,235,.35);
        transition:transform .2s,box-shadow .2s;
    }
    .btn-primary svg{width:16px;height:16px}
    .btn-primary:hover{transform:translateY(-2px);box-shadow:0 8px 28px rgba(37,99,235,.5)}
    .gv-user-menu{position:relative}
    .gv-user-btn{
        display:flex;align-items:center;gap:8px;height:44px;padding:0 14px;
        border-radius:13px;background:#0b1628;border:1px solid rgba(255,255,255,.08);
        color:white;cursor:pointer;font-size:13px;font-weight:600;
        transition:border-color .2s,background .2s;
    }
    .gv-user-btn:hover{border-color:rgba(37,99,235,.4);background:rgba(37,99,235,.08)}
    .gv-user-avatar{
        width:26px;height:26px;border-radius:8px;
        background:linear-gradient(135deg,#2563eb,#60a5fa);
        display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;
    }
    .gv-dropdown{
        display:none;position:absolute;right:0;top:calc(100% + 8px);width:196px;
        background:#0b1628;border:1px solid rgba(255,255,255,.08);border-radius:16px;
        overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,.6);z-index:200;
    }
    .gv-dropdown a,.gv-dropdown button{
        display:block;width:100%;padding:12px 18px;font-size:13px;font-weight:600;
        color:#cbd5e1;text-decoration:none;background:none;border:none;
        text-align:left;cursor:pointer;transition:background .15s,color .15s;
    }
    .gv-dropdown a:hover{background:rgba(255,255,255,.05);color:white}
    .gv-dropdown button:hover{background:rgba(239,68,68,.1);color:#f87171}
    .gv-dropdown-divider{border-top:1px solid rgba(255,255,255,.06)}

    /* ══ HERO ════════════════════════════════════════════════════ */
    .gv-hero{
        position:relative;min-height:100vh;
        display:flex;align-items:center;
        overflow:hidden;padding-top:72px;
    }
    .gv-hero-grid{
        position:absolute;inset:0;pointer-events:none;
        background-image:
            linear-gradient(rgba(255,255,255,.025) 1px,transparent 1px),
            linear-gradient(90deg,rgba(255,255,255,.025) 1px,transparent 1px);
        background-size:60px 60px;
    }
    .gv-hero-glow-blue{
        position:absolute;width:700px;height:700px;border-radius:50%;
        right:-250px;top:-250px;pointer-events:none;
        background:radial-gradient(circle,rgba(37,99,235,.14) 0%,transparent 70%);
    }
    .gv-hero-glow-yellow{
        position:absolute;width:450px;height:450px;border-radius:50%;
        left:-100px;bottom:-100px;pointer-events:none;
        background:radial-gradient(circle,rgba(250,204,21,.07) 0%,transparent 70%);
    }
    .gv-hero-inner{
        width:100%;max-width:1280px;margin:auto;padding:80px 28px;
        display:grid;grid-template-columns:1fr 1fr;
        align-items:center;gap:64px;position:relative;z-index:2;
    }
    .gv-hero-badge{
        display:inline-flex;align-items:center;gap:10px;
        padding:10px 20px;border-radius:999px;
        background:rgba(250,204,21,.08);border:1px solid rgba(250,204,21,.18);
        color:#facc15;font-size:11px;font-weight:700;letter-spacing:1.5px;
    }
    .gv-hero-left h1{
        font-size:clamp(2.6rem,4.5vw,4rem);line-height:1.08;
        font-weight:900;margin:22px 0 0;
    }
    .gv-hero-left h1 span{color:#facc15}
    .gv-hero-desc{margin-top:18px;max-width:500px;color:#64748b;line-height:1.85;font-size:16px;}
    .gv-hero-btns{display:flex;gap:14px;margin-top:38px;flex-wrap:wrap}
    .gv-hero-stats{
        display:flex;gap:44px;margin-top:48px;flex-wrap:wrap;
        padding-top:36px;border-top:1px solid rgba(255,255,255,.07);
    }
    .stat-num{font-size:34px;font-weight:900;color:white;line-height:1;animation:countUp .6s .5s both}
    .stat-label{margin-top:6px;color:#475569;font-size:13px}
    .gv-hero-right{display:flex;align-items:center;justify-content:center}
    .gv-hero-visual{position:relative;display:flex;justify-content:center}
    .gv-logo-glow{
        position:absolute;inset:-60px;border-radius:50%;
        background:radial-gradient(circle,rgba(37,99,235,.22) 0%,transparent 70%);
    }
    .gv-hero-logo{
        position:relative;z-index:1;max-width:400px;width:100%;
        filter:drop-shadow(0 28px 72px rgba(37,99,235,.28));
        animation:float 5s ease-in-out infinite;
    }

    /* ══ BÚSQUEDA RÁPIDA ═════════════════════════════════════════ */
    .gv-quicksearch{
        background:#050e1f;
        border-top:1px solid rgba(255,255,255,.04);
        border-bottom:1px solid rgba(255,255,255,.04);
        padding:16px 28px;
    }
    .gv-quicksearch-inner{max-width:680px;margin:0 auto;position:relative}
    .gv-quicksearch-inner svg{
        position:absolute;left:16px;top:50%;transform:translateY(-50%);
        width:15px;height:15px;color:#475569;pointer-events:none;
    }
    .gv-quicksearch input{
        width:100%;background:#0b1628;border:1px solid rgba(255,255,255,.07);
        border-radius:14px;color:white;font-size:14px;
        padding:13px 18px 13px 46px;outline:none;
        transition:border-color .2s,box-shadow .2s;
    }
    .gv-quicksearch input:focus{border-color:rgba(37,99,235,.45);box-shadow:0 0 0 3px rgba(37,99,235,.1)}
    .gv-quicksearch input::placeholder{color:#475569}

    /* ══ SECCIONES ═══════════════════════════════════════════════ */
    .gv-section-dark{background:#020617}
    .gv-section-mid{background:#050e1f}
    .gv-section-light{background:#f8fafc}
    .gv-wrap{width:100%;max-width:1280px;margin:0 auto;padding:88px 28px}

    .section-label-dark{display:block;font-size:11px;font-weight:700;letter-spacing:3px;text-transform:uppercase;margin-bottom:8px;color:#facc15;}
    .section-label-light{display:block;font-size:11px;font-weight:700;letter-spacing:3px;text-transform:uppercase;margin-bottom:8px;color:#2563eb;}
    .section-title-dark{font-size:clamp(1.8rem,3vw,2.5rem);font-weight:900;line-height:1.15;color:white}
    .section-title-light{font-size:clamp(1.8rem,3vw,2.5rem);font-weight:900;line-height:1.15;color:#0f172a}

    /* ══ CATEGORÍAS ══════════════════════════════════════════════ */
    .gv-cats-header{margin-bottom:44px}
    .gv-cats{display:grid;grid-template-columns:repeat(6,1fr);gap:16px;}
    .gv-cat-card{
        background:#0b1628;border:1px solid rgba(255,255,255,.06);
        border-radius:20px;padding:26px 14px;
        display:flex;flex-direction:column;align-items:center;gap:12px;
        text-decoration:none;cursor:pointer;position:relative;overflow:hidden;
        transition:border-color .25s,transform .25s,box-shadow .25s;
    }
    .gv-cat-card::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(37,99,235,.06),transparent);opacity:0;transition:opacity .3s;}
    .gv-cat-card:hover::before{opacity:1}
    .gv-cat-card:hover{border-color:rgba(37,99,235,.4);transform:translateY(-6px);box-shadow:0 20px 48px rgba(0,0,0,.4);}
    .gv-cat-icon{width:54px;height:54px;background:rgba(255,255,255,.04);border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:26px;transition:transform .3s,background .3s;}
    .gv-cat-card:hover .gv-cat-icon{transform:scale(1.14);background:rgba(37,99,235,.15)}
    .gv-cat-name{font-size:12px;font-weight:700;color:#94a3b8;text-align:center;transition:color .2s}
    .gv-cat-card:hover .gv-cat-name{color:white}

    /* ══ FEATURES ════════════════════════════════════════════════ */
    .gv-features-header{text-align:center;max-width:580px;margin:0 auto 56px}
    .gv-features-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;}
    .gv-feature-card{background:white;border-radius:24px;padding:40px 36px;border:1px solid #e2e8f0;transition:transform .3s,box-shadow .3s,border-color .3s;}
    .gv-feature-card:hover{transform:translateY(-8px);box-shadow:0 24px 60px rgba(15,23,42,.1);border-color:#dbeafe;}
    .gv-feature-icon{width:64px;height:64px;border-radius:18px;background:#eff6ff;display:flex;align-items:center;justify-content:center;font-size:28px;margin-bottom:22px;transition:transform .3s,background .3s;}
    .gv-feature-card:hover .gv-feature-icon{transform:scale(1.08);background:#dbeafe}
    .gv-feature-card h3{color:#0f172a;font-size:19px;font-weight:800;margin-bottom:12px}
    .gv-feature-card p{color:#64748b;line-height:1.8;font-size:14px}

    /* ══ PRODUCTOS ═══════════════════════════════════════════════ */
    .gv-products-header{display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:40px;flex-wrap:wrap;gap:16px;}
    .gv-products-header a{font-size:13px;font-weight:600;color:#60a5fa;text-decoration:none;display:inline-flex;align-items:center;gap:4px;transition:color .2s;}
    .gv-products-header a:hover{color:white}
    .gv-products-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;}
    .gv-product-card{background:#0b1628;border:1px solid rgba(255,255,255,.06);border-radius:22px;overflow:hidden;transition:border-color .3s,transform .3s,box-shadow .3s;}
    .gv-product-card:hover{transform:translateY(-8px);border-color:rgba(37,99,235,.4);box-shadow:0 24px 60px rgba(0,0,0,.5);}
    .gv-product-img{height:180px;position:relative;display:flex;align-items:center;justify-content:center;font-size:52px;overflow:hidden;transition:transform .4s;}
    .gv-product-card:hover .gv-product-img{transform:scale(1.04)}
    .gv-bg-blue  {background:linear-gradient(135deg,#1e3a5f,#0b1628)}
    .gv-bg-amber {background:linear-gradient(135deg,#2a1f00,#0b1628)}
    .gv-bg-green {background:linear-gradient(135deg,#052e16,#0b1628)}
    .gv-bg-red   {background:linear-gradient(135deg,#2d0a0a,#0b1628)}
    .gv-badge{position:absolute;top:14px;left:14px;font-size:10px;font-weight:800;letter-spacing:.8px;padding:5px 11px;border-radius:8px;text-transform:uppercase;z-index:2;}
    .gv-badge-navy  {background:rgba(11,22,40,.9);color:#60a5fa;border:1px solid rgba(37,99,235,.3)}
    .gv-badge-yellow{background:rgba(250,204,21,.15);color:#facc15;border:1px solid rgba(250,204,21,.3)}
    .gv-product-info{padding:22px}
    .gv-product-tags{display:flex;gap:6px;flex-wrap:wrap;margin-bottom:12px}
    .gv-tag{font-size:9px;font-weight:700;letter-spacing:.8px;padding:4px 10px;border-radius:7px;text-transform:uppercase;}
    .gv-tag-mayoreo{background:rgba(37,99,235,.15);color:#60a5fa;border:1px solid rgba(37,99,235,.2)}
    .gv-tag-detal  {background:rgba(16,185,129,.1);color:#34d399;border:1px solid rgba(16,185,129,.2)}
    .gv-product-name{font-size:15px;font-weight:800;color:white;line-height:1.35;margin-bottom:5px}
    .gv-product-ref{font-size:11px;color:#334155;margin-bottom:18px}
    .gv-product-footer{display:flex;align-items:center;justify-content:space-between}
    .gv-product-price .price{font-size:22px;font-weight:900;color:white;line-height:1}
    .gv-product-price .per{font-size:11px;color:#334155;margin-top:3px}
    .gv-add-btn{
        width:42px;height:42px;border-radius:13px;border:none;
        background:linear-gradient(135deg,#2563eb,#3b82f6);
        color:white;font-size:20px;font-weight:700;
        display:flex;align-items:center;justify-content:center;
        cursor:pointer;box-shadow:0 4px 14px rgba(37,99,235,.35);
        transition:transform .2s,box-shadow .2s;flex-shrink:0;
    }
    .gv-add-btn:hover{transform:scale(1.12);box-shadow:0 8px 20px rgba(37,99,235,.55)}

    /* ══ PROMO ═══════════════════════════════════════════════════ */
    .gv-promo-wrap{padding:0 28px 88px}
    .gv-promo-container{max-width:1280px;margin:0 auto}
    .gv-promo-inner{
        background:linear-gradient(135deg,#0c1e3d,#0b1628);
        border:1px solid rgba(37,99,235,.18);border-radius:28px;padding:60px 64px;
        display:flex;align-items:center;justify-content:space-between;
        gap:40px;position:relative;overflow:hidden;
    }
    .gv-promo-glow{position:absolute;right:-60px;top:-60px;width:400px;height:400px;border-radius:50%;pointer-events:none;background:radial-gradient(circle,rgba(37,99,235,.2) 0%,transparent 70%);}
    .gv-promo-bolt{position:absolute;right:60px;top:50%;transform:translateY(-50%);font-size:160px;opacity:.025;pointer-events:none;user-select:none;}
    .gv-promo-content{position:relative;z-index:1;max-width:560px}
    .gv-promo-label{display:inline-flex;align-items:center;gap:8px;font-size:11px;font-weight:700;letter-spacing:2.5px;color:#facc15;text-transform:uppercase;margin-bottom:16px;}
    .gv-promo-title{font-size:clamp(1.6rem,3vw,2.2rem);font-weight:900;color:white;line-height:1.2;margin-bottom:14px;}
    .gv-promo-desc{font-size:15px;color:#334155;line-height:1.75}
    .gv-loyalty-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(250,204,21,.08);border:1px solid rgba(250,204,21,.18);padding:8px 16px;border-radius:99px;font-size:12px;font-weight:700;color:#facc15;margin-top:20px;}
    .gv-promo-action{position:relative;z-index:1;flex-shrink:0}

    /* ══ FOOTER ══════════════════════════════════════════════════ */
    .gv-footer{background:#020617;border-top:1px solid rgba(255,255,255,.05)}
    .gv-footer-inner{max-width:1280px;margin:0 auto;padding:72px 28px 36px}
    .gv-footer-grid{display:grid;grid-template-columns:1.5fr 1fr 1fr 1fr;gap:48px;margin-bottom:56px;}
    .gv-footer-brand-name{font-size:16px;font-weight:900;color:white;letter-spacing:.2px}
    .gv-footer-brand-sub{display:block;font-size:9px;font-weight:700;letter-spacing:3px;color:#2563eb;margin-top:3px;margin-bottom:18px;}
    .gv-footer-brand p{font-size:13px;color:#334155;line-height:1.75}
    .gv-footer-badge{display:inline-flex;align-items:center;gap:6px;margin-top:20px;padding:8px 14px;border-radius:99px;background:rgba(250,204,21,.07);border:1px solid rgba(250,204,21,.12);font-size:11px;font-weight:700;color:#facc15;}
    .gv-footer-col h4{font-size:10px;font-weight:700;letter-spacing:2.5px;color:#1e293b;text-transform:uppercase;margin-bottom:20px;}
    .gv-footer-col ul{list-style:none}
    .gv-footer-col ul li{margin-bottom:12px}
    .gv-footer-col ul li a{font-size:13px;color:#334155;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:color .2s;}
    .gv-footer-col ul li a:hover{color:white}
    .gv-footer-bottom{border-top:1px solid rgba(255,255,255,.05);padding-top:28px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;}
    .gv-footer-bottom p{font-size:12px;color:#1e293b}
    .gv-footer-bottom span{color:#facc15}

    /* ══ TOAST ═══════════════════════════════════════════════════ */
    .gv-toast{position:fixed;bottom:28px;right:28px;z-index:9999;background:#0b1628;color:white;border:1px solid rgba(37,99,235,.35);font-size:13px;font-weight:600;padding:14px 22px;border-radius:16px;box-shadow:0 16px 48px rgba(0,0,0,.6);display:none;animation:fadeInUp .35s both;}

    /* ══ CATÁLOGO ════════════════════════════════════════════════ */
    .cat-hero{position:relative;background:#050e1f;padding:60px 28px 48px;overflow:hidden;}
    .cat-hero-glow{position:absolute;width:600px;height:300px;border-radius:50%;top:-100px;right:-100px;pointer-events:none;background:radial-gradient(circle,rgba(37,99,235,.12) 0%,transparent 70%);}
    .cat-hero-inner{max-width:1280px;margin:0 auto;position:relative;z-index:1}
    .cat-hero-label{display:inline-block;font-size:10px;font-weight:700;letter-spacing:3px;color:#facc15;text-transform:uppercase;margin-bottom:12px;}
    .cat-hero-title{font-size:clamp(1.8rem,4vw,2.8rem);font-weight:900;color:white;line-height:1.1;margin-bottom:10px;}
    .cat-hero-desc{font-size:14px;color:#475569;font-weight:500}
    .cat-bar{background:#020617;border-bottom:1px solid rgba(255,255,255,.05);padding:14px 28px;}
    .cat-bar-inner{max-width:1280px;margin:0 auto;display:flex;align-items:center;gap:16px;flex-wrap:wrap;}
    .cat-search-form{position:relative;flex:1;min-width:260px;max-width:440px;}
    .cat-search-form svg{position:absolute;left:14px;top:50%;transform:translateY(-50%);width:15px;height:15px;color:#475569;pointer-events:none;}
    .cat-search-form input{width:100%;background:#0b1628;border:1px solid rgba(255,255,255,.08);border-radius:12px;color:white;font-size:13px;padding:11px 16px 11px 42px;outline:none;font-family:inherit;transition:border-color .2s,box-shadow .2s;}
    .cat-search-form input:focus{border-color:rgba(37,99,235,.5);box-shadow:0 0 0 3px rgba(37,99,235,.1);}
    .cat-search-form input::placeholder{color:#475569}
    .cat-filters-active{display:flex;gap:8px;flex-wrap:wrap}
    .cat-filter-chip{display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:99px;font-size:12px;font-weight:600;background:rgba(37,99,235,.15);color:#60a5fa;border:1px solid rgba(37,99,235,.25);text-decoration:none;transition:background .2s,color .2s;}
    .cat-filter-chip span{font-size:10px;opacity:.7}
    .cat-filter-chip:hover{background:rgba(239,68,68,.15);color:#f87171;border-color:rgba(239,68,68,.25)}
    .cat-cats-bar{background:#020617;border-bottom:1px solid rgba(255,255,255,.05);padding:12px 28px;overflow-x:auto;}
    .cat-cats-bar::-webkit-scrollbar{height:0}
    .cat-cats-inner{max-width:1280px;margin:0 auto;display:flex;align-items:center;gap:10px;white-space:nowrap;}
    .cat-pill{display:inline-flex;align-items:center;gap:6px;padding:8px 18px;border-radius:99px;font-size:13px;font-weight:600;text-decoration:none;background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.07);color:#64748b;white-space:nowrap;transition:all .2s;}
    .cat-pill:hover{background:rgba(37,99,235,.1);border-color:rgba(37,99,235,.3);color:white;}
    .cat-pill.active{background:linear-gradient(135deg,#2563eb,#3b82f6);border-color:transparent;color:white;box-shadow:0 4px 14px rgba(37,99,235,.35);}
    .cat-products-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;}
    .cat-product-real-img{width:100%;height:100%;object-fit:cover;transition:transform .4s;}
    .gv-product-card:hover .cat-product-real-img{transform:scale(1.06)}
    .cat-product-emoji{font-size:52px}
    .cat-no-stock{position:absolute;inset:0;background:rgba(2,6,23,.65);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#f87171;letter-spacing:1px;text-transform:uppercase;backdrop-filter:blur(2px);}
    .cat-price-mayoreo{font-size:12px;color:#60a5fa;margin-top:4px;font-weight:600;}
    .cat-price-mayoreo span{color:#475569;font-weight:400}
    .cat-card-actions{display:flex;align-items:center;gap:8px}
    .cat-btn-detail{width:42px;height:42px;border-radius:13px;border:1px solid rgba(255,255,255,.1);background:rgba(255,255,255,.04);color:#64748b;display:flex;align-items:center;justify-content:center;text-decoration:none;transition:border-color .2s,color .2s,background .2s;flex-shrink:0;}
    .cat-btn-detail:hover{border-color:rgba(37,99,235,.4);color:#60a5fa;background:rgba(37,99,235,.1);}
    .cat-empty{text-align:center;padding:80px 20px;}
    .cat-empty-icon{font-size:64px;margin-bottom:20px}
    .cat-empty h3{font-size:22px;font-weight:800;color:white;margin-bottom:10px}
    .cat-empty p{color:#475569;font-size:15px}
    .cat-pagination{margin-top:48px;display:flex;justify-content:center}
    .cat-pagination .pagination{display:flex;gap:8px;list-style:none}
    .cat-pagination .page-item .page-link{display:flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:12px;background:#0b1628;border:1px solid rgba(255,255,255,.08);color:#94a3b8;text-decoration:none;font-size:13px;font-weight:600;transition:all .2s;}
    .cat-pagination .page-item.active .page-link{background:linear-gradient(135deg,#2563eb,#3b82f6);border-color:transparent;color:white;}
    .cat-pagination .page-item .page-link:hover{border-color:rgba(37,99,235,.4);color:white;}
    .cat-breadcrumb{display:flex;align-items:center;gap:8px;font-size:13px;color:#475569;margin-bottom:40px;flex-wrap:wrap;}
    .cat-breadcrumb a{color:#64748b;text-decoration:none;transition:color .2s}
    .cat-breadcrumb a:hover{color:white}
    .cat-detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:64px;align-items:start;}
    .cat-detail-img{height:440px;border-radius:24px;overflow:hidden;display:flex;align-items:center;justify-content:center;position:relative;}
    .cat-detail-img img{width:100%;height:100%;object-fit:cover}
    .cat-detail-title{font-size:clamp(1.6rem,3vw,2.4rem);font-weight:900;color:white;line-height:1.15;margin-bottom:8px;}
    .cat-detail-ref{font-size:13px;color:#475569;margin-bottom:16px}
    .cat-detail-desc{font-size:15px;color:#64748b;line-height:1.8;margin-bottom:28px;padding-bottom:28px;border-bottom:1px solid rgba(255,255,255,.06);}
    .cat-price-box{background:#0b1628;border:1px solid rgba(255,255,255,.07);border-radius:18px;padding:24px;margin-bottom:24px;}
    .cat-price-row{display:flex;align-items:baseline;gap:10px;margin-bottom:10px;}
    .cat-price-row:last-child{margin-bottom:0}
    .cat-price-row.mayoreo{padding-top:12px;border-top:1px solid rgba(255,255,255,.06);}
    .cat-price-label{font-size:11px;font-weight:700;letter-spacing:1.5px;color:#475569;text-transform:uppercase;min-width:110px;}
    .cat-price-big{font-size:28px;font-weight:900;color:white;line-height:1;}
    .cat-price-big.mayoreo{color:#60a5fa}
    .cat-price-unit{font-size:12px;color:#475569}
    .cat-stock-row{display:flex;align-items:center;gap:8px;margin-bottom:24px;}
    .cat-stock-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;}
    .cat-stock-dot.green{background:#34d399;box-shadow:0 0 8px rgba(52,211,153,.5)}
    .cat-stock-dot.yellow{background:#facc15;box-shadow:0 0 8px rgba(250,204,21,.5)}
    .cat-stock-dot.red{background:#f87171;box-shadow:0 0 8px rgba(248,113,113,.5)}
    .cat-detail-actions{display:flex;flex-direction:column;gap:12px}
    .cat-btn-whatsapp{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:14px 24px;border-radius:16px;border:1px solid rgba(255,255,255,.1);background:rgba(255,255,255,.04);color:#cbd5e1;font-size:14px;font-weight:600;text-decoration:none;transition:border-color .2s,color .2s,background .2s;}
    .cat-btn-whatsapp:hover{border-color:rgba(37,220,100,.3);background:rgba(37,220,100,.06);color:#4ade80;}

    /* ══ MODAL ═══════════════════════════════════════════════════ */
    .gv-modal-overlay{position:fixed;inset:0;z-index:2000;background:rgba(2,6,23,.85);backdrop-filter:blur(12px);display:flex;align-items:center;justify-content:center;padding:20px;opacity:0;pointer-events:none;transition:opacity .3s cubic-bezier(.22,1,.36,1);}
    .gv-modal-overlay.active{opacity:1;pointer-events:all;}
    .gv-modal-box{background:#0b1628;border:1px solid rgba(255,255,255,.08);border-radius:28px;width:100%;max-width:900px;max-height:90vh;overflow-y:auto;position:relative;transform:scale(.92) translateY(20px);transition:transform .35s cubic-bezier(.22,1,.36,1);box-shadow:0 40px 100px rgba(0,0,0,.7);}
    .gv-modal-overlay.active .gv-modal-box{transform:scale(1) translateY(0);}
    .gv-modal-close{position:absolute;top:16px;right:16px;z-index:10;width:36px;height:36px;border-radius:10px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);color:#94a3b8;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background .2s,color .2s;}
    .gv-modal-close:hover{background:rgba(239,68,68,.15);color:#f87171;}
    .gv-modal-inner{display:grid;grid-template-columns:1fr 1fr;gap:0;}
    .gv-modal-img-wrap{position:relative;border-radius:28px 0 0 28px;overflow:hidden;}
    .gv-modal-img{height:100%;min-height:380px;display:flex;align-items:center;justify-content:center;}
    .gv-modal-img img{width:100%;height:100%;object-fit:cover;}
    .gv-modal-info{padding:36px 32px;display:flex;flex-direction:column;}
    .gv-modal-title{font-size:clamp(1.3rem,2.5vw,1.8rem);font-weight:900;color:white;line-height:1.2;margin-bottom:6px;}
    .gv-modal-ref{font-size:12px;color:#475569;margin-bottom:12px;}
    .gv-modal-desc{font-size:14px;color:#64748b;line-height:1.75;margin-bottom:20px;flex:1;}
    .gv-modal-price-box{background:#050e1f;border:1px solid rgba(255,255,255,.06);border-radius:16px;padding:20px;margin-bottom:18px;}
    .gv-modal-price-row{display:flex;align-items:baseline;gap:8px;margin-bottom:8px;}
    .gv-modal-price-row:last-child{margin-bottom:0;}
    .gv-modal-price-row + .gv-modal-price-row{padding-top:10px;border-top:1px solid rgba(255,255,255,.05);}
    .gv-modal-price-label{font-size:10px;font-weight:700;letter-spacing:1.5px;color:#334155;text-transform:uppercase;min-width:100px;}
    .gv-modal-price-big{font-size:26px;font-weight:900;color:white;line-height:1;}
    .gv-modal-price-big.mayoreo{color:#60a5fa;font-size:20px;}
    .gv-modal-price-unit{font-size:12px;color:#475569;}
    .gv-modal-stock-row{display:flex;align-items:center;gap:8px;margin-bottom:20px;font-size:13px;font-weight:700;}
    .gv-modal-actions{display:flex;flex-direction:column;gap:10px;}
    .gv-modal-whatsapp{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:12px 20px;border-radius:14px;border:1px solid rgba(255,255,255,.08);background:rgba(255,255,255,.03);color:#94a3b8;font-size:13px;font-weight:600;text-decoration:none;transition:border-color .2s,color .2s,background .2s;}
    .gv-modal-whatsapp:hover{border-color:rgba(37,220,100,.3);background:rgba(37,220,100,.06);color:#4ade80;}

    /* ══ FORMULARIO ADMIN ════════════════════════════════════════ */
    .gv-form-card{background:#0b1628;border:1px solid rgba(255,255,255,.07);border-radius:20px;padding:32px;}
    .gv-form-section-title{font-size:16px;font-weight:800;color:white;margin-bottom:24px;padding-bottom:16px;border-bottom:1px solid rgba(255,255,255,.06);}
    .gv-form-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;}
    .gv-form-grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:20px;margin-bottom:20px;}
    .gv-form-group{display:flex;flex-direction:column;gap:8px;}
    .gv-label{font-size:12px;font-weight:700;color:#64748b;letter-spacing:.5px;text-transform:uppercase;}
    .gv-input{background:#050e1f;border:1px solid rgba(255,255,255,.08);border-radius:12px;color:white;font-size:14px;padding:12px 16px;outline:none;font-family:inherit;transition:border-color .2s,box-shadow .2s;width:100%;}
    .gv-input:focus{border-color:rgba(37,99,235,.5);box-shadow:0 0 0 3px rgba(37,99,235,.1);}
    .gv-input::placeholder{color:#334155;}
    .gv-textarea{min-height:110px;resize:vertical;}
    .gv-select{cursor:pointer;}
    .gv-select option{background:#0b1628;color:white;}
    .gv-input-prefix-wrap{position:relative;}
    .gv-input-prefix{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#475569;font-size:14px;font-weight:700;pointer-events:none;}
    .gv-input-prefixed{padding-left:30px;}
    .gv-toggle{display:flex;align-items:center;gap:12px;cursor:pointer;user-select:none;}
    .gv-toggle input{display:none;}
    .gv-toggle-slider{width:44px;height:24px;border-radius:12px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.1);position:relative;flex-shrink:0;transition:background .2s,border-color .2s;}
    .gv-toggle-slider::after{content:'';position:absolute;width:18px;height:18px;border-radius:50%;background:#475569;top:2px;left:2px;transition:transform .2s,background .2s;}
    .gv-toggle input:checked + .gv-toggle-slider{background:rgba(37,99,235,.3);border-color:rgba(37,99,235,.5);}
    .gv-toggle input:checked + .gv-toggle-slider::after{transform:translateX(20px);background:#3b82f6;}
    .gv-toggle-label{font-size:13px;font-weight:600;color:#94a3b8;}
    .gv-file-upload{border:2px dashed rgba(255,255,255,.08);border-radius:16px;padding:40px 24px;text-align:center;transition:border-color .2s,background .2s;cursor:pointer;}
    .gv-file-upload:hover{border-color:rgba(37,99,235,.4);background:rgba(37,99,235,.04);}
    .gv-alert{padding:14px 18px;border-radius:12px;font-size:13px;font-weight:600;margin-bottom:20px;}
    .gv-alert-success{background:rgba(16,185,129,.1);color:#34d399;border:1px solid rgba(16,185,129,.2);}
    .gv-alert-error{background:rgba(239,68,68,.1);color:#f87171;border:1px solid rgba(239,68,68,.2);}

    /* ══ RESPONSIVE ══════════════════════════════════════════════ */
    @media(max-width:1100px){
        .gv-nav-links{display:none}
        .gv-hero-inner{grid-template-columns:1fr}
        .gv-hero-right{display:none}
        .gv-cats{grid-template-columns:repeat(3,1fr)}
        .gv-products-grid{grid-template-columns:repeat(2,1fr)}
        .gv-features-grid{grid-template-columns:repeat(2,1fr)}
        .gv-footer-grid{grid-template-columns:1fr 1fr;gap:32px}
        .gv-promo-inner{flex-direction:column;padding:44px 40px}
        .cat-products-grid{grid-template-columns:repeat(2,1fr)}
        .cat-detail-grid{grid-template-columns:1fr}
        .cat-detail-img{height:320px}
        .gv-modal-inner{grid-template-columns:1fr}
        .gv-modal-img-wrap{border-radius:28px 28px 0 0}
        .gv-modal-img{min-height:220px}
        .gv-modal-info{padding:24px 20px}
    }
    @media(max-width:640px){
        .gv-search-wrap{display:none}
        .gv-cats{grid-template-columns:repeat(2,1fr)}
        .gv-products-grid{grid-template-columns:1fr}
        .gv-features-grid{grid-template-columns:1fr}
        .gv-footer-grid{grid-template-columns:1fr}
        .gv-promo-inner{padding:32px 24px}
        .gv-wrap{padding:56px 20px}
        .btn-outline-light{display:none}
        .cat-products-grid{grid-template-columns:1fr}
        .cat-hero{padding:40px 20px 32px}
        .cat-bar,.cat-cats-bar{padding:12px 20px}
        .gv-form-grid-2,.gv-form-grid-3{grid-template-columns:1fr}
    }

    </style>
</head>
<body>
    @include('components.navbar')
    <main style="padding-top:72px">
        @yield('content')
    </main>
    @include('components.footer')

    <div id="gv-toast" class="gv-toast"></div>

    <script>
    function gvToast(msg, ms = 3200) {
        const t = document.getElementById('gv-toast');
        t.textContent = msg;
        t.style.display = 'block';
        setTimeout(() => t.style.display = 'none', ms);
    }
    document.addEventListener('DOMContentLoaded', () => {

        const nav = document.querySelector('.gv-nav');
        window.addEventListener('scroll', () => {
            nav.classList.toggle('scrolled', window.scrollY > 20);
        }, {passive:true});

        const ddBtn = document.getElementById('user-dd-btn');
        const dd    = document.getElementById('user-dropdown');
        ddBtn?.addEventListener('click', e => {
            e.stopPropagation();
            dd.style.display = dd.style.display === 'block' ? 'none' : 'block';
        });
        document.addEventListener('click', () => { if(dd) dd.style.display = 'none'; });

        const io = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.classList.add('visible');
                    io.unobserve(e.target);
                }
            });
        }, {threshold:.1});
        document.querySelectorAll('.reveal').forEach(el => io.observe(el));

        document.querySelectorAll('.stat-num').forEach(el => {
            const txt = el.textContent.trim();
            const num = parseInt(txt.replace(/\D/g,''));
            const pre = txt.startsWith('+') ? '+' : '';
            const suf = txt.includes('%') ? '%' : '';
            if (!num) return;
            let cur = 0; const step = num / 45;
            const t = setInterval(() => {
                cur = Math.min(cur + step, num);
                el.textContent = pre + Math.floor(cur) + suf;
                if (cur >= num) clearInterval(t);
            }, 28);
        });
    });
    </script>
    @stack('scripts')
</body>
</html>