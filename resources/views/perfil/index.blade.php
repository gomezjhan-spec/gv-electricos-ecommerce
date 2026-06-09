@extends('layouts.app')
@section('title', 'Mi perfil')
@section('content')

<div class="gv-section-dark" style="min-height:80vh;">
    <div class="gv-wrap" style="max-width:700px;">

        <div style="margin-bottom:40px;">
            <span class="section-label-dark">Cuenta</span>
            <h1 class="section-title-dark" style="margin-top:6px;">👤 Mi perfil</h1>
        </div>

        {{-- Alertas --}}
        @if(session('success'))
        <div class="gv-alert gv-alert-success" style="margin-bottom:24px;">
            {{ session('success') }}
        </div>
        @endif

        {{-- Tarjeta usuario --}}
        <div class="gv-form-card" style="margin-bottom:24px;">

            <div style="display:flex;align-items:center;gap:20px;margin-bottom:28px;
                        padding-bottom:24px;border-bottom:1px solid rgba(255,255,255,.06);">
                <div style="width:64px;height:64px;border-radius:18px;flex-shrink:0;
                            background:linear-gradient(135deg,#2563eb,#60a5fa);
                            display:flex;align-items:center;justify-content:center;
                            font-size:26px;font-weight:900;color:white;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <p style="font-size:20px;font-weight:900;color:white;">{{ $user->name }}</p>
                    <p style="font-size:13px;color:#475569;margin-top:3px;">{{ $user->email }}</p>
                    <div style="display:flex;gap:6px;margin-top:8px;">
                        @foreach($user->getRoleNames() as $rol)
                        <span style="padding:3px 10px;border-radius:6px;font-size:10px;
                                     font-weight:700;text-transform:uppercase;
                                     background:rgba(37,99,235,.15);color:#60a5fa;
                                     border:1px solid rgba(37,99,235,.2);">
                            {{ $rol }}
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>

            <h3 class="gv-form-section-title">Información de cuenta</h3>

            <div style="display:grid;gap:14px;">
                <div style="display:flex;justify-content:space-between;align-items:center;
                            padding:14px 16px;background:rgba(255,255,255,.02);
                            border-radius:12px;border:1px solid rgba(255,255,255,.05);">
                    <span style="font-size:12px;font-weight:700;color:#475569;
                                 letter-spacing:.5px;text-transform:uppercase;">Nombre</span>
                    <span style="font-size:14px;font-weight:600;color:white;">{{ $user->name }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;
                            padding:14px 16px;background:rgba(255,255,255,.02);
                            border-radius:12px;border:1px solid rgba(255,255,255,.05);">
                    <span style="font-size:12px;font-weight:700;color:#475569;
                                 letter-spacing:.5px;text-transform:uppercase;">Correo</span>
                    <span style="font-size:14px;font-weight:600;color:white;">{{ $user->email }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;
                            padding:14px 16px;background:rgba(255,255,255,.02);
                            border-radius:12px;border:1px solid rgba(255,255,255,.05);">
                    <span style="font-size:12px;font-weight:700;color:#475569;
                                 letter-spacing:.5px;text-transform:uppercase;">Tipo de cuenta</span>
                    <span style="font-size:14px;font-weight:600;color:white;text-transform:capitalize;">
                        {{ $user->getRoleNames()->first() ?? 'Cliente' }}
                    </span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;
                            padding:14px 16px;background:rgba(255,255,255,.02);
                            border-radius:12px;border:1px solid rgba(255,255,255,.05);">
                    <span style="font-size:12px;font-weight:700;color:#475569;
                                 letter-spacing:.5px;text-transform:uppercase;">Miembro desde</span>
                    <span style="font-size:14px;font-weight:600;color:white;">
                        {{ $user->created_at->format('d/m/Y') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Acciones --}}
        <div style="display:flex;gap:12px;flex-wrap:wrap;">
            <a href="{{ url('/pedidos') }}" class="btn-primary">
                📦 Mis pedidos
            </a>
            <a href="{{ url('/productos') }}" class="btn-outline-light">
                🛍️ Ver catálogo
            </a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit"
                        style="height:44px;padding:0 20px;border-radius:13px;
                               border:1px solid rgba(239,68,68,.2);
                               background:rgba(239,68,68,.08);
                               color:#f87171;font-size:13px;font-weight:600;
                               cursor:pointer;transition:all .2s;"
                        onmouseover="this.style.background='rgba(239,68,68,.18)'"
                        onmouseout="this.style.background='rgba(239,68,68,.08)'">
                    🚪 Cerrar sesión
                </button>
            </form>
        </div>

    </div>
</div>

@endsection