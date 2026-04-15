@extends('shared.layout')

@push('styles')
<style>
.notas-header { 
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
    color: white; 
    padding: 20px; 
    border-radius: 10px 10px 0 0; 
}
.nota-card { 
    border: none; 
    box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
    border-radius: 10px; 
    margin-bottom: 15px; 
    transition: transform 0.2s;
}
.nota-card:hover { transform: translateY(-2px); }
.nota-tipo { 
    padding: 4px 10px; 
    border-radius: 15px; 
    font-size: 12px; 
    font-weight: bold; 
    text-transform: uppercase;
}
.nota-privada { 
    background: #ffe4e1; 
    border-left: 4px solid #ff6b6b; 
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
    <!-- Header con info del usuario -->
    <div class="card mb-4">
        <div class="notas-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center">
                        <div class="user-avatar me-3" style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                            {{ strtoupper(substr($usuario->nombre, 0, 1)) }}{{ strtoupper(substr($usuario->apellido, 0, 1)) }}
                        </div>
                        <div>
                            <h2 class="mb-1">Notas de {{ $usuario->nombre }} {{ $usuario->apellido }}</h2>
                            <p class="mb-0 opacity-75">{{ $usuario->correo }} • Estado: {{ ucfirst($usuario->status) }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('users.show', $usuario->idusuario) }}" class="btn btn-light btn-sm me-2">
                        <i class="fas fa-user"></i> Ver Perfil
                    </a>
                    <a href="{{ route('notas.create', $usuario->idusuario) }}" class="btn btn-warning">
                        <i class="fas fa-plus"></i> Nueva Nota
                    </a>
                </div>
            </div>
        </div>

        <!-- Estadísticas mini -->
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
                        <h4 class="text-primary">{{ $estadisticas['info'] }}</h4>
                        <small>Info</small>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="stats-mini">
                        <h4 class="text-warning">{{ $estadisticas['importante'] }}</h4>
                        <small>Importantes</small>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="stats-mini">
                        <h4 class="text-info">{{ $estadisticas['seguimiento'] }}</h4>
                        <small>Seguimiento</small>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="stats-mini">
                        <h4 class="text-danger">{{ $estadisticas['problema'] }}</h4>
                        <small>Problemas</small>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="stats-mini">
                        <h4 class="text-success">{{ $estadisticas['resuelto'] }}</h4>
                        <small>Resueltos</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de notas -->
    @if($notas->count() > 0)
        @foreach($notas as $nota)
            <div class="nota-card card {{ $nota->es_privada ? 'nota-privada' : '' }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="d-flex align-items-start">
                                <i class="fas {{ $nota->icono_tipo }} text-{{ $nota->color_tipo }} me-2 mt-1"></i>
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        <h5 class="mb-0 me-2">{{ $nota->titulo }}</h5>
                                        <span class="nota-tipo bg-{{ $nota->color_tipo }} text-white">
                                            {{ ucfirst($nota->tipo) }}
                                        </span>
                                        @if($nota->es_privada)
                                            <span class="badge bg-dark ms-2">
                                                <i class="fas fa-lock"></i> Privada
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-muted mb-2">
                                        {{ Str::limit($nota->contenido, 150) }}
                                    </p>
                                    <div class="d-flex align-items-center small text-muted">
                                        <i class="fas fa-user me-1"></i>
                                        <span class="me-3">{{ $nota->autor->nombre }} {{ $nota->autor->apellido }}</span>
                                        <i class="fas fa-clock me-1"></i>
                                        <span>{{ $nota->fecha_formateada }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="btn-group" role="group">
                                <a href="{{ route('notas.show', [$nota->usuario_id, $nota->id]) }}" 
                                   class="btn btn-sm btn-outline-primary" title="Ver detalle">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if($nota->autor_id === auth()->user()->idusuario)
                                    <a href="{{ route('notas.edit', [$nota->usuario_id, $nota->id]) }}" 
                                       class="btn btn-sm btn-outline-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" 
                                          action="{{ route('notas.destroy', [$nota->usuario_id, $nota->id]) }}" 
                                          class="d-inline"
                                          onsubmit="return confirm('¿Estás seguro de eliminar esta nota?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Paginación -->
        <div class="d-flex justify-content-center mt-4">
            {{ $notas->links() }}
        </div>
    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-sticky-note fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No hay notas</h4>
                <p class="text-muted">Aún no hay notas para este usuario.</p>
                <a href="{{ route('notas.create', $usuario->idusuario) }}" 
                   class="btn btn-primary">
                    <i class="fas fa-plus"></i> Crear primera nota
                </a>
            </div>
        </div>
    @endif
</div>
@endsection