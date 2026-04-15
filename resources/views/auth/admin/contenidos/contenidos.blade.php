@extends('auth.layout.dash_layout')

@section('title', 'Gestión de Contenidos')

@section('body')
<div class="ib-wrapper">
    @include('auth.layout.partials.sidebar')
    <main class="ib-main-panel">
        @include('auth.layout.partials.navbar')
        <section class="ib-content">
            <div class="ib-tecnicas-container">
                <div class="ib-tecnicas-card">
                    <div class="ib-tecnicas-header card-header-primary">
                        <h4 class="ib-tecnicas-title" style="color:white;">Gestión de Contenidos</h4>
                        <p class="ib-tecnicas-desc" style="color:white;">Todos los contenidos registrados</p>
                    </div>

                    <div class="ib-tecnicas-body">
                        <a href="{{ route('admin.contenidos.crear') }}" class="btn btn-success mb-3">
                            Registrar Nuevo Contenido
                        </a>

                        <div class="table-responsive">
                            <table class="ib-tecnicas-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Fecha publicación</th>
                                        <th>Categoría</th>
                                        <th>Archivo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($contenidos as $contenido)
                                        <tr>
                                            <td>{{ $contenido->idcontenido }}</td>
                                            <td>{{ $contenido->nombre }}</td>
                                            <td>{{ $contenido->fechapublicacion ?: '—' }}</td>
                                            <td>{{ optional($contenido->categoria)->nombre ?: '—' }}</td>
                                            <td>
                                                @if(!empty($contenido->url))
                                                    <a href="{{ Storage::url($contenido->url) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        Ver PDF
                                                    </a>
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.contenidos.editar', $contenido->idcontenido) }}" class="btn btn-sm btn-warning">
                                                    Editar
                                                </a>

                                                <form action="{{ route('admin.contenidos.eliminar', $contenido->idcontenido) }}"
                                                      method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('¿Eliminar este contenido?');">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No hay contenidos registrados.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="ib-paginacion">
                            {{ $contenidos->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @include('auth.layout.partials.footer')
    </main>
</div>
@endsection
