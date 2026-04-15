@extends('auth.layout.dash_layout')

@section('title', 'Gestión de Ebooks')

@section('body')
<div class="ib-wrapper">
  @include('auth.layout.partials.sidebar')

  <main class="ib-main-panel">
    @include('auth.layout.partials.navbar')

    <section class="ib-content">
      <div class="ib-tecnicas-container">
        <div class="ib-tecnicas-card">
          <div class="ib-tecnicas-header card-header-primary">
            <h4 class="ib-tecnicas-title" style="color:white;">Gestión de Ebooks</h4>
            <p class="ib-tecnicas-desc" style="color:white;">Lista de todos los ebooks registrados</p>
          </div>

          <div class="ib-tecnicas-body">
            @if(session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <a href="{{ route('admin.ebooks.crear') }}" class="btn btn-success mb-3">
              Registrar nuevo Ebook
            </a>

            <div class="table-responsive">
              <table class="ib-tecnicas-table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Fecha</th>
                    <th>Precio (S/.)</th>
                    <th>Archivo</th>
                    <th style="width:220px;">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($ebooks as $ebook)
                    <tr>
                      <td>{{ $loop->iteration + ($ebooks->currentPage() - 1) * $ebooks->perPage() }}</td>
                      <td>{{ $ebook->titulo }}</td>
                      <td>{{ $ebook->autor }}</td>
                      <td>{{ \Carbon\Carbon::parse($ebook->fecha)->format('d/m/Y') }}</td>
                      <td>{{ number_format($ebook->precio, 2) }}</td>
                      <td>
                        @if(!empty($ebook->archivo))
                          <a href="{{ route('admin.ebooks.ver', $ebook->idebook) }}" target="_blank" class="btn btn-sm btn-info">
                            Ver
                          </a>
                          <a href="{{ route('admin.ebooks.descargar', $ebook->idebook) }}" class="btn btn-sm btn-secondary">
                            Descargar
                          </a>
                        @else
                          <span class="text-muted">Sin archivo</span>
                        @endif
                      </td>
                      <td>
                        <a href="{{ route('admin.ebooks.editar', $ebook->idebook) }}" class="btn btn-sm btn-warning">Editar</a>

                        <form action="{{ route('admin.ebooks.eliminar', $ebook->idebook) }}"
                              method="POST" style="display:inline-block"
                              onsubmit="return confirm('¿Eliminar este ebook?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="7" class="text-center">No hay ebooks registrados.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <div class="ib-paginacion">
              {{ $ebooks->links('vendor.pagination.bootstrap-4') }}
            </div>
          </div>
        </div>
      </div>
    </section>

    @include('auth.layout.partials.footer')
  </main>
</div>
@endsection
