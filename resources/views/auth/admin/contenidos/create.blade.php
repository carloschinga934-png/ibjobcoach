@extends('auth.layout.dash_layout')

@section('title', 'Registrar Contenido')

@section('body')
<div class="ib-wrapper">
    @include('auth.layout.partials.sidebar')
    <main class="ib-main-panel">
        @include('auth.layout.partials.navbar')

        <section class="ib-content">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card">
                        <div class="ib-tecnicas-header card-header-primary">
                            <h4 class="card-title">Registrar Contenido</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.contenidos.guardar') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" name="nombre" class="form-control" required value="{{ old('nombre') }}">
                                </div>

                                <div class="form-group">
                                    <label for="descripcion">Descripción (opcional)</label>
                                    <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="idcategoria">Categoría</label>
                                    <select name="idcategoria" class="form-control" required>
                                        <option value="">-- Selecciona --</option>
                                        @foreach($categorias as $cat)
                                            <option value="{{ $cat->idcategoria }}" {{ old('idcategoria') == $cat->idcategoria ? 'selected' : '' }}>
                                                {{ $cat->nombre ?? ('ID '.$cat->idcategoria) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="fechapublicacion">Fecha de publicación</label>
                                    <input type="date" name="fechapublicacion" class="form-control" required value="{{ old('fechapublicacion') }}">
                                </div>

                                <div class="form-group">
                                    <label for="archivo">Archivo (PDF)</label>
                                    <input type="file" name="archivo" class="form-control" required accept="application/pdf">
                                </div>

                                <button type="submit" class="btn btn-primary">Registrar</button>
                                <a href="{{ route('admin.contenidos') }}" class="btn btn-secondary">Cancelar</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @include('auth.layout.partials.footer')
    </main>
</div>
@endsection
