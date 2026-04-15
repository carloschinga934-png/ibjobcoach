@extends('auth.layout.dash_layout')

@section('title', 'Listado de Usuarios')

@section('body')
<div class="ib-wrapper">
    @include('auth.layout.partials.sidebar')
    <main class="ib-main-panel">
        @include('auth.layout.partials.navbar')
        <section class="ib-content">
            <div class="ib-tecnicas-container">
                <div class="ib-tecnicas-card">
                    <div class="ib-tecnicas-header card-header-primary">
                        <h4 class="ib-tecnicas-title" style="color:white;">Listado de Usuarios</h4>
                        <p class="ib-tecnicas-desc" style="color:white;">Todos los usuarios registrados</p>
                    </div>
                    <div class="ib-tecnicas-body">

                        {{-- Mensaje de éxito/error --}}
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        {{-- Búsqueda y filtro por rol --}}
                        <form method="GET" action="{{ route('admin.usuarios') }}" class="row mb-3">
                            <div class="col-md-4">
                                <input type="text" name="buscar" class="form-control" placeholder="Buscar usuario..." value="{{ request('buscar') }}">
                            </div>
                            <div class="col-md-4">
                                <select name="rol" class="form-control" onchange="this.form.submit()">
                                    <option value="">-- Filtrar por rol --</option>
                                    @foreach($roles as $rol)
                                        <option value="{{ $rol->nombre }}" {{ request('rol') == $rol->nombre ? 'selected' : '' }}>{{ ucfirst($rol->nombre) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Buscar</button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('admin.usuarios') }}" class="btn btn-secondary">Limpiar</a>
                            </div>
                        </form>
                        {{-- Tabla --}}
                        <div class="table-responsive">
                            <table class="ib-tecnicas-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>Rol</th>
                                        <th>Status</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($usuarios as $usuario)
                                        <tr>
                                            <td>{{ $usuario->idusuario }}</td>
                                            <td>{{ $usuario->nombre }} {{ $usuario->apellido }}</td>
                                            <td>{{ $usuario->correo }}</td>
                                            <td>
                                                <form method="POST" action="{{ route('admin.usuarios.actualizar', $usuario->idusuario) }}">
                                                    @csrf
                                                    <select name="role_id" onchange="this.form.submit()" class="form-select form-select-sm">
                                                        @foreach($roles as $rol)
                                                            <option value="{{ $rol->id }}" {{ $usuario->role_id == $rol->id ? 'selected' : '' }}>
                                                                {{ ucfirst($rol->nombre) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    {{-- Mantener los datos del usuario al actualizar solo rol --}}
                                                    <input type="hidden" name="nombre" value="{{ $usuario->nombre }}">
                                                    <input type="hidden" name="apellido" value="{{ $usuario->apellido }}">
                                                    <input type="hidden" name="correo" value="{{ $usuario->correo }}">
                                                    <input type="hidden" name="status" value="{{ $usuario->status }}">
                                                    <input type="hidden" name="fin_prueba" value="{{ $usuario->fin_prueba }}">
                                                    <input type="hidden" name="cargo" value="{{ $usuario->cargo }}">
                                                    <input type="hidden" name="pais" value="{{ $usuario->pais }}">
                                                    <input type="hidden" name="telefono" value="{{ $usuario->telefono }}">
                                                </form>
                                            </td>
                                            <td>{{ $usuario->status }}</td>
                                            <td>
                                                <a href="{{ route('admin.usuarios.editar', $usuario->idusuario) }}" class="btn btn-primary btn-sm">Editar</a>
                                                <form action="{{ route('admin.usuarios.eliminar', $usuario->idusuario) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="ib-paginacion">
                            {{ $usuarios->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @include('auth.layout.partials.footer')
    </main>
</div>
@endsection
