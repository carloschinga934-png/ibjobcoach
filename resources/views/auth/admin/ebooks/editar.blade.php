@extends('auth.layout.dash_layout')

@section('title', 'Editar Ebook')

@section('body')
<div class="ib-wrapper">
  @include('auth.layout.partials.sidebar')

  <main class="ib-main-panel">
    @include('auth.layout.partials.navbar')

    <section class="ib-content">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header card-header-warning">
              <h4 class="mb-0" style="color:white;">Editar Ebook</h4>
            </div>
            <div class="card-body">
              <form action="{{ route('admin.ebooks.actualizar', $ebook->idebook) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                @method('PUT')

                <div class="form-group">
                  <label>Título</label>
                  <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $ebook->titulo) }}" required>
                  @error('titulo') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>Autor</label>
                    <input type="text" name="autor" class="form-control" value="{{ old('autor', $ebook->autor) }}" required>
                    @error('autor') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>
                  <div class="form-group col-md-3">
                    <label>Fecha</label>
                    <input type="date" name="fecha" class="form-control" value="{{ old('fecha', \Carbon\Carbon::parse($ebook->fecha)->toDateString()) }}" required>
                    @error('fecha') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>
                  <div class="form-group col-md-3">
                    <label>Precio (S/.)</label>
                    <input type="number" name="precio" class="form-control" min="0" step="0.01" value="{{ old('precio', $ebook->precio) }}" required>
                    @error('precio') <small class="text-danger">{{ $message }}</small> @enderror
                  </div>
                </div>

                <div class="form-group">
                  <label>Archivo PDF (opcional)</label>
                  <input type="file" name="archivo" class="form-control" accept="application/pdf">
                  @error('archivo') <small class="text-danger">{{ $message }}</small> @enderror

                  @if(!empty($ebook->archivo))
                    <div class="mt-2">
                      <a href="{{ route('admin.ebooks.ver', $ebook->idebook) }}" target="_blank" class="btn btn-sm btn-info">Ver archivo actual</a>
                      <a href="{{ route('admin.ebooks.descargar', $ebook->idebook) }}" class="btn btn-sm btn-secondary">Descargar</a>
                    </div>
                  @endif
                </div>

                <div class="d-flex justify-content-between">
                  <a href="{{ route('admin.ebooks') }}" class="btn btn-secondary">Volver</a>
                  <button type="submit" class="btn btn-warning">Actualizar</button>
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
              <h4 class="card-title">Consejo</h4>
              <p class="card-description">
                Si no subes un nuevo PDF, se mantendrá el archivo actual (privado). Tamaño máx. 5MB.
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
