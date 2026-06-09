@extends('layouts.app')
@section('title', isset($producto) && $producto ? 'Editar: '.$producto->nombre : 'Nuevo producto')
@section('content')

<div class="gv-section-dark">
    <div class="gv-wrap" style="max-width:860px;">

        {{-- Header --}}
        <div style="margin-bottom:40px;">
            <a href="{{ route('admin.productos.index') }}"
               style="display:inline-flex;align-items:center;gap:6px;
                      font-size:13px;font-weight:600;color:#475569;
                      text-decoration:none;margin-bottom:20px;
                      transition:color .2s;"
               onmouseover="this.style.color='white'"
               onmouseout="this.style.color='#475569'">
                ← Volver al listado
            </a>
            <span class="section-label-dark">
                {{ isset($producto) && $producto ? 'Editar' : 'Nuevo' }} producto
            </span>
            <h1 class="section-title-dark" style="margin-top:6px;">
                {{ isset($producto) && $producto ? $producto->nombre : 'Agregar producto' }}
            </h1>
        </div>

        {{-- Alertas --}}
        @if(session('success'))
        <div class="gv-alert gv-alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
        <div class="gv-alert gv-alert-error">
            <strong>Corrige los siguientes errores:</strong>
            <ul style="margin-top:8px;padding-left:18px;">
                @foreach($errors->all() as $error)
                <li style="font-size:13px;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Formulario --}}
        <form action="{{ isset($producto) && $producto
                          ? route('admin.productos.update', $producto)
                          : route('admin.productos.store') }}"
              method="POST"
              enctype="multipart/form-data"
              style="display:flex;flex-direction:column;gap:28px;">

            @csrf
            @if(isset($producto) && $producto)
                @method('PUT')
            @endif

            {{-- SECCIÓN: Info básica --}}
            <div class="gv-form-card">
                <h3 class="gv-form-section-title">📦 Información básica</h3>

                <div class="gv-form-grid-2">
                    <div class="gv-form-group">
                        <label class="gv-label">Nombre del producto *</label>
                        <input type="text" name="nombre" class="gv-input"
                               value="{{ old('nombre', $producto->nombre ?? '') }}"
                               placeholder="Ej: Bombillo LED 9W E27"
                               required>
                    </div>
                    <div class="gv-form-group">
                        <label class="gv-label">Referencia *</label>
                        <input type="text" name="referencia" class="gv-input"
                               value="{{ old('referencia', $producto->referencia ?? '') }}"
                               placeholder="Ej: GV-BL-009"
                               required>
                    </div>
                </div>

                <div class="gv-form-group" style="margin-bottom:20px;">
                    <label class="gv-label">Descripción</label>
                    <textarea name="descripcion" class="gv-input gv-textarea"
                              placeholder="Describe el producto, especificaciones técnicas, usos...">{{ old('descripcion', $producto->descripcion ?? '') }}</textarea>
                </div>

                <div class="gv-form-grid-2">
                    <div class="gv-form-group">
                        <label class="gv-label">Categoría *</label>
                        <select name="categoria" class="gv-input gv-select" required>
                            <option value="">Seleccionar categoría</option>
                            @foreach($categorias as $slug => $info)
                            <option value="{{ $slug }}"
                                {{ old('categoria', $producto->categoria ?? '') === $slug ? 'selected' : '' }}>
                                {{ $info['icon'] }} {{ $info['label'] }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="gv-form-group">
                        <label class="gv-label">Badge (opcional)</label>
                        <select name="badge" class="gv-input gv-select">
                            <option value="">Sin badge</option>
                            @foreach(['NUEVO','OFERTA','TOP','DESTACADO'] as $b)
                            <option value="{{ $b }}"
                                {{ old('badge', $producto->badge ?? '') === $b ? 'selected' : '' }}>
                                {{ $b }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- SECCIÓN: Precios y stock --}}
            <div class="gv-form-card">
                <h3 class="gv-form-section-title">💰 Precios y stock</h3>

                <div class="gv-form-grid-3">
                    <div class="gv-form-group">
                        <label class="gv-label">Precio detal (COP) *</label>
                        <div class="gv-input-prefix-wrap">
                            <span class="gv-input-prefix">$</span>
                            <input type="number" name="precio_detal"
                                   class="gv-input gv-input-prefixed"
                                   value="{{ old('precio_detal', $producto->precio_detal ?? '') }}"
                                   placeholder="4800" min="0" step="100" required>
                        </div>
                    </div>
                    <div class="gv-form-group">
                        <label class="gv-label">Precio mayoreo (COP)</label>
                        <div class="gv-input-prefix-wrap">
                            <span class="gv-input-prefix">$</span>
                            <input type="number" name="precio_mayoreo"
                                   class="gv-input gv-input-prefixed"
                                   value="{{ old('precio_mayoreo', $producto->precio_mayoreo ?? '') }}"
                                   placeholder="3800" min="0" step="100">
                        </div>
                    </div>
                    <div class="gv-form-group">
                        <label class="gv-label">Mín. unidades mayoreo</label>
                        <input type="number" name="cantidad_minima_mayoreo" class="gv-input"
                               value="{{ old('cantidad_minima_mayoreo', $producto->cantidad_minima_mayoreo ?? 10) }}"
                               placeholder="10" min="1">
                    </div>
                </div>

                <div class="gv-form-grid-2">
                    <div class="gv-form-group">
                        <label class="gv-label">Stock disponible *</label>
                        <input type="number" name="stock" class="gv-input"
                               value="{{ old('stock', $producto->stock ?? 0) }}"
                               placeholder="0" min="0" required>
                    </div>
                    <div class="gv-form-group"
                         style="display:flex;flex-direction:column;gap:14px;justify-content:flex-end;">
                        <label class="gv-toggle">
                            <input type="checkbox" name="disponible_mayoreo" value="1"
                                   {{ old('disponible_mayoreo', $producto->disponible_mayoreo ?? true) ? 'checked' : '' }}>
                            <span class="gv-toggle-slider"></span>
                            <span class="gv-toggle-label">Disponible al por mayor</span>
                        </label>
                        <label class="gv-toggle">
                            <input type="checkbox" name="destacado" value="1"
                                   {{ old('destacado', $producto->destacado ?? false) ? 'checked' : '' }}>
                            <span class="gv-toggle-slider"></span>
                            <span class="gv-toggle-label">Producto destacado</span>
                        </label>
                    </div>
                </div>
            </div>

            {{-- SECCIÓN: Imagen --}}
            <div class="gv-form-card">
                <h3 class="gv-form-section-title">🖼️ Imagen del producto</h3>

                @if(isset($producto) && $producto && $producto->imagen_url)
                <div style="margin-bottom:20px;">
                    <p class="gv-label" style="margin-bottom:10px;">Imagen actual:</p>
                    <div style="width:160px;height:160px;border-radius:16px;overflow:hidden;
                                border:1px solid rgba(255,255,255,.08);background:#0b1628;">
                        <img src="{{ $producto->imagen_url }}"
                             alt="{{ $producto->nombre }}"
                             style="width:100%;height:100%;object-fit:cover;">
                    </div>
                    <p style="font-size:12px;color:#475569;margin-top:8px;">
                        Sube una nueva imagen para reemplazarla.
                    </p>
                </div>
                @endif

                <div class="gv-file-upload" id="file-upload-area">
                    <input type="file" name="imagen" id="imagen-input"
                           accept="image/jpg,image/jpeg,image/png,image/webp"
                           style="display:none;">
                    <div id="upload-placeholder"
                         onclick="document.getElementById('imagen-input').click()"
                         style="cursor:pointer;">
                        <div style="font-size:40px;margin-bottom:12px;">📷</div>
                        <p style="font-size:14px;font-weight:700;color:white;margin-bottom:6px;">
                            {{ isset($producto) && $producto && $producto->imagen ? 'Cambiar imagen' : 'Subir imagen' }}
                        </p>
                        <p style="font-size:12px;color:#475569;">
                            JPG, PNG o WebP — máximo 2MB
                        </p>
                        <div class="btn-primary" style="margin-top:16px;display:inline-flex;">
                            Seleccionar archivo
                        </div>
                    </div>
                    <div id="upload-preview" style="display:none;text-align:center;">
                        <img id="preview-img"
                             style="max-height:200px;border-radius:12px;margin-bottom:12px;">
                        <p id="preview-name" style="font-size:13px;color:#94a3b8;"></p>
                        <button type="button" onclick="clearPreview()"
                                style="margin-top:8px;background:rgba(239,68,68,.1);
                                       color:#f87171;border:1px solid rgba(239,68,68,.2);
                                       padding:6px 16px;border-radius:8px;font-size:12px;
                                       font-weight:600;cursor:pointer;">
                            Quitar imagen
                        </button>
                    </div>
                </div>
            </div>

            {{-- Botones --}}
            <div style="display:flex;gap:12px;justify-content:flex-end;padding-top:8px;">
                <a href="{{ route('admin.productos.index') }}" class="btn-outline-light">
                    Cancelar
                </a>
                <button type="submit" class="btn-primary">
                    {{ isset($producto) && $producto ? '💾 Guardar cambios' : '✅ Crear producto' }}
                </button>
            </div>

        </form>
    </div>
