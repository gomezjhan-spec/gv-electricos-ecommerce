@extends('layouts.app')
@section('title', 'Registrarse')
@section('content')

<div class="gv-section-dark"
     style="min-height:80vh;display:flex;align-items:center;justify-content:center;
            padding:40px 24px;">
    <div style="width:100%;max-width:500px;">

        <div style="text-align:center;margin-bottom:36px;">
            <div style="width:56px;height:56px;border-radius:16px;
                        background:linear-gradient(135deg,#0f1f3d,#1a3460);
                        border:1px solid rgba(37,99,235,.35);
                        display:flex;align-items:center;justify-content:center;
                        margin:0 auto 16px;font-size:24px;">⚡</div>
            <span class="section-label-dark">Crea tu cuenta</span>
            <h1 class="section-title-dark" style="margin-top:6px;font-size:1.8rem;">
                Registrarse
            </h1>
            <p style="color:#475569;font-size:14px;margin-top:10px;">
                Acumula puntos y accede a descuentos exclusivos
            </p>
        </div>

        <form method="POST" action="{{ url('/register') }}"
              style="display:flex;flex-direction:column;gap:20px;">
            @csrf

            <div class="gv-form-group">
                <label class="gv-label">Nombre completo</label>
                <input type="text" name="name" class="gv-input"
                       value="{{ old('name') }}"
                       placeholder="Tu nombre completo"
                       required autofocus>
                @error('name')
                <span style="font-size:12px;color:#f87171;margin-top:4px;display:block;">
                    {{ $message }}
                </span>
                @enderror
            </div>

            <div class="gv-form-group">
                <label class="gv-label">Correo electrónico</label>
                <input type="email" name="email" class="gv-input"
                       value="{{ old('email') }}"
                       placeholder="tu@correo.com" required>
                @error('email')
                <span style="font-size:12px;color:#f87171;margin-top:4px;display:block;">
                    {{ $message }}
                </span>
                @enderror
            </div>

            <div class="gv-form-group">
                <label class="gv-label">Contraseña</label>
                <input type="password" name="password" class="gv-input"
                       placeholder="Mínimo 8 caracteres" required>
                @error('password')
                <span style="font-size:12px;color:#f87171;margin-top:4px;display:block;">
                    {{ $message }}
                </span>
                @enderror
            </div>

            <div class="gv-form-group">
                <label class="gv-label">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" class="gv-input"
                       placeholder="Repite tu contraseña" required>
            </div>

            {{-- Tipo de cuenta --}}
            <div class="gv-form-group">
                <label class="gv-label">Tipo de cuenta</label>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:4px;">
                    <div id="card-cliente" onclick="selectTipo('cliente')"
                         style="padding:18px 14px;border-radius:14px;
                                border:1.5px solid rgba(37,99,235,.5);
                                background:rgba(37,99,235,.08);
                                text-align:center;cursor:pointer;transition:all .2s;">
                        <div style="font-size:26px;margin-bottom:8px;">🏠</div>
                        <p style="font-size:13px;font-weight:700;color:white;margin-bottom:3px;">Cliente</p>
                        <p style="font-size:11px;color:#475569;">Compras al detal</p>
                    </div>
                    <div id="card-mayorista" onclick="selectTipo('mayorista')"
                         style="padding:18px 14px;border-radius:14px;
                                border:1.5px solid rgba(255,255,255,.08);
                                background:rgba(255,255,255,.03);
                                text-align:center;cursor:pointer;transition:all .2s;">
                        <div style="font-size:26px;margin-bottom:8px;">🏪</div>
                        <p style="font-size:13px;font-weight:700;color:white;margin-bottom:3px;">Mayorista</p>
                        <p style="font-size:11px;color:#475569;">Tienda o negocio</p>
                    </div>
                </div>
                <input type="hidden" name="tipo_cuenta" id="tipo_cuenta" value="cliente">
            </div>

            <button type="submit" class="btn-primary"
                    style="width:100%;justify-content:center;padding:14px;font-size:14px;">
                Crear cuenta gratis ⚡
            </button>

            <p style="text-align:center;font-size:13px;color:#475569;">
                ¿Ya tienes cuenta?
                <a href="{{ url('/login') }}"
                   style="color:#60a5fa;text-decoration:none;font-weight:700;">
                    Inicia sesión
                </a>
            </p>

        </form>
    </div>
</div>

@push('scripts')
<script>
function selectTipo(tipo) {
    document.getElementById('tipo_cuenta').value = tipo;
    const c = document.getElementById('card-cliente');
    const m = document.getElementById('card-mayorista');
    if (tipo === 'cliente') {
        c.style.border = '1.5px solid rgba(37,99,235,.5)';
        c.style.background = 'rgba(37,99,235,.08)';
        m.style.border = '1.5px solid rgba(255,255,255,.08)';
        m.style.background = 'rgba(255,255,255,.03)';
    } else {
        m.style.border = '1.5px solid rgba(37,99,235,.5)';
        m.style.background = 'rgba(37,99,235,.08)';
        c.style.border = '1.5px solid rgba(255,255,255,.08)';
        c.style.background = 'rgba(255,255,255,.03)';
    }
}
</script>
@endpush

@endsection