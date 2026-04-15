@extends('auth.layout.dash_layout')

@section('title', 'Foro')

@section('body')
<div class="ib-wrapper">
  @include('auth.layout.partials.sidebar')
  <main class="ib-main-panel">
    @include('auth.layout.partials.navbar')

    <section class="ib-content">
      <div class="ib-tecnicas-container">
        <div class="ib-tecnicas-card">
          <div class="ib-tecnicas-header card-header-primary" style="display:flex;align-items:center;justify-content:space-between;">
            <div>
              <h4 class="ib-tecnicas-title" style="color:white;">Foro</h4>
              <p class="ib-tecnicas-desc" style="color:white;">Explora hilos y participa</p>
            </div>
            <a class="btn btn-light" href="{{ route('usuario.foro.create') }}">
              <i class="material-icons" style="vertical-align:middle;">add</i> Nuevo hilo
            </a>
          </div>

          <div class="ib-tecnicas-body">
            {{-- Buscador --}}
            <form method="GET" action="{{ route('usuario.foro') }}" class="mb-3" style="display:flex; gap:.5rem;">
              <input class="form-control" type="text" name="q" value="{{ $q }}" placeholder="Buscar por título o contenido...">
              <button class="btn btn-primary" type="submit">Buscar</button>
            </form>

            {{-- Lista --}}
            @forelse($foros as $f)
              @php
                // Campos defensivos: usa el que exista
                $idforo   = $f->idforo ?? $f->id ?? null;
                $titulo   = $f->titulo ?? 'Sin título';
                $contenido= $f->contenido ?? ($f->mensaje ?? '');
                $autor    = $f->autor ?? ($f->creado_por ?? 'Anónimo');
                $fecha    = \Illuminate\Support\Carbon::parse($f->created_at ?? now())->diffForHumans();
              @endphp

              <div class="card mb-2">
                <div class="card-body" style="display:flex; gap:1rem; align-items:flex-start;">
                  <i class="material-icons">forum</i>
                  <div style="flex:1;">
                    <a class="h6 d-block mb-1" href="{{ route('usuario.foro.show', $idforo) }}">{{ $titulo }}</a>
                    @if($contenido)
                      <div class="text-muted" style="font-size:.9rem;">
                        {{ \Illuminate\Support\Str::limit(strip_tags($contenido), 140) }}
                      </div>
                    @endif
                    <div class="text-muted" style="font-size:.8rem; margin-top:.4rem;">
                      Por {{ $autor }} · {{ $fecha }}
                    </div>
                  </div>
                </div>
              </div>
            @empty
              <div class="alert alert-info">Aún no hay hilos. ¡Crea el primero!</div>
            @endforelse

            <div class="mt-3">
              {{ $foros->links() }}
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
</div>
@endsection
