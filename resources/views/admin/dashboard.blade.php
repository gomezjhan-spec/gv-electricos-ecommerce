@extends('layouts.app')
@section('title', 'Panel Admin')
@section('content')

<div class="gv-section-dark" style="min-height:100vh;">
    <div class="gv-wrap">

        {{-- Header --}}
        <div style="margin-bottom:48px;">
            <span class="section-label-dark">Panel de administración</span>
            <h1 class="section-title-dark" style="margin-top:6px;">
                ⚡ Dashboard
            </h1>
            <p style="color:#475569;font-size:14px;margin-top:8px;">
                Bienvenido, {{ auth()->user()->name }}
            </p>
        </div>

        {{-- Stats --}}
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:48px;">

            @foreach([
                ['📦', 'Productos', $stats['productos'],  '#2563eb'],
                ['✅', 'Activos',   $stats['activos'],    '#10b981'],
                ['❌', 'Sin stock', $stats['sin_stock'],  '#ef4444'],
                ['👥', 'Usuarios',  $stats['usuarios'],   '#facc15'],
            ] as [$icon, $label, $value, $color])
            <div style="background:#0b1628;border:1px solid rgba(255,255,255,.07);
                        border-radius:20px;padding:28px 24px;">
                <div style="font-size:28px;margin-bottom:12px;">{{ $icon }}</div>
                <p style="font-size:32px;font-weight:900;color:{{ $color }};line-height:1;">
                    {{ $value }}
                </p>
                <p style="font-size:13px;color:#475569;margin-top:6px;">{{ $label }}</p>
            </div>
            @endforeach

        </div>

        {{-- Roles --}}
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:48px;">
            @foreach([
                ['⚡', 'Admins',     $stats['admins']],
                ['🏪', 'Mayoristas', $stats['mayoristas']],
                ['🏠', 'Clientes',   $stats['clientes']],
            ] as [$icon, $label, $value])
            <div style="background:#0b1628;border:1px solid rgba(255,255,255,.07);
                        border-radius:20px;padding:24px;">
                <p style="font-size:24px;font-weight:900;color:white;">
                    {{ $icon }} {{ $value }}
                </p>
                <p style="font-size:13px;color:#475569;margin-top:6px;">{{ $label }}</p>
            </div>
            @endforeach
        </div>

        {{-- Acciones rápidas --}}
        <div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:48px;">
            <a href="{{ url('/admin/productos/crear') }}" class="btn-primary">
                ➕ Nuevo producto
            </a>
            <a href="{{ url('/admin/productos') }}" class="btn-navy">
                📦 Ver todos los productos
            </a>
            <a href="{{ url('/productos') }}" class="btn-outline-light"
               style="border-color:rgba(255,255,255,.15);color:#94a3b8;">
                🌐 Ver tienda
            </a>
        </div>

        {{-- Productos recientes --}}
        <div style="background:#0b1628;border:1px solid rgba(255,255,255,.07);
                    border-radius:20px;padding:28px;margin-bottom:32px;">
            <h3 style="font-size:16px;font-weight:800;color:white;margin-bottom:20px;">
                📦 Productos recientes
            </h3>
            <div style="display:flex;flex-direction:column;gap:12px;">
                @forelse($productos_recientes as $p)
                <div style="display:flex;align-items:center;justify-content:space-between;
                            padding:14px 16px;background:rgba(255,255,255,.03);
                            border-radius:12px;border:1px solid rgba(255,255,255,.05);">
                    <div>
                        <p style="font-size:14px;font-weight:700;color:white;">
                            {{ $p->nombre }}
                        </p>
                        <p style="font-size:12px;color:#475569;">
                            Ref. {{ $p->referencia }} · {{ $p->categoria }}
                        </p>
                    </div>
                    <div style="display:flex;align-items:center;gap:12px;">
                        <span style="font-size:15px;font-weight:800;color:white;">
                            {{ $p->precio_formateado }}
                        </span>
                        <a href="{{ url('/admin/productos/'.$p->id.'/editar') }}"
                           style="padding:6px 14px;border-radius:8px;
                                  background:rgba(37,99,235,.15);color:#60a5fa;
                                  font-size:12px;font-weight:600;text-decoration:none;
                                  border:1px solid rgba(37,99,235,.2);">
                            Editar
                        </a>
                    </div>
                </div>
                @empty
                <p style="color:#475569;font-size:14px;text-align:center;padding:20px;">
                    No hay productos aún
                </p>
                @endforelse
            </div>
        </div>

        {{-- Usuarios recientes --}}
        <div style="background:#0b1628;border:1px solid rgba(255,255,255,.07);
                    border-radius:20px;padding:28px;">
            <h3 style="font-size:16px;font-weight:800;color:white;margin-bottom:20px;">
                👥 Usuarios recientes
            </h3>
            <div style="display:flex;flex-direction:column;gap:12px;">
                @forelse($usuarios_recientes as $u)
                <div style="display:flex;align-items:center;justify-content:space-between;
                            padding:14px 16px;background:rgba(255,255,255,.03);
                            border-radius:12px;border:1px solid rgba(255,255,255,.05);">
                    <div style="display:flex;align-items:center;gap:12px;">
                        <div style="width:36px;height:36px;border-radius:10px;
                                    background:linear-gradient(135deg,#2563eb,#60a5fa);
                                    display:flex;align-items:center;justify-content:center;
                                    font-size:14px;font-weight:800;color:white;">
                            {{ strtoupper(substr($u->name, 0, 1)) }}
                        </div>
                        <div>
                            <p style="font-size:14px;font-weight:700;color:white;">
                                {{ $u->name }}
                            </p>
                            <p style="font-size:12px;color:#475569;">{{ $u->email }}</p>
                        </div>
                    </div>
                    <div style="display:flex;gap:6px;">
                        @foreach($u->getRoleNames() as $rol)
                        <span style="padding:3px 10px;border-radius:6px;font-size:10px;
                                     font-weight:700;text-transform:uppercase;
                                     background:rgba(37,99,235,.15);color:#60a5fa;
                                     border:1px solid rgba(37,99,235,.2);">
                            {{ $rol }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @empty
                <p style="color:#475569;font-size:14px;text-align:center;padding:20px;">
                    No hay usuarios aún
                </p>
                @endforelse
            </div>
        </div>

    </div>
</div>

@endsection