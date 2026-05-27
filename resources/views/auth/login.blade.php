@extends('layouts.app')
@section('title', 'Iniciar sesión')
@section('content')

<div class="gv-section-dark"
     style="min-height:80vh;display:flex;align-items:center;justify-content:center;">
    <div style="width:100%;max-width:440px;padding:40px 24px;">

        <div style="text-align:center;margin-bottom:36px;">
            <div style="width:56px;height:56px;border-radius:16px;
                        background:linear-gradient(135deg,#0f1f3d,#1a3460);
                        border:1px solid rgba(37,99,235,.35);
                        display:flex;align-items:center;justify-content:center;
                        margin:0 auto 16px;font-size:24px;">⚡</div>
            <span class="section-label-dark">Bienvenido de nuevo</span>
            <h1 class="section-title-dark" style="margin-top:6px;font-size:1.8rem;">
                Iniciar sesión
            </h1>
        </div>

        @if(session('status'))
        <div class="gv-alert gv-alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ url('/login') }}"
              style="display:flex;flex-direction:column;gap:20px;">
            @csrf

            <div class="gv-form-group">
                <label class="gv-label">Correo electrónico</label>
                <input type="email" name="email" class="gv-input"
                       value="{{ old('email') }}"
                       placeholder="tu@correo.com"
                       required autofocus>
                @error('email')
                <span style="font-size:12px;color:#f87171;margin-top:4px;display:block;">
                    {{ $message }}
                </span>
                @enderror
            </div>

            <div class="gv-form-group">
                <label class="gv-label">Contraseña</label>
                <input type="password" name="password" class="gv-input"
                       placeholder="••••••••" required>
                @error('password')
                <span style="font-size:12px;color:#f87171;margin-top:4px;display:block;">
                    {{ $message }}
                </span>
                @enderror
            </div>

            <div style="display:flex;align-items:center;justify-content:space-between;">
                <label style="display:flex;align-items:center;gap:8px;
                              cursor:pointer;font-size:13px;color:#94a3b8;">
                    <input type="checkbox" name="remember"
                           style="width:15px;height:15px;accent-color:#2563eb;">
                    Recordarme
                </label>
            </div>

            <button type="submit" class="btn-primary"
                    style="width:100%;justify-content:center;padding:14px;font-size:14px;">
                Iniciar sesión
            </button>

            <p style="text-align:center;font-size:13px;color:#475569;">
                ¿No tienes cuenta?
                <a href="{{ url('/register') }}"
                   style="color:#60a5fa;text-decoration:none;font-weight:700;">
                    Regístrate gratis
                </a>
            </p>

        </form>
    </div>
</div>

@endsection