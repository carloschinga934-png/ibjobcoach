
@extends('shared.layout')

@push('styles')
<style>
.search-section { background: #f8f9fa; border-radius: 10px; padding: 20px; margin-bottom: 20px; }
.stats-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 10px; padding: 15px; margin-bottom: 10px; }
.user-status { padding: 4px 8px; border-radius: 15px; font-size: 12px; font-weight: bold; }
.status-activo { background: #d4edda; color: #155724; }
.status-prueba { background: #fff3cd; color: #856404; }
.status-inactivo { background: #f8d7da; color: #721c24; }
.table-hover tbody tr:hover { background-color: #f5f5f5; }
</style>
@endpush

@section('content')
    <div class="container py-4">
        <div class="row mb-4">
            <div class="col-md-8">
                <h1 class="mb-3">
                    <i class="fas fa-users"></i> Gestión de Usuarios
                </h1>
            </div>
            <div class="col-md-4 text-end">
                <span class="badge bg-primary fs-6">{{ $usuarios->total() }} usuarios encontrados</span>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <h3>{{ $estadisticas['total'] }}</h3>
                    <p class="mb-0">Total Usuarios</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <h3>{{ $estadisticas['activos'] }}</h3>
                    <p class="mb-0">Activos</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <h3>{{ $estadisticas['prueba'] }}</h3>
                    <p class="mb-0">En Prueba</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <h3>{{ $estadisticas['inactivos'] }}</h3>
                    <p class="mb-0">Inactivos</p>
                </div>
            </div>
        </div>

        <!-- Formulario de búsqueda -->
        <div class="search-section">
            <form method="GET" action="{{ route('users.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="nombre" class="form-label fw-semibold">Buscar por nombre:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" 
                               value="{{ request('nombre') }}" placeholder="Nombre o apellido...">
                    </div>
                    
                    <div class="col-md-2">
                        <label for="estado" class="form-label fw-semibold">Estado:</label>
                        <select id="estado" name="estado" class="form-select">
                            <option value="">Todos los estados</option>
                            <option value="activo" {{ request('estado') === 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="prueba" {{ request('estado') === 'prueba' ? 'selected' : '' }}>Prueba</option>
                            <option value="inactivo" {{ request('estado') === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="progreso" class="form-label fw-semibold">Progreso:</label>
                        <select id="progreso" name="progreso" class="form-select">
                            <option value="">Todo el progreso</option>
                            <option value="activo" {{ request('progreso') === 'activo' ? 'selected' : '' }}>Activos</option>
                            <option value="prueba_vigente" {{ request('progreso') === 'prueba_vigente' ? 'selected' : '' }}>Prueba Vigente</option>
                            <option value="prueba_vencida" {{ request('progreso') === 'prueba_vencida' ? 'selected' : '' }}>Prueba Vencida</option>
                            <option value="inactivo" {{ request('progreso') === 'inactivo' ? 'selected' : '' }}>Inactivos</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="correo" class="form-label fw-semibold">Buscar por email:</label>
                        <input type="email" id="correo" name="correo" class="form-control" 
                               value="{{ request('correo') }}" placeholder="correo@ejemplo.com">
                    </div>

                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-eraser"></i> Limpiar
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabla de usuarios -->
        @if ($usuarios->count() > 0)
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre Completo</th>
                                    <th>Email</th>
                                    <th>País</th>
                                    <th>Teléfono</th>
                                    <th>Estado</th>
                                    <th>Fin Prueba</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usuarios as $usuario)
                                    <tr>
                                        <td><strong>{{ $usuario->idusuario }}</strong></td>
                                        <td>
                                            <div>
                                                <strong>{{ $usuario->nombre }} {{ $usuario->apellido }}</strong>
                                                @if($usuario->cargo)
                                                    <br><small class="text-muted">{{ $usuario->cargo }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{ $usuario->correo }}</td>
                                        <td>{{ $usuario->pais ?? 'No especificado' }}</td>
                                        <td>{{ $usuario->telefono ?? 'No especificado' }}</td>
                                        <td>
                                            <span class="user-status status-{{ $usuario->status }}">
                                                {{ ucfirst($usuario->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($usuario->fin_prueba)
                                                {{ \Carbon\Carbon::parse($usuario->fin_prueba)->format('d/m/Y') }}
                                                @if($usuario->status === 'prueba')
                                                    <br>
                                                    @if(now()->lt($usuario->fin_prueba))
                                                        <small class="text-success">Vigente</small>
                                                    @else
                                                        <small class="text-danger">Vencida</small>
                                                    @endif
                                                @endif
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('users.show', $usuario->idusuario) }}" 
                                                   class="btn btn-sm btn-info" title="Ver detalles">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Paginación -->
            <div class="d-flex justify-content-center mt-4">
                {{ $usuarios->links() }}
            </div>
        @else
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No se encontraron usuarios</h4>
                    <p class="text-muted">Intenta ajustar los filtros de búsqueda o 
                        <a href="{{ route('users.index') }}">ver todos los usuarios</a>
                    </p>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
// Auto-enviar formulario al cambiar select
document.addEventListener('DOMContentLoaded', function() {
    const selects = document.querySelectorAll('#estado, #progreso');
    selects.forEach(select => {
        select.addEventListener('change', function() {
            // Opcional: enviar automáticamente al cambiar
            // this.form.submit();
        });
    });
});
</script>
@endpush