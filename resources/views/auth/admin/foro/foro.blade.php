@extends('auth.layout.dash_layout')

@section('title', 'Gestión de Foros')

@section('body')
<div class="ib-wrapper">
  @include('auth.layout.partials.sidebar')

  <main class="ib-main-panel">
    @include('auth.layout.partials.navbar')

    <section class="ib-content">
      <div class="ib-tecnicas-container">
        <div class="ib-tecnicas-card">
          <div class="ib-tecnicas-header card-header-primary">
            <h4 class="ib-tecnicas-title" style="color:white;">Gestión de Foros</h4>
            <p class="ib-tecnicas-desc" style="color:white;">Listado de temas publicados por los usuarios</p>
          </div>

          <div class="ib-tecnicas-body">
            @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
            @if(session('error'))   <div class="alert alert-danger">{{ session('error') }}</div> @endif

            <div class="mb-3 d-flex align-items-center">
              <form class="form-inline mr-2" method="GET" action="{{ route('admin.foro') }}">
                <input name="q" value="{{ request('q') }}" class="form-control mr-2" placeholder="Buscar por título o autor">
                <select name="estado" class="form-control mr-2">
                  <option value="">— Estado —</option>
                  <option value="Enabled"   @selected(request('estado')==='Enabled')>Enabled</option>
                  <option value="Disabled"  @selected(request('estado')==='Disabled')>Disabled</option>
                </select>
                <select name="pinned" class="form-control mr-2">
                  <option value="">— Fijado —</option>
                  <option value="1" @selected(request('pinned')==='1')>Sí</option>
                  <option value="0" @selected(request('pinned')==='0')>No</option>
                </select>
                <select name="closed" class="form-control mr-2">
                  <option value="">— Cerrado —</option>
                  <option value="1" @selected(request('closed')==='1')>Sí</option>
                  <option value="0" @selected(request('closed')==='0')>No</option>
                </select>
                <button class="btn btn-primary">Filtrar</button>
                <a href="{{ route('admin.foro') }}" class="btn btn-light ml-2">Limpiar</a>
              </form>

              <a href="{{ route('admin.foro.create') }}" class="btn btn-success ml-auto">Crear tema</a>
            </div>

            {{-- Métricas rápidas --}}
            <div class="row mb-3">
              <div class="col-md-3"><div class="alert alert-secondary py-2">Total: <b>{{ $metrics['total'] ?? $foros->total() }}</b></div></div>
              <div class="col-md-3"><div class="alert alert-info py-2">Activos: <b>{{ $metrics['activos'] ?? 0 }}</b></div></div>
              <div class="col-md-3"><div class="alert alert-warning py-2">Fijados: <b>{{ $metrics['pinned'] ?? 0 }}</b></div></div>
              <div class="col-md-3"><div class="alert alert-dark py-2">Cerrados: <b>{{ $metrics['closed'] ?? 0 }}</b></div></div>
            </div>

            <div class="table-responsive">
              <table class="ib-tecnicas-table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Estado</th>
                    <th>Fijado</th>
                    <th>Cerrado</th>
                    <th>Respuestas</th>
                    <th>Vistas</th>
                    <th>Últ. actividad</th>
                    <th style="width:210px;">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($foros as $foro)
                    <tr>
                      <td>{{ $loop->iteration + ($foros->currentPage()-1)*$foros->perPage() }}</td>
                      <td>
                        <a href="{{ route('admin.foro.show', $foro->idforo) }}">
                          {{ $foro->titulo }}
                        </a>
                      </td>
                      <td>{{ $foro->autor }}</td>
                      <td><span class="badge badge-{{ $foro->estado === 'Enabled' ? 'success' : 'secondary' }}">{{ $foro->estado }}</span></td>
                      <td>{!! $foro->pinned ? '<span class="badge badge-warning">Sí</span>' : '—' !!}</td>
                      <td>{!! $foro->closed ? '<span class="badge badge-dark">Sí</span>' : '—' !!}</td>
                      <td>{{ $foro->num_respuestas ?? ($foro->respuestas_count ?? 0) }}</td>
                      <td>{{ $foro->vistas }}</td>
                      <td>{{ optional($foro->last_activity_at)->format('d/m/Y H:i') ?? '—' }}</td>
                      <td>
                        <a class="btn btn-sm btn-primary" href="{{ route('admin.foro.show', $foro->idforo) }}">Ver</a>

                        {{-- Fijar/Desfijar --}}
                        <form action="{{ route('admin.foro.togglePin', $foro->idforo) }}" method="POST" style="display:inline-block">
                          @csrf
                          <button class="btn btn-sm btn-warning" type="submit">{{ $foro->pinned ? 'Desfijar' : 'Fijar' }}</button>
                        </form>

                        {{-- Cerrar/Abrir --}}
                        <form action="{{ route('admin.foro.toggleClose', $foro->idforo) }}" method="POST" style="display:inline-block">
                          @csrf
                          <button class="btn btn-sm btn-secondary" type="submit">{{ $foro->closed ? 'Abrir' : 'Cerrar' }}</button>
                        </form>

                        {{-- Eliminar tema --}}
                        <form action="{{ route('admin.foro.destroy', $foro->idforo) }}" method="POST" style="display:inline-block" onsubmit="return confirm('¿Eliminar este tema?');">
                          @csrf @method('DELETE')
                          <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                        </form>
                      </td>
                    </tr>
                  @empty
                    <tr><td colspan="10" class="text-center">No hay temas.</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <div class="ib-paginacion">
              {{ $foros->links('vendor.pagination.bootstrap-4') }}
            </div>
          </div>
        </div>
      </div>
    </section>

    @include('auth.layout.partials.footer')
  </main>
</div>
@endsection
