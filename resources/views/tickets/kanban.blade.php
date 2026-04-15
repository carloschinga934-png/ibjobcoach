<!-- resources/views/tickets/kanban.blade.php -->

@extends('shared.layout')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Dashboard de Tickets - Kanban</h2>

    <div class="row">
        <!-- Pendientes -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h4>Pendientes</h4>
                </div>
                <div class="card-body">
                    @foreach($pendientes as $ticket)
                        <div class="kanban-item card mb-2">
                            <div class="card-body">
                                <h5>{{ $ticket->titulo }}</h5>
                                <p><strong>Cliente:</strong> {{ $ticket->usuario->nombre }}</p>
                                <p><strong>Fecha límite:</strong> {{ $ticket->fecha_limite ? $ticket->fecha_limite->format('d/m/Y') : 'N/A' }}</p>
                                <a href="{{ route('tickets.show', [$ticket->usuario_id, $ticket->id]) }}" class="btn btn-info btn-sm">Ver Detalles</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Por Atender Hoy -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>Por Atender Hoy</h4>
                </div>
                <div class="card-body">
                    @foreach($porAtenderHoy as $ticket)
                        <div class="kanban-item card mb-2">
                            <div class="card-body">
                                <h5>{{ $ticket->titulo }}</h5>
                                <p><strong>Cliente:</strong> {{ $ticket->usuario->nombre }}</p>
                                <p><strong>Fecha límite:</strong> {{ $ticket->fecha_limite->format('d/m/Y') }}</p>
                                <a href="{{ route('tickets.show', [$ticket->usuario_id, $ticket->id]) }}" class="btn btn-info btn-sm">Ver Detalles</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Resueltos -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4>Resueltos</h4>
                </div>
                <div class="card-body">
                    @foreach($resueltos as $ticket)
                        <div class="kanban-item card mb-2">
                            <div class="card-body">
                                <h5>{{ $ticket->titulo }}</h5>
                                <p><strong>Cliente:</strong> {{ $ticket->usuario->nombre }}</p>
                                <p><strong>Fecha de resolución:</strong> {{ $ticket->fecha_resolucion->format('d/m/Y') }}</p>
                                <a href="{{ route('tickets.show', [$ticket->usuario_id, $ticket->id]) }}" class="btn btn-info btn-sm">Ver Detalles</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Activos -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4>Activos</h4>
                </div>
                <div class="card-body">
                    @foreach($activos as $ticket)
                        <div class="kanban-item card mb-2">
                            <div class="card-body">
                                <h5>{{ $ticket->titulo }}</h5>
                                <p><strong>Cliente:</strong> {{ $ticket->usuario->nombre }}</p>
                                <p><strong>Estado:</strong> {{ ucfirst($ticket->estado) }}</p>
                                <a href="{{ route('tickets.show', [$ticket->usuario_id, $ticket->id]) }}" class="btn btn-info btn-sm">Ver Detalles</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
