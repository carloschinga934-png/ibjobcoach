@extends('shared.layout')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Crear Nuevo Ticket</h2>
                <a href="{{ route('tickets.index', $usuario->idusuario) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>

            <!-- Mostrar errores de validación -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Mostrar mensaje de éxito -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Mostrar mensaje de error -->
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('tickets.store', $usuario->idusuario) }}" id="ticketForm">
                @csrf
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-ticket-alt"></i> Información del Ticket
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Usuario solicitante (solo informativo) -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Solicitante</label>
                            <div class="p-2 bg-light rounded">
                                {{ $usuario->nombre }} {{ $usuario->apellido }}
                                <small class="text-muted">({{ $usuario->email }})</small>
                            </div>
                        </div>

                        <!-- Título del Ticket -->
                        <div class="mb-3">
                            <label for="titulo" class="form-label fw-bold">
                                Título <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="titulo" 
                                   id="titulo" 
                                   class="form-control @error('titulo') is-invalid @enderror" 
                                   value="{{ old('titulo') }}"
                                   required
                                   placeholder="Describe brevemente el problema o solicitud">
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Descripción del Ticket -->
                        <div class="mb-3">
                            <label for="descripcion" class="form-label fw-bold">
                                Descripción <span class="text-danger">*</span>
                            </label>
                            <textarea name="descripcion" 
                                      id="descripcion" 
                                      class="form-control @error('descripcion') is-invalid @enderror" 
                                      rows="4" 
                                      required
                                      placeholder="Proporciona todos los detalles relevantes sobre el problema o solicitud">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Prioridad -->
                            <div class="col-md-6 mb-3">
                                <label for="prioridad" class="form-label fw-bold">
                                    Prioridad <span class="text-danger">*</span>
                                </label>
                                <select name="prioridad" 
                                        id="prioridad" 
                                        class="form-select @error('prioridad') is-invalid @enderror" 
                                        required>
                                    <option value="">Seleccionar...</option>
                                    <option value="baja" {{ old('prioridad') == 'baja' ? 'selected' : '' }}>
                                        📗 Baja
                                    </option>
                                    <option value="normal" {{ old('prioridad') == 'normal' ? 'selected' : '' }} selected>
                                        📘 Normal
                                    </option>
                                    <option value="alta" {{ old('prioridad') == 'alta' ? 'selected' : '' }}>
                                        📙 Alta
                                    </option>
                                    <option value="urgente" {{ old('prioridad') == 'urgente' ? 'selected' : '' }}>
                                        📕 Urgente
                                    </option>
                                </select>
                                @error('prioridad')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Categoría -->
                            <div class="col-md-6 mb-3">
                                <label for="categoria" class="form-label fw-bold">
                                    Categoría <span class="text-danger">*</span>
                                </label>
                                <select name="categoria" 
                                        id="categoria" 
                                        class="form-select @error('categoria') is-invalid @enderror" 
                                        required>
                                    <option value="">Seleccionar...</option>
                                    <option value="tecnico" {{ old('categoria') == 'tecnico' ? 'selected' : '' }}>
                                        🔧 Técnico
                                    </option>
                                    <option value="comercial" {{ old('categoria') == 'comercial' ? 'selected' : '' }}>
                                        💼 Comercial
                                    </option>
                                    <option value="facturacion" {{ old('categoria') == 'facturacion' ? 'selected' : '' }}>
                                        💰 Facturación
                                    </option>
                                    <option value="general" {{ old('categoria') == 'general' ? 'selected' : '' }}>
                                        📋 General
                                    </option>
                                </select>
                                @error('categoria')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Asignación a un empleado -->
                            <div class="col-md-6 mb-3">
                                <label for="asignado_a" class="form-label fw-bold">
                                    Asignar a
                                    <small class="text-muted">(Opcional)</small>
                                </label>
                                <select name="asignado_a" 
                                        id="asignado_a" 
                                        class="form-select @error('asignado_a') is-invalid @enderror">
                                    <option value="">Sin asignar</option>
                                    @forelse($empleados as $empleado)
                                        <option value="{{ $empleado->idusuario }}" 
                                                {{ old('asignado_a') == $empleado->idusuario ? 'selected' : '' }}>
                                            {{ $empleado->nombre }} {{ $empleado->apellido }}
                                        </option>
                                    @empty
                                        <option value="" disabled>No hay empleados disponibles</option>
                                    @endforelse
                                </select>
                                @error('asignado_a')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Fecha límite -->
                            <div class="col-md-6 mb-3">
                                <label for="fecha_limite" class="form-label fw-bold">
                                    Fecha Límite
                                    <small class="text-muted">(Opcional)</small>
                                </label>
                                <input type="date" 
                                       name="fecha_limite" 
                                       id="fecha_limite" 
                                       class="form-control @error('fecha_limite') is-invalid @enderror"
                                       value="{{ old('fecha_limite') }}"
                                       min="{{ date('Y-m-d') }}">
                                @error('fecha_limite')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('tickets.index', $usuario->idusuario) }}" 
                       class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-success" id="submitBtn">
                        <i class="fas fa-plus"></i> Crear Ticket
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación del formulario en el cliente
    const form = document.getElementById('ticketForm');
    const submitBtn = document.getElementById('submitBtn');
    
    form.addEventListener('submit', function(e) {
        // Cambiar texto del botón para indicar que se está procesando
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creando...';
        submitBtn.disabled = true;
        
        // Validaciones básicas
        const titulo = document.getElementById('titulo').value.trim();
        const descripcion = document.getElementById('descripcion').value.trim();
        const prioridad = document.getElementById('prioridad').value;
        const categoria = document.getElementById('categoria').value;
        
        if (!titulo || !descripcion || !prioridad || !categoria) {
            e.preventDefault();
            submitBtn.innerHTML = '<i class="fas fa-plus"></i> Crear Ticket';
            submitBtn.disabled = false;
            alert('Por favor, completa todos los campos obligatorios.');
            return false;
        }
    });
    
    // Restaurar botón si hay errores y se recarga la página
    window.addEventListener('pageshow', function() {
        submitBtn.innerHTML = '<i class="fas fa-plus"></i> Crear Ticket';
        submitBtn.disabled = false;
    });
});
</script>
@endsection