<!-- resources/views/usuarios/show.blade.php -->

@extends('shared.layout')

@push('styles')
<style>
.user-profile-header { 
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
    color: white; 
    padding: 30px 0; 
    border-radius: 15px 15px 0 0; 
}
.user-avatar { 
    width: 80px; 
    height: 80px; 
    background: rgba(255,255,255,0.2); 
    border-radius: 50%; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    font-size: 2rem; 
}
.info-card { 
    border: none; 
    box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
    border-radius: 10px; 
    margin-bottom: 20px; 
}
.status-badge { 
    padding: 8px 16px; 
    border-radius: 20px; 
    font-weight: bold; 
    text-transform: uppercase; 
}
.status-activo { background: #d4edda; color: #155724; }
.status-prueba { background: #fff3cd; color: #856404; }
.status-inactivo { background: #f8d7da; color: #721c24; }
.detail-row { border-bottom: 1px solid #eee; padding: 15px 0; }
.detail-row:last-child { border-bottom: none; }
</style>
@endpush

@section('content')
    <div class="container py-4">
        <!-- Botón volver -->
        <div class="mb-3">
            <a href="{{ route('users.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Volver al listado
            </a>
        </div>

        <div class="card info-card">
            <!-- Header del perfil -->
            <div class="user-profile-header text-center">
                <div class="user-avatar mx-auto mb-3">
                    {{ strtoupper(substr($usuario->nombre, 0, 1)) }}{{ strtoupper(substr($usuario->apellido, 0, 1)) }}
                </div>
                <h2 class="mb-1">{{ $usuario->nombre }} {{ $usuario->apellido }}</h2>
                <p class="mb-0 opacity-75">{{ $usuario->cargo ?? 'Sin cargo especificado' }}</p>
            </div>

            <div class="card-body">
                <!-- Información básica -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-row">
                            <strong>ID de Usuario:</strong>
                            <span class="float-end">#{{ $usuario->idusuario }}</span>
                        </div>
                        
                        <div class="detail-row">
                            <strong>Nombre Completo:</strong>
                            <span class="float-end">{{ $usuario->nombre }} {{ $usuario->apellido }}</span>
                        </div>
                        
                        <div class="detail-row">
                            <strong>Email:</strong>
                            <span class="float-end">
                                <a href="mailto:{{ $usuario->correo }}">{{ $usuario->correo }}</a>
                            </span>
                        </div>
                        
                        <div class="detail-row">
                            <strong>Teléfono:</strong>
                            <span class="float-end">
                                @if($usuario->telefono)
                                    <a href="tel:{{ $usuario->telefono }}">{{ $usuario->telefono }}</a>
                                @else
                                    <span class="text-muted">No especificado</span>
                                @endif
                            </span>
                        </div>
                        
                        <div class="detail-row">
                            <strong>País:</strong>
                            <span class="float-end">{{ $usuario->pais ?? 'No especificado' }}</span>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="detail-row">
                            <strong>Estado:</strong>
                            <span class="float-end">
                                <span class="status-badge status-{{ $usuario->status }}">
                                    {{ ucfirst($usuario->status) }}
                                </span>
                            </span>
                        </div>
                        
                        <div class="detail-row">
                            <strong>Rol:</strong>
                            <span class="float-end">
                                @if($usuario->role)
                                    <span class="badge bg-secondary">{{ $usuario->role->nombre }}</span>
                                @else
                                    <span class="text-muted">Sin rol asignado</span>
                                @endif
                            </span>
                        </div>
                        
                        <div class="detail-row">
                            <strong>Fecha de Registro:</strong>
                            <span class="float-end">
                                {{ $usuario->created_at ? $usuario->created_at->format('d/m/Y H:i') : 'No disponible' }}
                            </span>
                        </div>
                        
                        <div class="detail-row">
                            <strong>Última Actualización:</strong>
                            <span class="float-end">
                                {{ $usuario->updated_at ? $usuario->updated_at->format('d/m/Y H:i') : 'No disponible' }}
                            </span>
                        </div>
                        
                        @if($usuario->fin_prueba)
                        <div class="detail-row">
                            <strong>Fin de Prueba:</strong>
                            <span class="float-end">
                                {{ \Carbon\Carbon::parse($usuario->fin_prueba)->format('d/m/Y H:i') }}
                                @if($usuario->status === 'prueba')
                                    @if(now()->lt($usuario->fin_prueba))
                                        <br><small class="text-success">✓ Prueba vigente</small>
                                    @else
                                        <br><small class="text-danger">✗ Prueba vencida</small>
                                    @endif
                                @endif
                            </span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Estado de la cuenta -->
                <div class="row mt-4">
                    <div class="col-12">
                        <h5 class="mb-3">Estado de la Cuenta</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="card {{ $usuario->esActivo() ? 'border-success' : 'border-secondary' }}">
                                    <div class="card-body text-center">
                                        <i class="fas {{ $usuario->esActivo() ? 'fa-check-circle text-success' : 'fa-times-circle text-secondary' }} fa-2x mb-2"></i>
                                        <h6>Usuario Activo</h6>
                                        <small>{{ $usuario->esActivo() ? 'SÍ' : 'NO' }}</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="card {{ $usuario->enPruebaValida() ? 'border-warning' : 'border-secondary' }}">
                                    <div class="card-body text-center">
                                        <i class="fas {{ $usuario->enPruebaValida() ? 'fa-clock text-warning' : 'fa-times-circle text-secondary' }} fa-2x mb-2"></i>
                                        <h6>Prueba Válida</h6>
                                        <small>{{ $usuario->enPruebaValida() ? 'SÍ' : 'NO' }}</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="card {{ $usuario->role ? 'border-info' : 'border-secondary' }}">
                                    <div class="card-body text-center">
                                        <i class="fas {{ $usuario->role ? 'fa-user-tag text-info' : 'fa-user text-secondary' }} fa-2x mb-2"></i>
                                        <h6>Rol Asignado</h6>
                                        <small>{{ $usuario->role ? $usuario->role->nombre : 'Sin rol' }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="row mt-4">
                    <div class="col-12 text-center">
                        <div class="btn-group" role="group">
                            <a href="{{ route('users.index') }}" class="btn btn-primary">
                                <i class="fas fa-list"></i> Ver Todos los Usuarios
                            </a>
                            <a href="{{ route('notas.index', $usuario->idusuario) }}" class="btn btn-info">
                                <i class="fas fa-sticky-note"></i> Ver Notas ({{ \App\Models\NotaUsuario::where('usuario_id', $usuario->idusuario)->count() }})
                            </a>
                            <button type="button" class="btn btn-success" onclick="contactUser()">
                                <i class="fas fa-envelope"></i> Contactar Usuario
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
function contactUser() {
    const email = '{{ $usuario->correo }}';
    const nombre = '{{ $usuario->nombre }} {{ $usuario->apellido }}';
    const subject = `Contacto desde el sistema - ${nombre}`;
    const mailtoLink = `mailto:${email}?subject=${encodeURIComponent(subject)}`;
    window.location.href = mailtoLink;
}
</script>
@endpush