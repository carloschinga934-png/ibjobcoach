<!-- resources/views/tickets/validacion.blade.php -->
@extends('shared.layout')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Dashboard de Validación</h2>
    
    @if($ticketsPorValidar->count() > 0)
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title">Pendientes Validación</h5>
                        <p class="card-text fs-3">{{ $estadisticasValidacion['pendientes_validacion'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Validados Hoy</h5>
                        <p class="card-text fs-3">{{ $estadisticasValidacion['validados_hoy'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">Tiempo Promedio</h5>
                        <p class="card-text fs-3">{{ round($estadisticasValidacion['tiempo_promedio_resolucion'] ?? 0, 1) }}h</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Tickets por Validar</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Número</th>
                                <th>Título</th>
                                <th>Cliente</th>
                                <th>Asignado a</th>
                                <th>Fecha Resolución</th>
                                <th>Prioridad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ticketsPorValidar as $ticket)
                                <tr>
                                    <td>{{ $ticket->numero_ticket }}</td>
                                    <td>{{ $ticket->titulo }}</td>
                                    <td>{{ $ticket->usuario->nombre }}</td>
                                    <td>{{ $ticket->asignado->nombre ?? 'Sin asignar' }}</td>
                                    <td>{{ $ticket->fecha_resolucion->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $ticket->color_prioridad }}">
                                            {{ ucfirst($ticket->prioridad) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('tickets.show', ['usuarioId' => $ticket->usuario_id, 'ticketId' => $ticket->id]) }}" 
                                               class="btn btn-sm btn-outline-primary">Ver</a>
                                            
                                            <button type="button" class="btn btn-sm btn-success" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#validarModal{{ $ticket->id }}">
                                                Validar
                                            </button>
                                            
                                            <button type="button" class="btn btn-sm btn-warning" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#rechazarModal{{ $ticket->id }}">
                                                Rechazar
                                            </button>
                                        </div>

                                        <!-- Modal Validar -->
                                        <div class="modal fade" id="validarModal{{ $ticket->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Validar Ticket #{{ $ticket->numero_ticket }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{ route('tickets.validar', $ticket->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="observaciones{{ $ticket->id }}" class="form-label">Observaciones (opcional)</label>
                                                                <textarea class="form-control" id="observaciones{{ $ticket->id }}" 
                                                                          name="observaciones_validacion" rows="3" 
                                                                          placeholder="Comentarios sobre la validación..."></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                            <button type="submit" class="btn btn-success">Validar Ticket</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Rechazar -->
                                        <div class="modal fade" id="rechazarModal{{ $ticket->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Rechazar Validación #{{ $ticket->numero_ticket }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{ route('tickets.rechazar', $ticket->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="motivo{{ $ticket->id }}" class="form-label">Motivo del rechazo *</label>
                                                                <textarea class="form-control" id="motivo{{ $ticket->id }}" 
                                                                          name="motivo_rechazo" rows="3" required
                                                                          placeholder="Explica por qué rechazas la validación..."></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                            <button type="submit" class="btn btn-warning">Rechazar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info">
            <h5>¡Todo al día!</h5>
            <p class="mb-0">No hay tickets pendientes de validación en este momento.</p>
        </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('tickets.dashboard') }}" class="btn btn-primary">Volver al Dashboard</a>
        <a href="{{ route('tickets.general') }}" class="btn btn-outline-primary">Ver Todos los Tickets</a>
    </div>
</div>
@endsection