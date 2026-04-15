// resources/views/tickets/show.blade.php

@extends('shared.layout')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Detalle del Ticket: {{ $ticket->numero_ticket }}</h2>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $ticket->titulo }}</h5>
            <p><strong>Descripción:</strong> {{ $ticket->descripcion }}</p>
            <p><strong>Categoría:</strong> {{ ucfirst($ticket->categoria) }}</p>
            <p><strong>Prioridad:</strong> <span class="badge bg-{{ $ticket->color_prioridad }}">{{ ucfirst($ticket->prioridad) }}</span></p>
            <p><strong>Estado:</strong> <span class="badge bg-{{ $ticket->color_estado }}">{{ ucfirst($ticket->estado) }}</span></p>

            @if($ticket->estado === 'resuelto')
                <p><strong>Solución:</strong> {{ $ticket->solucion }}</p>
            @endif

            @if($ticket->fecha_limite)
                <p><strong>Fecha Límite:</strong> {{ $ticket->fecha_limite->format('d/m/Y') }}</p>
            @endif

            @if($ticket->validado)
                <p><strong>Validado:</strong> Sí</p>
            @else
                <p><strong>Validación Pendiente</strong></p>
            @endif

            <h5>Actividades de Soporte</h5>
            <ul>
                @foreach ($ticket->actividades as $actividad)
                    <li>{{ $actividad->actividad }} - {{ $actividad->usuario->nombre }} - {{ $actividad->created_at->diffForHumans() }}</li>
                @endforeach
            </ul>
             <!-- Botón de validación solo visible para administradores -->
    @if(Auth::user()->is_admin)  <!-- Asegúrate de que este campo exista en el modelo de Usuario -->
        @if($ticket->estado == 'resuelto' && !$ticket->validado)
            <form method="POST" action="{{ route('tickets.validar', $ticket->id) }}">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-success">Validar Ticket</button>
            </form>
        @endif
    @endif

            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('tickets.index', $ticket->usuario_id) }}" class="btn btn-primary">Volver a la lista</a>
            </div>
        </div>
    </div>
</div>
@endsection
