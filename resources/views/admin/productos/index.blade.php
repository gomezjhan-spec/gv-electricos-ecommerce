@extends('layouts.app')
@section('title', 'Productos — Admin')
@section('content')

<div class="gv-section-dark" style="min-height:100vh;">
    <div class="gv-wrap">

        {{-- Header --}}
        <div style="display:flex;align-items:flex-start;justify-content:space-between;
                    flex-wrap:wrap;gap:20px;margin-bottom:40px;">
            <div>
                <a href="{{ route('admin.dashboard') }}"
                   style="display:inline-flex;align-items:center;gap:6px;
                          font-size:13px;font-weight:600;color:#475569;
                          text-decoration:none;margin-bottom:16px;transition:color .2s;"
                   onmouseover="this.style.color='white'"
                   onmouseout="this.style.color='#475569'">
                    ← Dashboard
                </a>
                <span class="section-label-dark">Panel admin</span>
                <h1 class="section-title-dark" style="margin-top:6px;">📦 Todos los productos</h1>
                <p style="color:#475569;font-size:14px;margin-top:6px;">
                    {{ $productos->total() }} producto{{ $productos->total() !== 1 ? 's' : '' }} en total
                </p>
            </div>
            <a href="{{ route('admin.productos.create') }}" class="btn-primary">
                ➕ Nuevo producto
            </a>
        </div>

        {{-- Alertas --}}
        @if(session('success'))
        <div class="gv-alert gv-alert-success" style="margin-bottom:24px;">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="gv-alert gv-alert-error" style="margin-bottom:24px;">
            {{ session('error') }}
        </div>
        @endif

        {{-- Tabla --}}
        <div style="background:#0b1628;border:1px solid rgba(255,255,255,.07);
                    border-radius:20px;overflow:hidden;">

            {{-- Cabecera --}}
            <div style="display:grid;
                        grid-template-columns:64px 1fr 130px 90px 80px 120px;
                        gap:16px;padding:14px 24px;
                        border-bottom:1px solid rgba(255,255,255,.06);
                        font-size:10px;font-weight:700;color:#475569;
                        letter-spacing:1px;text-transform:uppercase;">
                <span>Imagen</span>
                <span>Producto</span>
                <span>Precio detal</span>
                <span>Stock</span>
                <span>Estado</span>
                <span style="text-align:right;">Acciones</span>
            </div>

            @forelse($productos as $p)
            <div style="display:grid;
                        grid-template-columns:64px 1fr 130px 90px 80px 120px;
                        gap:16px;padding:16px 24px;align-items:center;
                        border-bottom:1px solid rgba(255,255,255,.04);
                        transition:background .15s;"
                 onmouseover="this.style.background='rgba(255,255,255,.02)'"
                 onmouseout="this.style.background='transparent'">

                {{-- Imagen --}}
                <div style="width:52px;height:52px;border-radius:10px;overflow:hidden;
                            background:#050e1f;border:1px solid rgba(255,255,255,.08);
                            display:flex;align-items:center;justify-content:center;
                            font-size:22px;flex-shrink:0;">
                    @if($p->imagen_url)
                        <img src="{{ $p->imagen_url }}" alt="{{ $p->nombre }}"
                             style="width:100%;height:100%;object-fit:cover;">
                    @else
                        {{ App\Models\Producto::categorias()[$p->categoria]['icon'] ?? '📦' }}
                    @endif
                </div>

                {{-- Info --}}
                <div style="overflow:hidden;">
                    <p style="font-size:14px;font-weight:700;color:white;
                               white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $p->nombre }}
                    </p>
                    <p style="font-size:12px;color:#475569;margin-top:2px;">
                        Ref. {{ $p->referencia }} ·
                        {{ App\Models\Producto::categorias()[$p->categoria]['label'] ?? $p->categoria }}
                        @if($p->badge)
                            · <span style="color:#facc15;">{{ $p->badge }}</span>
                        @endif
                    </p>
                </div>

                {{-- Precio --}}
                <div>
                    <span style="font-size:14px;font-weight:800;color:white;">
                        {{ $p->precio_formateado }}
                    </span>
                    @if($p->precio_mayoreo)
                    <p style="font-size:11px;color:#60a5fa;margin-top:2px;">
                        {{ $p->precio_mayoreo_formateado }} may.
                    </p>
                    @endif
                </div>

                {{-- Stock --}}
                <div>
                    @if($p->stock === 0)
                        <span style="color:#f87171;font-weight:700;font-size:13px;">Sin stock</span>
                    @elseif($p->stock <= 5)
                        <span style="color:#facc15;font-weight:700;font-size:13px;">{{ $p->stock }} ⚠️</span>
                    @else
                        <span style="color:#34d399;font-weight:700;font-size:13px;">{{ $p->stock }} uds</span>
                    @endif
                </div>

                {{-- Estado --}}
                <div>
                    @if($p->activo)
                        <span style="padding:3px 10px;border-radius:6px;font-size:10px;
                                     font-weight:700;background:rgba(16,185,129,.1);
                                     color:#34d399;border:1px solid rgba(16,185,129,.2);
                                     white-space:nowrap;">
                            Activo
                        </span>
                    @else
                        <span style="padding:3px 10px;border-radius:6px;font-size:10px;
                                     font-weight:700;background:rgba(239,68,68,.1);
                                     color:#f87171;border:1px solid rgba(239,68,68,.2);
                                     white-space:nowrap;">
                            Inactivo
                        </span>
                    @endif
                </div>

                {{-- Acciones --}}
                <div style="display:flex;gap:8px;justify-content:flex-end;align-items:center;">
                    <a href="{{ route('admin.productos.edit', $p) }}"
                       style="padding:7px 14px;border-radius:9px;
                              background:rgba(37,99,235,.15);color:#60a5fa;
                              font-size:12px;font-weight:600;text-decoration:none;
                              border:1px solid rgba(37,99,235,.2);
                              transition:background .2s;white-space:nowrap;"
                       onmouseover="this.style.background='rgba(37,99,235,.3)'"
                       onmouseout="this.style.background='rgba(37,99,235,.15)'">
                        ✏️ Editar
                    </a>
                    <form method="POST"
                          action="{{ route('admin.productos.destroy', $p) }}"
                          style="display:inline;"
                          onsubmit="return confirm('¿Eliminar este producto? Esta acción no se puede deshacer.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                style="padding:7px 10px;border-radius:9px;
                                       background:rgba(239,68,68,.1);color:#f87171;
                                       font-size:13px;font-weight:600;
                                       border:1px solid rgba(239,68,68,.2);
                                       cursor:pointer;transition:background .2s;"
                                onmouseover="this.style.background='rgba(239,68,68,.25)'"
                                onmouseout="this.style.background='rgba(239,68,68,.1)'">
                            🗑️
                        </button>
                    </form>
                </div>

            </div>
            @empty
            <div style="text-align:center;padding:72px 20px;">
                <div style="font-size:56px;margin-bottom:16px;">📦</div>
                <h3 style="font-size:20px;font-weight:800;color:white;margin-bottom:8px;">
                    No hay productos todavía
                </h3>
                <p style="color:#475569;font-size:14px;margin-bottom:24px;">
                    Crea tu primer producto para empezar a vender.
                </p>
                <a href="{{ route('admin.productos.create') }}" class="btn-primary"
                   style="display:inline-flex;">
                    ➕ Crear primer producto
                </a>
            </div>
            @endforelse

        </div>

        {{-- Paginación --}}
        @if($productos->hasPages())
        <div class="cat-pagination" style="margin-top:32px;">
            {{ $productos->appends(request()->query())->links('pagination::simple-bootstrap-4') }}
        </div>
        @endif

    </div>
</div>

@endsection