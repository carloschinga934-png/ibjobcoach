@extends('auth.layout.dash_layout')

@section('title', 'Crear tema')

@section('body')
<div class="ib-wrapper">
  @include('auth.layout.partials.sidebar')

  <main class="ib-main-panel">
    @include('auth.layout.partials.navbar')

    <section class="ib-content">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="mb-0" style="color:white;">Nuevo tema de foro</h4>
            </div>
            <div class="card-body">
              <form action="{{ route('admin.foro.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="form-group">
                  <label>Título</label>
                  <input type="text" name="titulo" class="form-control" value="{{ old('titulo') }}" required>
                  @error('titulo') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>Autor</label>
                    <input type="text" name="autor" class="form-control" value="{{ old('autor', auth()->user()->nombre ?? '') }}" required>
                    @error('autor') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label>Imagen (opcional)</label>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                    @error('foto') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>
                </div>
                <div class="form-group">
                  <label>Descripción</label>
                  <textarea name="descripcion" rows="6" class="form-control" required>{{ old('descripcion') }}</textarea>
                  @error('descripcion') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="d-flex justify-content-between">
                  <a href="{{ route('admin.foro') }}" class="btn btn-light">Volver</a>
                  <button class="btn btn-primary">Publicar</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card card-profile">
            <div class="card-body">
              <h5 class="card-title">Consejo</h5>
              <p class="card-text">Recuerda fijar (pin) los temas importantes y cerrar los resueltos para mantener el foro ordenado.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    @include('auth.layout.partials.footer')
  </main>
</div>
@endsection
