@extends('auth.layout.dash_layout')

@section('title', 'Nuevo hilo')

@section('body')
<div class="ib-wrapper">
  @include('auth.layout.partials.sidebar')
  <main class="ib-main-panel">
    @include('auth.layout.partials.navbar')

    <section class="ib-content">
      <div class="ib-tecnicas-container">
        <div class="ib-tecnicas-card">
          <div class="ib-tecnicas-header card-header-primary">
            <h4 class="ib-tecnicas-title" style="color:white;">Crear nuevo hilo</h4>
            <p class="ib-tecnicas-desc" style="color:white;">Comparte una duda o tema</p>
          </div>

          <div class="ib-tecnicas-body">
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form method="POST" action="{{ route('usuario.foro.store') }}">
              @csrf

              <div class="mb-3">
                <label class="form-label">Título</label>
                <input type="text" name="titulo" class="form-control" value="{{ old('titulo') }}" required maxlength="160">
              </div>

              <div class="mb-3">
                <label class="form-label">Contenido</label>
                <textarea name="mensaje" class="form-control" rows="8" placeholder="Describe tu tema o consulta..." required>{{ old('mensaje') }}</textarea>
              </div>

              <div class="d-flex gap-2">
                <button class="btn btn-primary" type="submit">Publicar</button>
                <a class="btn btn-light" href="{{ route('usuario.foro') }}">Cancelar</a>
              </div>
            </form>

            <div class="text-muted mt-3" style="font-size:.85rem;">
              *Este formulario envía al mismo controlador de guardado del foro (Admin), así aseguramos el mismo formato en DB.
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
</div>
@endsection
