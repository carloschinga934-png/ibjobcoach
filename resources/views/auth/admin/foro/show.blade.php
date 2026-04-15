@extends('auth.layout.dash_layout')

@section('title', 'Tema del foro')

@section('body')
<div class="ib-wrapper">
  @include('auth.layout.partials.sidebar')

  <main class="ib-main-panel">
    @include('auth.layout.partials.navbar')

    <section class="ib-content">
      @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
      @if(session('error'))   <div class="alert alert-danger">{{ session('error') }}</div> @endif

      <div class="row">
        <div class="col-lg-8">
          <div class="card mb-3">
            <div class="card-header d-flex align-items-center justify-content-between">
              <div>
                <h4 class="mb-1">{{ $foro->titulo }}</h4>
                <small class="text-muted">
                  Por <b>{{ $foro->autor }}</b> • {{ optional($foro->fecha)->format('d/m/Y H:i') ?? $foro->created_at->format('d/m/Y H:i') }}
                  • Vistas: {{ $foro->vistas }}
                </small>
              </div>
              <div>
                <span class="badge badge-{{ $foro->estado === 'Enabled' ? 'success' : 'secondary' }}">{{ $foro->estado }}</span>
                @if($foro->pinned) <span class="badge badge-warning">Fijado</span> @endif
                @if($foro->closed) <span class="badge badge-dark">Cerrado</span> @endif
              </div>
            </div>
            <div class="card-body">
              @if($foro->foto)
                <img src="{{ asset('storage/'.$foro->foto) }}" alt="imagen" class="img-fluid">

              @endif
              <p style="white-space:pre-line">{{ $foro->descripcion }}</p>

              <div class="mt-3">
                {{-- Acciones admin --}}
                <form action="{{ route('admin.foro.togglePin', $foro->idforo) }}" method="POST" class="d-inline">
                  @csrf
                  <button class="btn btn-sm btn-warning">{{ $foro->pinned ? 'Desfijar' : 'Fijar' }}</button>
                </form>
                <form action="{{ route('admin.foro.toggleClose', $foro->idforo) }}" method="POST" class="d-inline">
                  @csrf
                  <button class="btn btn-sm btn-secondary">{{ $foro->closed ? 'Abrir' : 'Cerrar' }}</button>
                </form>
                <form action="{{ route('admin.foro.destroy', $foro->idforo) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar tema completo?');">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger">Eliminar</button>
                </form>
                <a href="{{ route('admin.foro') }}" class="btn btn-sm btn-light">Volver</a>
              </div>
            </div>
          </div>

          {{-- Respuestas --}}
          <div class="card">
            <div class="card-header">
              <b>Respuestas</b> ({{ $foro->respuestas_count ?? $foro->respuestas->count() }})
            </div>
            <div class="card-body">
              @forelse($foro->respuestas as $r)
                <div class="mb-3 pb-3 border-bottom">
                  <div class="d-flex justify-content-between">
                    <div>
                      <b>{{ $r->nombre ?? ('Usuario #'.$r->usuario_id) }}</b>
                      @if($r->es_admin)
                        <span class="badge badge-primary">Admin</span>
                      @endif
                      <small class="text-muted">• {{ $r->created_at->format('d/m/Y H:i') }}</small>
                    </div>
                    <form action="{{ route('admin.foro.respuestas.destroy', [$foro->idforo, $r->idrespuestaforo]) }}"
                          method="POST" onsubmit="return confirm('¿Eliminar respuesta?');">
                      @csrf @method('DELETE')
                      <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                    </form>
                  </div>
                  <div class="mt-2" style="white-space:pre-line">{{ $r->mensaje }}</div>
                </div>
              @empty
                <p class="text-muted mb-0">Aún no hay respuestas.</p>
              @endforelse
            </div>
          </div>
        </div>

        {{-- Responder como admin --}}
        <div class="col-lg-4">
          <div class="card">
            <div class="card-header card-header-primary">
              <h5 class="mb-0" style="color:white;">Responder</h5>
            </div>
            <div class="card-body">
              @if($foro->closed)
                <div class="alert alert-warning">El tema está cerrado. Ábrelo para responder.</div>
              @else
                <form action="{{ route('admin.foro.responder', $foro->idforo) }}" method="POST" autocomplete="off">
                  @csrf
                  <input type="hidden" name="es_admin" value="1">
                  <div class="form-group">
                    <label>Tu nombre (se mostrará)</label>
                    <input type="text" name="nombre" value="{{ auth()->user()->nombre ?? 'Administrador' }}" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label>Mensaje</label>
                    <textarea name="mensaje" rows="5" class="form-control" required>{{ old('mensaje') }}</textarea>
                    @error('mensaje') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>
                  <button class="btn btn-primary btn-block">Publicar respuesta</button>
                </form>
              @endif
            </div>
          </div>
        </div>
      </div>
    </section>

    @include('auth.layout.partials.footer')
  </main>
</div>
@endsection
