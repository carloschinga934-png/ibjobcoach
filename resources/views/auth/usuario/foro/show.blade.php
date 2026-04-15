@extends('auth.layout.dash_layout')

@section('title', 'Detalle del hilo')

@section('body')
<div class="ib-wrapper">
  @include('auth.layout.partials.sidebar')
  <main class="ib-main-panel">
    @include('auth.layout.partials.navbar')

    <section class="ib-content">
      <div class="ib-tecnicas-container">
        <div class="ib-tecnicas-card">
          <div class="ib-tecnicas-header card-header-primary">
            @php
              $titulo = $foro->titulo ?? 'Hilo';
              $autor  = $foro->autor  ?? ($foro->creado_por ?? 'Anónimo');
              $fecha  = \Illuminate\Support\Carbon::parse($foro->created_at ?? now())->diffForHumans();
            @endphp
            <h4 class="ib-tecnicas-title" style="color:white;">{{ $titulo }}</h4>
            <p class="ib-tecnicas-desc" style="color:white;">Por {{ $autor }} · {{ $fecha }}</p>
          </div>

          <div class="ib-tecnicas-body">
            <div class="card mb-3">
              <div class="card-body">
                <div>{!! nl2br(e($foro->contenido ?? ($foro->mensaje ?? ''))) !!}</div>
              </div>
            </div>

            <h6 class="mb-3">Respuestas ({{ count($respuestas) }})</h6>

            @forelse($respuestas as $r)
              @php
                $autorR = $r->autor ?? ($r->usuario_nombre ?? 'Usuario');
                $fechaR = \Illuminate\Support\Carbon::parse($r->created_at ?? now())->diffForHumans();
              @endphp
              <div class="card mb-2">
                <div class="card-body">
                  <div class="text-muted mb-1" style="font-size:.85rem;">{{ $autorR }} · {{ $fechaR }}</div>
                  <div>{!! nl2br(e($r->mensaje ?? '')) !!}</div>
                </div>
              </div>
            @empty
              <div class="alert alert-light">Todavía no hay respuestas.</div>
            @endforelse

            {{-- Responder --}}
            @if (\Illuminate\Support\Facades\Route::has('usuario.foro.responder'))
              <div class="mt-4">
                <form method="POST" action="{{ route('usuario.foro.responder', $foro->idforo) }}">
                    @csrf
                    <input type="hidden" name="nombre" value="{{ Auth::user()->nombre ?? 'Usuario' }}">
                    <div class="mb-3">
                        <label class="form-label">Tu respuesta</label>
                        <textarea name="mensaje" class="form-control" rows="6" required></textarea>
                    </div>
                    <button class="btn btn-primary" type="submit">Responder</button>
                </form>

              </div>
            @endif

            <div class="mt-3">
              <a class="btn btn-light" href="{{ route('usuario.foro') }}">Volver al foro</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
</div>
@endsection
