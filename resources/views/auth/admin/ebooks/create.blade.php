@extends('auth.layout.dash_layout')

@section('title', 'Registrar Ebook')

@section('body')
<div class="ib-wrapper">
  @include('auth.layout.partials.sidebar')

  <main class="ib-main-panel">
    @include('auth.layout.partials.navbar')

    <section class="ib-content">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="mb-0" style="color:white;">Registrar Ebook</h4>
            </div>
            <div class="card-body">
              <form action="{{ route('admin.ebooks.guardar') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf

                <div class="form-group">
                  <label>Título</label>
                  <input type="text" name="titulo" class="form-control" value="{{ old('titulo') }}" required>
                  @error('titulo') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>Autor</label>
                    <input type="text" name="autor" class="form-control" value="{{ old('autor') }}" required>
                    @error('autor') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>
                  <div class="form-group col-md-3">
                    <label>Fecha</label>
                    <input type="date" name="fecha" class="form-control" value="{{ old('fecha', now()->toDateString()) }}" required>
                    @error('fecha') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>
                  <div class="form-group col-md-3">
                    <label>Precio (S/.)</label>
                    <input type="number" name="precio" class="form-control" min="0" step="0.01" value="{{ old('precio', 0) }}" required>
                    @error('precio') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>
                </div>

                <div class="form-group">
                  <label>Archivo PDF</label>
                  <input type="file" name="archivo" class="form-control" accept="application/pdf" required>
                  @error('archivo') <small class="text-danger">{{ $message }}</small> @enderror
                  <small class="form-text text-muted">Se almacenará de forma privada (no público).</small>
                </div>

                <div class="d-flex justify-content-between">
                  <a href="{{ route('admin.ebooks') }}" class="btn btn-secondary">Volver</a>
                  <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card card-profile">
            <div class="card-avatar">
              <img class="img" src="{{ asset('img/auth/dashboard/faces/pdf.png') }}" alt="PDF">
            </div>
            <div class="card-body">
              <h6 class="card-category text-gray">Módulo de Ebooks</h6>
              <h4 class="card-title">Información</h4>
              <p class="card-description">
                Los PDFs se guardan en <code>storage/app/private/ebooks</code> y se sirven vía controlador (rutas <em>ver</em>/<em>descargar</em>).
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    @include('auth.layout.partials.footer')
  </main>
</div>
@endsection
