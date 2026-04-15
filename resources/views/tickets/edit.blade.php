@extends('shared.layout')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Editar Ticket: {{ $ticket->numero_ticket }}</h2>

    <form method="POST" action="{{ route('tickets.update', [$usuario->idusuario, $ticket->id]) }}">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título *</label>
                    <input type="text" name="titulo" id="titulo" class="form-control" value="{{ $ticket->titulo }}" required>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción *</label>
                    <textarea name="descripcion" id="descripcion" class="form-control" rows="4" required>{{ $ticket->descripcion }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="prioridad" class="form-label">Prioridad *</label>
                    <select name="prioridad" id="prioridad" class="form-select" required>
                        <option value="baja" {{ $ticket->prioridad == 'baja' ? 'selected' : '' }}>Baja</option>
                        <option value="normal" {{ $ticket->prioridad == 'normal' ? 'selected' : '' }}>Normal</option>
                        <option value="alta" {{ $ticket->prioridad == 'alta' ? 'selected' : '' }}>Alta</option>
                        <option value="urgente" {{ $ticket->prioridad == 'urgente' ? 'selected' : '' }}>Urgente</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="categoria" class="form-label">Categoría *</label>
                    <select name="categoria" id="categoria" class="form-select" required>
                        <option value="tecnico" {{ $ticket->categoria == 'tecnico' ? 'selected' : '' }}>Técnico</option>
                        <option value="comercial" {{ $ticket->categoria == 'comercial' ? 'selected' : '' }}>Comercial</option>
                        <option value="facturacion" {{ $ticket->categoria == 'facturacion' ? 'selected' : '' }}>Facturación</option>
                        <option value="general" {{ $ticket->categoria == 'general' ? 'selected' : '' }}>General</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="asignado_a" class="form-label">Asignar a *</label>
                    <select name="asignado_a" id="asignado_a" class="form-select">
                        <option value="">Seleccionar Empleado</option>
                        @foreach($empleados as $empleado)
                            <option value="{{ $empleado->idusuario }}" {{ $ticket->asignado_a == $empleado->idusuario ? 'selected' : '' }}>
                                {{ $empleado->nombre }} {{ $empleado->apellido }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="fecha_limite" class="form-label">Fecha Límite</label>
                    <input type="date" name="fecha_limite" id="fecha_limite" class="form-control" value="{{ $ticket->fecha_limite ? $ticket->fecha_limite->format('Y-m-d') : '' }}">
                </div>

                <button type="submit" class="btn btn-warning mt-3">Actualizar Ticket</button>
            </div>
        </div>
    </form>
</div>
@endsection