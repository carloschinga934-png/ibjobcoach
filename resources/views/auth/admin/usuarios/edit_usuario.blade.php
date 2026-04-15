@include('auth.layout.dash_layout')

@section('title', 'Editar Usuario')

@section('body')
<div class="ib-wrapper">
    @include('auth.layout.partials.sidebar')
    <main class="ib-main-panel">
        @include('auth.layout.partials.navbar')
        <section class="ib-content">
            <div class="ib-tecnicas-container">
                <div class="ib-tecnicas-card">
                    <div class="ib-tecnicas-header card-header-primary">
                        <h4 class="ib-tecnicas-title" style="color:white;">Editar Usuario</h4>
                        <p class="ib-tecnicas-desc" style="color:white;">Modifica los datos y el rol del usuario</p>
                    </div>
                    <div class="ib-tecnicas-body">
                        <form method="POST" action="{{ route('admin.usuarios.actualizar', $usuario->idusuario) }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Nombre</label>
                                    <input type="text" name="nombre" class="form-control" value="{{ $usuario->nombre }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Apellido</label>
                                    <input type="text" name="apellido" class="form-control" value="{{ $usuario->apellido }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Correo</label>
                                    <input type="email" name="correo" class="form-control" value="{{ $usuario->correo }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Rol</label>
                                    <select name="role_id" class="form-control">
                                        @foreach($roles as $rol)
                                            <option value="{{ $rol->id }}" {{ $usuario->role_id == $rol->id ? 'selected' : '' }}>
                                                {{ $rol->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="prueba" {{ $usuario->status == 'prueba' ? 'selected' : '' }}>Prueba</option>
                                        <option value="activo" {{ $usuario->status == 'activo' ? 'selected' : '' }}>Activo</option>
                                        <option value="inactivo" {{ $usuario->status == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                        <option value="suspendido" {{ $usuario->status == 'suspendido' ? 'selected' : '' }}>Suspendido</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Fin Prueba</label>
                                    <input type="date" name="fin_prueba" class="form-control" value="{{ $usuario->fin_prueba }}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Actualizar</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        @include('auth.layout.partials.footer')
    </main>
</div>
@endsection
