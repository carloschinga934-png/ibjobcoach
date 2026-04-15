@extends('auth.layout.dash_layout')

@section('title', 'Listado de Artículos')

@section('body')
<div class="ib-wrapper">
    @include('auth.layout.partials.sidebar')
    <main class="ib-main-panel">
        @include('auth.layout.partials.navbar')
        <section class="ib-content">
            <div class="ib-tecnicas-container">
                <div class="ib-tecnicas-card">
                    <div class="ib-tecnicas-header card-header-primary">
                        <h4 class="ib-tecnicas-title" style="color:white;">Listado de Artículos</h4>
                        <p class="ib-tecnicas-desc" style="color:white;">Todos los artículos registrados</p>
                    </div>
                    <div class="ib-tecnicas-body">
                        <div class="table-responsive">
                            <table class="ib-tecnicas-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Descripción</th>
                                        <th>Nombre</th>
                                        <th>Tipo</th>
                                        <th>Tamaño</th>
                                        <th>Fecha publicación</th>
                                        <th>ID Categoría</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($articulos as $item)
                                        <tr>
                                            <td>{{ $item->idarticulo }}</td>
                                            <td>{{ $item->descripcion }}</td>
                                            <td>{{ $item->nombre }}</td>
                                            <td>{{ $item->tipo }}</td>
                                            <td>{{ $item->tamanio }}</td>
                                            <td>{{ $item->fechapublicacion }}</td>
                                            <td>{{ $item->idcategoria }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="ib-paginacion">
                            {{-- Usa bootstrap-4 para la paginación --}}
                            {{ $articulos->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @include('auth.layout.partials.footer')
    </main>
</div>
@endsection