</div>

@push('scripts')
<script>
// Preview de imagen seleccionada
document.getElementById('imagen-input').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(ev) {
        document.getElementById('preview-img').src = ev.target.result;
        document.getElementById('preview-name').textContent = file.name + ' (' + (file.size / 1024).toFixed(0) + ' KB)';
        document.getElementById('upload-placeholder').style.display = 'none';
        document.getElementById('upload-preview').style.display = 'block';
    };
    reader.readAsDataURL(file);
});

function clearPreview() {
    document.getElementById('imagen-input').value = '';
    document.getElementById('upload-placeholder').style.display = 'block';
    document.getElementById('upload-preview').style.display = 'none';
}

// Drag & drop
const area = document.getElementById('file-upload-area');
area.addEventListener('dragover', e => {
    e.preventDefault();
    area.style.borderColor = 'rgba(37,99,235,.6)';
    area.style.background  = 'rgba(37,99,235,.04)';
});
area.addEventListener('dragleave', () => {
    area.style.borderColor = 'rgba(255,255,255,.08)';
    area.style.background  = '';
});
area.addEventListener('drop', e => {
    e.preventDefault();
    area.style.borderColor = 'rgba(255,255,255,.08)';
    area.style.background  = '';
    const file = e.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        const input = document.getElementById('imagen-input');
        const dt = new DataTransfer();
        dt.items.add(file);
        input.files = dt.files;
        input.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush

@endsection