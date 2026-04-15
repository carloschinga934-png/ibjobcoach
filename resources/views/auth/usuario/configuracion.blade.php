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
                <div class="container">
                    <h2 class="mb-4">Configuración de cuenta</h2>

                    <!-- Nav Tabs -->
                    <ul class="nav nav-tabs" id="configTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="perfil-tab" data-bs-toggle="tab" data-bs-target="#perfil"
                                type="button" role="tab" style="color: var(--ib-red);">
                                <i class="fa-solid fa-user-tie" style="color: #000000;"></i> Datos personales
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="password-tab" style="color: var(--ib-red);" data-bs-toggle="tab"
                                data-bs-target="#password" type="button" role="tab">
                                <i class="fa-solid fa-lock" style="color: #000000;"></i> Cambiar contraseña
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content mt-3" id="configTabsContent" style="margin: 20px;">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Datos personales -->
                        <div class="tab-pane fade show active" id="perfil" role="tabpanel">
                            <form method="POST" action="{{ route('usuario.actualizar.datos') }}" id="form-actualizar-datos"
                                style="margin-bottom: 20px;">
                                @csrf
                                <div class="mb-3">
                                    <label>Nombre</label>
                                    <input type="text" name="nombre" value="{{ old('nombre', $usuario->nombre) }}"
                                        class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>correo</label>
                                    <input type="email" name="correo" value="{{ old('correo', $usuario->correo) }}"
                                        class="form-control">
                                </div>
                                <button type="button" class="btn btn-primary"
                                    style="background-color: var(--ib-red);border:1px solid var(--ib-red);"
                                    data-bs-toggle="modal" data-bs-target="#modalConfirmarDatosUsuario">
                                    Guardar cambios
                                </button>
                            </form>
                        </div>

                        <!-- Cambiar contraseña -->
                        <div class="tab-pane fade" id="password" role="tabpanel">
                            <form method="POST" action="{{ route('usuario.actualizar.password') }}"
                                id="form-actualizar-password">
                                @csrf
                                <div class="mb-3">
                                    <label>Contraseña actual</label>
                                    <input type="password" name="password_actual" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Nueva contraseña</label>
                                    <input type="password" name="nueva_password" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Confirmar nueva contraseña</label>
                                    <input type="password" name="nueva_password_confirmation" class="form-control">
                                </div>
                                <button type="button" class="btn btn-primary"
                                    style="background-color: var(--ib-red);border:1px solid var(--ib-red);"
                                    data-bs-toggle="modal" data-bs-target="#modalConfirmarPassUsuario">
                                    Cambiar contraseña
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Modales fuera del tab-content -->
                    <!-- Modal Confirmar cambio de correo -->
                    <div class="modal fade" id="modalConfirmarDatosUsuario" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Confirmar cambio de correo</h5>
                                    <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Estás seguro de que quieres cambiar tu correo?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                        id="cancelarActualizarDatosUsuario">Cancelar</button>
                                    <button type="button" class="btn btn-primary"
                                        style="background-color: var(--ib-red);border:1px solid var(--ib-red);"
                                        onclick="document.getElementById('form-actualizar-datos').submit();">
                                        Sí, cambiar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Confirmar cambio de contraseña -->
                    <div class="modal fade" id="modalConfirmarPassUsuario" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Confirmar cambio de contraseña</h5>
                                    <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Estás seguro de que quieres cambiar tu contraseña?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                        id="cancelarActualizarPassUsuario">Cancelar</button>
                                    <button type="button" class="btn btn-primary"
                                        style="background-color: var(--ib-red);border:1px solid var(--ib-red);"
                                        onclick="document.getElementById('form-actualizar-password').submit();">
                                        Sí, cambiar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>



            @include('auth.layout.partials.footer')
        </main>
    </div>
@endsection