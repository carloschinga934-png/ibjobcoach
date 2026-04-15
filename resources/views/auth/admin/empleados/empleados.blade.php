@extends('auth.layout.dash_layout')

@section('title', 'Gestión de Empleados')

@section('body')
<div class="ib-wrapper">
    @include('auth.layout.partials.sidebar')
    <main class="ib-main-panel">
        @include('auth.layout.partials.navbar')
        <section class="ib-content">
            <div class="ib-tecnicas-container">
                <div class="ib-tecnicas-card">
                    <div class="ib-tecnicas-header card-header-primary">
                        <h4 class="ib-tecnicas-title" style="color:white;">Gestión de Empleados</h4>
                        <p class="ib-tecnicas-desc" style="color:white;">Todos los empleados registrados</p>
                    </div>
                    <div class="ib-tecnicas-body">
                        <a href="{{ route('admin.empleados.crear') }}" class="btn btn-success mb-3">Registrar Nuevo Empleado</a>
                        <div class="table-responsive">
                            <table class="ib-tecnicas-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>Status</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($empleados as $empleado)
                                        <tr>
                                            <td>{{ $empleado->idempleado }}</td>
                                            <td>{{ $empleado->nombre }} {{ $empleado->apellido }}</td>
                                            <td>{{ $empleado->correo }}</td>
                                            <td>
                                                <span class="badge badge-{{ $empleado->status == 'activo' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($empleado->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.empleados.editar', $empleado->idusuario) }}">Editar</a>

                                                <form action="{{ route('admin.empleados.eliminar', $empleado->idusuario) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                                </form>

                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No hay empleados registrados.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="ib-paginacion">
                            {{ $empleados->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @include('auth.layout.partials.footer')
    </main>
</div>
@endsection
