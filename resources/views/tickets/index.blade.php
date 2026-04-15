@extends('shared.layout')

@push('styles')
<style>
    .tickets-header { 
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%); 
        color: white; 
        padding: 20px; 
        border-radius: 10px 10px 0 0; 
    }
    .ticket-card { 
        border: none; 
        box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
        border-radius: 10px; 
        margin-bottom: 15px; 
        transition: transform 0.2s;
    }
    .ticket-card:hover { transform: translateY(-2px); }
    .ticket-numero { 
        font-family: 'Courier New', monospace; 
        background: #f8f9fa; 
        padding: 2px 8px; 
        border-radius: 4px; 
        font-size: 0.9rem;
    }
    .prioridad-badge { 
        padding: 4px 8px; 
        border-radius: 12px; 
        font-size: 11px; 
        font-weight: bold; 
        text-transform: uppercase;
    }
    .estado-badge { 
        padding: 6px 12px; 
        border-radius: 15px; 
        font-size: 12px; 
        font-weight: bold;
    }
    .ticket-vencido { 
        border-left: 4px solid #dc3545; 
        background: #fff5f5; 
    }
    .ticket-validado { 
        border-left: 4px solid #28a745; 
        background: #f8fff9; 
    }
    .ticket-sin-validar { 
        border-left: 4px solid #ffc107; 
        background: #fffdf0; 
    }
    .stats-mini { 
        background: rgba(255,255,255,0.9); 
        padding: 15px; 
        border-radius: 8px; 
        text-align: center; 
        margin: 5px; 
        color: #333;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="card mb-4">
        <div class="tickets-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center">
                        <div class="user-avatar me-3" style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                            @if($usuario)
                                {{ strtoupper(substr($usuario->nombre, 0, 1)) }}{{ strtoupper(substr($usuario->apellido, 0, 1)) }}
                            @else
                                <i class="fas fa-ticket-alt"></i>
                            @endif
                        </div>
                        <div>
                            <h2 class="mb-1">
                                @if($usuario)
                                    Tickets de {{ $usuario->nombre }} {{ $usuario->apellido }}
                                @else
                                    Gestión de Tickets de Soporte
                                @endif
                            </h2>
                            <p class="mb-0 opacity-75">
                                @if($usuario)
                                    {{ $usuario->correo }} • Estado: {{ ucfirst($usuario->status) }}
                                @else
                                    Sistema de atención al cliente
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    @if($usuario)
                        <a href="{{ route('users.show', $usuario->idusuario) }}" class="btn btn-light btn-sm me-2">
                            <i class="fas fa-user"></i> Ver Perfil
                        </a>
                        <a href="{{ route('tickets.create', $usuario->idusuario) }}" class="btn btn-warning">
                            <i class="fas fa-plus"></i> Nuevo Ticket
                        </a>
                    @else
                        <a href="{{ route('tickets.validacion') }}" class="btn btn-light btn-sm me-2">
                            <i class="fas fa-check-double"></i> Validar Tickets
                        </a>
                        <a href="{{ route('tickets.dashboard') }}" class="btn btn-warning">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="card-body">
            <div class="row">
                <div class="col-6 col-md-2">
                    <div class="stats-mini">
                        <h4 class="text-primary">{{ $estadisticas['total'] }}</h4>
                        <small>Total</small>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="stats-mini">
                        <h4 class="text-danger">{{ $estadisticas['abiertos'] }}</h4>
                        <small>Abiertos</small>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="stats-mini">
                        <h4 class="text-success">{{ $estadisticas['resueltos'] }}</h4>
                        <small>Resueltos</small>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="stats-mini">
                        <h4 class="text-warning">{{ $estadisticas['vencidos'] }}</h4>
                        <small>Vencidos</small>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="stats-mini">
                        <h4 class="text-info">{{ $estadisticas['validados'] }}</h4>
                        <small>Validados</small>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="stats-mini">
                        <h4 class="text-warning">{{ $estadisticas['sin_validar'] }}</h4>
                        <small>Sin Validar</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <select name="estado" class="form-select">
                        <option value="">Todos los estados</option>
                        <option value="abierto" {{ request('estado') == 'abierto' ? 'selected' : '' }}>Abierto</option>
                        <option value="en_progreso" {{ request('estado') == 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
                        <option value="esperando_cliente" {{ request('estado') == 'esperando_cliente' ? 'selected' : '' }}>Esperando Cliente</option>
                        <option value="resuelto" {{ request('estado') == 'resuelto' ? 'selected' : '' }}>Resuelto</option>
                        <option value="cerrado" {{ request('estado') == 'cerrado' ? 'selected' : '' }}>Cerrado</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="prioridad" class="form-select">
                        <option value="">Todas las prioridades</option>
                        <option value="urgente" {{ request('prioridad') == 'urgente' ? 'selected' : '' }}>Urgente</option>
                        <option value="alta" {{ request('prioridad') == 'alta' ? 'selected' : '' }}>Alta</option>
                        <option value="normal" {{ request('prioridad') == 'normal' ? 'selected' : '' }}>Normal</option>
                        <option value="baja" {{ request('prioridad') == 'baja' ? 'selected' : '' }}>Baja</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="categoria" class="form-select">
                        <option value="">Todas las categorías</option>
                        <option value="tecnico" {{ request('categoria') == 'tecnico' ? 'selected' : '' }}>Técnico</option>
                        <option value="comercial" {{ request('categoria') == 'comercial' ? 'selected' : '' }}>Comercial</option>
                        <option value="facturacion" {{ request('categoria') == 'facturacion' ? 'selected' : '' }}>Facturación</option>
                        <option value="general" {{ request('categoria') == 'general' ? 'selected' : '' }}>General</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="asignado_a" class="form-select">
                        <option value="">Todos los empleados</option>
                        @foreach($empleados as $empleado)
                            <option value="{{ $empleado->idusuario }}" {{ request('asignado_a') == $empleado->idusuario ? 'selected' : '' }}>{{ $empleado->nombre }} {{ $empleado->apellido }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de tickets -->
    @if($tickets->count() > 0)
        @foreach($tickets as $ticket)
            <div class="ticket-card card {{ $ticket->esta_vencido ? 'ticket-vencido' : '' }} {{ $ticket->validado ? 'ticket-validado' : ($ticket->estado === 'resuelto' ? 'ticket-sin-validar' : '') }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="d-flex align-items-start">
                                <i class="fas {{ $ticket->icono_estado }} text-{{ $ticket->color_estado }} me-2 mt-1"></i>
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="ticket-numero me-2">{{ $ticket->numero_ticket }}</span>
                                        <h5 class="mb-0 me-2">{{ $ticket->titulo }}</h5>
                                        <span class="prioridad-badge bg-{{ $ticket->color_prioridad }} text-white">{{ ucfirst($ticket->prioridad) }}</span>
                                    </div>

                                    <div class="mb-2">
                                        <span class="estado-badge bg-{{ $ticket->color_estado }} text-white">{{ ucfirst(str_replace('_', ' ', $ticket->estado)) }}</span>
                                        <span class="badge bg-secondary ms-1">{{ ucfirst($ticket->categoria) }}</span>
                                        
                                        @if($ticket->esta_vencido)
                                            <span class="badge bg-danger ms-1"><i class="fas fa-exclamation-triangle"></i> Vencido</span>
                                        @endif
                                      
                                        @if($ticket->validado)
                                            <span class="badge bg-success ms-1"><i class="fas fa-check-double"></i> Validado</span>
                                        @elseif($ticket->estado === 'resuelto')
                                            <span class="badge bg-warning ms-1"><i class="fas fa-clock"></i> Pendiente Validación</span>
                                        @endif
                                    </div>

                                    <p class="text-muted mb-2">{{ Str::limit($ticket->descripcion, 120) }}</p>

                                    <div class="d-flex align-items-center small text-muted">
                                        <i class="fas fa-user me-1"></i>
                                        <span class="me-3">Cliente: {{ $ticket->usuario->nombre }} {{ $ticket->usuario->apellido }}</span>

                                        @if($ticket->asignado)
                                            <i class="fas fa-user-tie me-1"></i>
                                            <span class="me-3">Asignado: {{ $ticket->asignado->nombre }}</span>
                                        @endif

                                        <i class="fas fa-clock me-1"></i>
                                        <span>{{ $ticket->tiempo_respuesta }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="mb-2">
                                @if($ticket->fecha_limite)
                                    <small class="text-muted"><i class="fas fa-calendar"></i> Límite: {{ $ticket->fecha_limite->format('d/m/Y') }}</small>
                                @endif
                            </div>

                            <div class="btn-group" role="group">
                                <a href="{{ route('tickets.show', [$ticket->usuario_id, $ticket->id]) }}" class="btn btn-sm btn-outline-primary" title="Ver detalle">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @if($ticket->puedeEditar(auth()->user()->idusuario))
                                    <a href="{{ route('tickets.edit', [$ticket->usuario_id, $ticket->id]) }}" class="btn btn-sm btn-outline-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif

                                @if($ticket->puedeResolver(auth()->user()->idusuario) && !in_array($ticket->estado, ['resuelto', 'cerrado']))
                                   <button type="button" class="btn btn-sm btn-outline-success" title="Resolver" onclick="resolverTicket({{ $ticket->usuario_id }}, {{ $ticket->id }})">
                                     <i class="fas fa-check"></i>
                                   </button>
                                @endif

                                @if($ticket->estado === 'resuelto' && !$ticket->validado && $ticket->puedeValidar(auth()->user()->idusuario))
                                    <button type="button" class="btn btn-sm btn-outline-info" title="Validar" onclick="validarTicket({{ $ticket->id }})">
                                        <i class="fas fa-check-double"></i>
                                    </button>
                                @endif

                                <form method="POST" action="{{ route('tickets.destroy', [$ticket->usuario_id, $ticket->id]) }}" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este ticket?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Paginación -->
        <div class="d-flex justify-content-center mt-4">
            {{ $tickets->appends(request()->query())->links() }}
        </div>
    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-ticket-alt fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No hay tickets</h4>
                <p class="text-muted">
                    @if($usuario)
                        Aún no hay tickets para este usuario.
                    @else
                        No se encontraron tickets con los filtros aplicados.
                    @endif
                </p>
                @if($usuario)
                    <a href="{{ route('tickets.create', $usuario->idusuario) }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Crear primer ticket
                    </a>
                @endif
            </div>
        </div>
    @endif
</div>

<!-- Modales -->
<!-- Modal para resolver ticket -->
<div class="modal fade" id="resolverModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Resolver Ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="resolverForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="solucion" class="form-label">Solución aplicada *</label>
                        <textarea class="form-control" id="solucion" name="solucion" rows="4" placeholder="Describe la solución aplicada..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check"></i> Marcar como Resuelto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para validar ticket -->
<div class="modal fade" id="validarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Validar Atención</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="validarForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        ¿La atención brindada resuelve correctamente el problema del cliente?
                    </div>
                    <div class="mb-3">
                        <label for="observaciones_validacion" class="form-label">Observaciones de validación</label>
                        <textarea class="form-control" id="observaciones_validacion" name="observaciones_validacion" rows="3" placeholder="Observaciones sobre la calidad de la atención (opcional)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-warning" onclick="rechazarValidacion()">
                        <i class="fas fa-times"></i> Rechazar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check-double"></i> Validar Atención
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para rechazar validación -->
<div class="modal fade" id="rechazarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rechazar Validación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="rechazarForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        El ticket será devuelto al empleado para corrección.
                    </div>
                    <div class="mb-3">
                        <label for="motivo_rechazo" class="form-label">Motivo del rechazo *</label>
                        <textarea class="form-control" id="motivo_rechazo" name="motivo_rechazo" rows="3" placeholder="Explica por qué no se valida la atención..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-undo"></i> Rechazar y Devolver
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function resolverTicket(usuarioId, ticketId) {
    const action = "{{ route('tickets.resolver.user', ['usuarioId' => ':usuarioId', 'ticketId' => ':ticketId']) }}"
        .replace(':usuarioId', usuarioId)
        .replace(':ticketId', ticketId);
    
    document.getElementById('resolverForm').action = action;
    new bootstrap.Modal(document.getElementById('resolverModal')).show();
}

function validarTicket(ticketId) {
    // Usar Laravel route helper para generar URL correcta
    const action = "{{ route('tickets.validar', ':ticketId') }}".replace(':ticketId', ticketId);
    
    document.getElementById('validarForm').action = action;
    new bootstrap.Modal(document.getElementById('validarModal')).show();
}

function rechazarValidacion() {
    const validarModal = bootstrap.Modal.getInstance(document.getElementById('validarModal'));
    validarModal.hide();
    
    // Copiar la acción del formulario de validar al de rechazar
    const validarAction = document.getElementById('validarForm').action;
    const rechazarAction = validarAction.replace('/validar', '/rechazar-validacion');
    
    document.getElementById('rechazarForm').action = rechazarAction;
    new bootstrap.Modal(document.getElementById('rechazarModal')).show();
}
</script>
@endpush
