@extends('auth.layout.dash_layout')

@section('title', 'Dashboard')

@section('body')
    <div class="ib-wrapper">
        {{-- Sidebar --}}
        @include('auth.layout.partials.sidebar')

        <main class="ib-main-panel">
            {{-- Navbar --}}
            @include('auth.layout.partials.navbar')

            {{-- Content --}}
            <section class="ib-content">
                <div class="container py-4">
                    {{-- Encabezado del perfil --}}
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body d-flex align-items-center">
                            <img src="{{ $usuario->avatar ?? asset('img/auth/dashboard/faces/gerente.png')}}" alt=" Foto de
                                perfil" class="rounded-circle me-3" width="100" height="100">
                            <div>
                                <h4 class="mb-1">{{ $usuario->nombre }} {{ $usuario->apellido }}</h4>
                                <p class="text-muted mb-0">Jefe{{ $usuario->cargo }} en {{ $usuario->empresa }}IBCORP</p>
                                <small class="text-secondary">Miembro desde
                                    {{ $usuario->created_at->format('d/m/Y') }}</small>
                            </div>
                        </div>
                    </div>

                    {{-- Progreso educativo --}}
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white fw-bold">
                            Mi progreso
                        </div>
                        <div class="card-body">
                            <p class="mb-1">Cursos completados: <strong> 0 {{ $usuario->cursosCompletados }}</strong></p>
                            <p class="mb-1">Horas invertidas: <strong> 0 {{ $usuario->horasEstudio }} hrs</strong></p>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: {{ $usuario->progresoPorcentaje }}%;"
                                    aria-valuenow="{{ $usuario->progresoPorcentaje }}" aria-valuemin="0"
                                    aria-valuemax="100">
                                    {{ $usuario->progresoPorcentaje }}%
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Acciones rápidas --}}
                    <div class="row g-3">
                        <div class="col-md-4">
                            <a href="{{ route('usuario.cursos') }}" class="text-decoration-none">
                                <div class="card shadow-sm border-0 h-100 text-center p-4">
                                    <i class="bi bi-journal-text fs-1 text-primary mb-2"></i>
                                    <h5 class="fw-bold" style="color: var(--ib-red);">Mis Cursos</h5>
                                    <p class="text-muted mb-0">Consulta y continúa tus cursos actuales</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('usuario.configuracion') }}" class="text-decoration-none">
                                <div class="card shadow-sm border-0 h-100 text-center p-4">
                                    <i class="bi bi-gear fs-1 text-secondary mb-2"></i>
                                    <h5 class="fw-bold" style="color: var(--ib-red);">Configuración</h5>
                                    <p class="text-muted mb-0">Actualiza tu información y preferencias</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('usuario.certificados') }}" class="text-decoration-none">
                                <div class="card shadow-sm border-0 h-100 text-center p-4">
                                    <i class="bi bi-award fs-1 text-warning mb-2"></i>
                                    <h5 class="fw-bold" style="color: var(--ib-red);">Certificados</h5>
                                    <p class="text-muted mb-0">Descarga y comparte tus logros</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            @include('auth.layout.partials.footer')
        </main>
    </div>
@endsection