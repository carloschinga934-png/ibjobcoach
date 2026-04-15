@extends("shared.layout")

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/ebook/ver_ebook.css') }}">
@endpush

@section("content")
    <section class="pago_ebook_section">
        <div class="container py-5">

            <!-- Hero section -->
            <div class="hero">
                <h1>Descubre nuestros eBooks exclusivos</h1>
                <p>Accede a contenido de alto valor para potenciar tu desarrollo profesional y personal.</p>
                <button class="btn btn-hero" onclick="document.getElementById('fecha').focus()">Filtrar eBooks</button>
            </div>

            <!-- Filtros -->
            <form method="GET" action="{{ route('ver_ebook') }}" class="row justify-content-center mb-5">
                <div class="col-md-3 mb-3">
                    <label for="fecha" class="form-label fw-semibold">Mostrar desde:</label>
                    <input type="date" id="fecha" name="fecha" class="form-control" value="{{ $fechaFiltro ?? '' }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="precio_min" class="form-label fw-semibold">Precio mínimo:</label>
                    <input type="number" min="0" step="0.01" id="precio_min" name="precio_min" class="form-control"
                        value="{{ $precioMin ?? '' }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="precio_max" class="form-label fw-semibold">Precio máximo:</label>
                    <input type="number" min="0" step="0.01" id="precio_max" name="precio_max" class="form-control"
                        value="{{ $precioMax ?? '' }}">
                </div>
                <div class="col-auto d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Filtrar</button>
                    <a href="{{ route('ver_ebook') }}" class="btn btn-outline-secondary">Limpiar</a>
                </div>
            </form>

            <!-- Lista de eBooks -->
            <div class="row g-4">
                @forelse($ebooks as $ebook)
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="ebook-card h-100 shadow-sm" style="position: relative;">
                            <a href={{ asset("ver_detalle_ebook") }}>
                                <img src="{{ asset('img/ebook/pdf-icon.webp') }}" alt="PDF" />
                            </a>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-truncate" title="{{ $ebook['titulo'] }}">{{ $ebook['titulo'] }}</h5>
                                <p class="card-text mb-1">Precio: <b>S/ {{ number_format($ebook['precio'], 2) }}</b></p>
                                <p class="card-text mt-auto">Modificado:
                                    {{ \Carbon\Carbon::parse($ebook['fecha'])->format('d M Y') }}
                                </p>
                                <button type="button" class="btn btn-primary mt-3"
                                    onclick="addToCart({{ $ebook['id'] }}, '{{ addslashes($ebook['titulo']) }}', {{ $ebook['precio'] }})">
                                    Comprar
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center text-muted">No se encontraron eBooks para la fecha y filtro seleccionado.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    @push('scripts')
        <script src="https://js.stripe.com/v3/"></script>
    @endpush

@endsection