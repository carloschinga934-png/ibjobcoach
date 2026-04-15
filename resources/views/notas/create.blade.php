@extends('shared.layout')

@push('styles')
<style>
.form-header { 
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
    color: white; 
    padding: 20px; 
    border-radius: 10px 10px 0 0; 
}
.form-card { 
    border: none; 
    box-shadow: 0 4px 20px rgba(0,0,0,0.1); 
    border-radius: 15px; 
}
.tipo-option { 
    border: 2px solid #e9ecef; 
    border-radius: 10px; 
    padding: 15px; 
    margin: 5px 0; 
    cursor: pointer; 
    transition: all 0.3s;
}
.tipo-option:hover { border-color: #007bff; }
.tipo-option.selected { border-color: #007bff; background: #f8f9ff; }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-card card">
                <div class="form-header">
                    <div class="d-flex align-items-center">
                        <div class="user-avatar me-3" style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            {{ strtoupper(substr($usuario->nombre, 0, 1)) }}{{ strtoupper(substr($usuario->apellido, 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="mb-1">Nueva Nota</h3>
                            <p class="mb-0 opacity-75">Para: {{ $usuario->nombre }} {{ $usuario->apellido }}</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('notas.store', $usuario->idusuario) }}" method="POST">
                        @csrf

                        <!-- Título -->
                        <div class="mb-3">
                            <label for="titulo" class="form-label fw-bold">Título de la nota *</label>
                            <input type="text" 
                                   class="form-control @error('titulo') is-invalid @enderror" 
                                   id="titulo" 
                                   name="titulo" 
                                   value="{{ old('titulo') }}"
                                   placeholder="Ej: Seguimiento comercial, Problema técnico, etc."
                                   maxlength="200"
                                   required>
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tipo de nota -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Tipo de nota *</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="tipo-option" onclick="selectTipo('info')">
                                        <input type="radio" name="tipo" value="info" id="tipo_info" {{ old('tipo') == 'info' ? 'checked' : '' }} hidden>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-info-circle text-primary me-2"></i>
                                            <div>
                                                <strong>Información</strong>
                                                <small class="d-block text-muted">Notas generales e informativas</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tipo-option" onclick="selectTipo('seguimiento')">
                                        <input type="radio" name="tipo" value="seguimiento" id="tipo_seguimiento" {{ old('tipo') == 'seguimiento' ? 'checked' : '' }} hidden>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-clock text-info me-2"></i>
                                            <div>
                                                <strong>Seguimiento</strong>
                                                <small class="d-block text-muted">Para hacer seguimiento posterior</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tipo-option" onclick="selectTipo('resuelto')">
                                        <input type="radio" name="tipo" value="resuelto" id="tipo_resuelto" {{ old('tipo') == 'resuelto' ? 'checked' : '' }} hidden>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            <div>
                                                <strong>Resuelto</strong>
                                                <small class="d-block text-muted">Problema o tarea completada</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="tipo-option" onclick="selectTipo('importante')">
                                        <input type="radio" name="tipo" value="importante" id="tipo_importante" {{ old('tipo') == 'importante' ? 'checked' : '' }} hidden>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                            <div>
                                                <strong>Importante</strong>
                                                <small class="d-block text-muted">Requiere atención especial</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tipo-option" onclick="selectTipo('problema')">
                                        <input type="radio" name="tipo" value="problema" id="tipo_problema" {{ old('tipo') == 'problema' ? 'checked' : '' }} hidden>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-bug text-danger me-2"></i>
                                            <div>
                                                <strong>Problema</strong>
                                                <small class="d-block text-muted">Incidencia o problema técnico</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @error('tipo')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contenido -->
                        <div class="mb-3">
                            <label for="contenido" class="form-label fw-bold">Contenido de la nota *</label>
                            <textarea class="form-control @error('contenido') is-invalid @enderror" 
                                      id="contenido" 
                                      name="contenido" 
                                      rows="6" 
                                      placeholder="Escribe aquí el contenido detallado de la nota..."
                                      maxlength="5000"
                                      required>{{ old('contenido') }}</textarea>
                            <div class="form-text">Máximo 5000 caracteres</div>
                            @error('contenido')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Privacidad -->
                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="es_privada" 
                                       name="es_privada" 
                                       value="1"
                                       {{ old('es_privada') ? 'checked' : '' }}>
                                <label class="form-check-label" for="es_privada">
                                    <strong>Nota privada</strong>
                                    <small class="d-block text-muted">Solo tú podrás ver esta nota</small>
                                </label>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('notas.index', $usuario->idusuario) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Guardar Nota
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function selectTipo(tipo) {
    // Desmarcar todos
    document.querySelectorAll('.tipo-option').forEach(el => {
        el.classList.remove('selected');
    });
    
    document.querySelectorAll('input[name="tipo"]').forEach(el => {
        el.checked = false;
    });
    
    // Marcar el seleccionado
    document.getElementById('tipo_' + tipo).checked = true;
    document.getElementById('tipo_' + tipo).closest('.tipo-option').classList.add('selected');
}

// Marcar el tipo seleccionado al cargar
document.addEventListener('DOMContentLoaded', function() {
    const checkedTipo = document.querySelector('input[name="tipo"]:checked');
    if (checkedTipo) {
        checkedTipo.closest('.tipo-option').classList.add('selected');
    }
    
    // Contador de caracteres
    const textarea = document.getElementById('contenido');
    const maxLength = 5000;
    
    textarea.addEventListener('input', function() {
        const remaining = maxLength - this.value.length;
        const helpText = this.nextElementSibling;
        helpText.textContent = `${remaining} caracteres restantes`;
        
        if (remaining < 100) {
            helpText.classList.add('text-warning');
        } else {
            helpText.classList.remove('text-warning');
        }
    });
});
</script>
@endpush