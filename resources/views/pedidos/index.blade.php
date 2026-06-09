@extends('layouts.app')
@section('title', 'Mis pedidos')
@section('content')

<div class="gv-section-dark" style="min-height:80vh;">
    <div class="gv-wrap" style="max-width:800px;">

        <div style="display:flex;align-items:flex-start;justify-content:space-between;
                    flex-wrap:wrap;gap:16px;margin-bottom:40px;">
            <div>
                <span class="section-label-dark">Cuenta</span>
                <h1 class="section-title-dark" style="margin-top:6px;">📦 Mis pedidos</h1>
                <p style="color:#475569;font-size:14px;margin-top:6px;">
                    Historial de tus compras en GV Eléctricos
                </p>
            </div>
            <a href="{{ url('/perfil') }}" class="btn-outline-light">
                ← Mi perfil
            </a>
        </div>

        {{-- Estado vacío (mientras no hay sistema de pedidos) --}}
        <div style="background:#0b1628;border:1px solid rgba(255,255,255,.07);
                    border-radius:20px;padding:80px 40px;text-align:center;">
            <div style="font-size:64px;margin-bottom:20px;">📭</div>
            <h3 style="font-size:22px;font-weight:800;color:white;margin-bottom:10px;">
                Aún no tienes pedidos
            </h3>
            <p style="color:#475569;font-size:15px;line-height:1.7;max-width:400px;margin:0 auto;">
                Cuando realices una compra, podrás ver el estado
                y el historial de tus pedidos aquí.
            </p>
            <div style="margin-top:32px;display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
                <a href="{{ url('/productos') }}" class="btn-primary">
                    🛍️ Ver catálogo
                </a>
                <a href="https://wa.me/573022099810?text=Hola%2C+quiero+hacer+un+pedido"
                   target="_blank" rel="noopener"
                   class="btn-outline-light">
                    📱 Pedir por WhatsApp
                </a>
            </div>
        </div>

    </div>
</div>

@endsection