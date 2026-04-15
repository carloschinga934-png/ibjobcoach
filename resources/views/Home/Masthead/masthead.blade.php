<header class="masthead">
  <div class="row">
    <div id="carousel-landing" class="carousel slide" data-bs-ride="carousel">
      <ol class="carousel-indicators">
        <li data-bs-target="#carousel-landing" data-bs-slide-to="0" class="active"></li>
        <li data-bs-target="#carousel-landing" data-bs-slide-to="1"></li>
        <li data-bs-target="#carousel-landing" data-bs-slide-to="2"></li>
        <li data-bs-target="#carousel-landing" data-bs-slide-to="3"></li>
        <li data-bs-target="#carousel-landing" data-bs-slide-to="4"></li>
      </ol>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <div class="txt-slider text-left">SOMOS OUTPLACEMENT PARA TODOS. DIGITAL, 24/7, AUTOGESTIONADO
            <a class="btn-slider text-uppercase" href="{{ route('precios.index') }}">COMPRA AQUÍ</a>
          </div>
          <img src="{{ asset('img/home/masthead/slider1.jpg') }}" class="d-block w-100" alt="Slider Image">
        </div>
        <div class="carousel-item">
          <div class="txt-slider2 text-left">SI ERES OPERARIO O TÉCNICO, TE SUGERIMOS 1 MES
            <a href="{{ route('precios.index') }}" class="btn-slider2 text-uppercase">COMPRA AQUÍ</a>
          </div>
          <img src="{{ asset('img/home/masthead/slider2.jpg') }}" class="d-block w-100" alt="Slider Image">
        </div>
        <div class="carousel-item">
          <div class="txt-slider3 text-left">SI ERES ANALISTA O ESPECIALISTA, TE SUGERIMOS 2 MESES
            <a href="{{ route('precios.index') }}" class="btn-slider3 text-uppercase">COMPRA AQUÍ</a>
          </div>
          <img src="{{ asset('img/home/masthead/slider3.jpg') }}" class="d-block w-100" alt="Slider Image">
        </div>
        <div class="carousel-item">
          <div class="txt-slider4 text-left">SI ERES JEFE, TE SUGERIMOS 3 MESES
            <a href="{{ route('precios.index') }}" class="btn-slider4 text-uppercase">COMPRA AQUÍ</a>
          </div>
          <img src="{{ asset('img/home/masthead/slider4.jpg') }}" class="d-block w-100" alt="Slider Image">
        </div>
        <div class="carousel-item">
          <div class="txt-slider5 text-left">SI ERES GERENTE, TE SUGERIMOS 5 MESES
            <a href="{{ route('precios.index') }}" class="btn-slider5 text-uppercase">COMPRA AQUÍ</a>
          </div>
          <img src="{{ asset('img/home/masthead/slider5.jpg') }}" class="d-block w-100" alt="Slider Image">
        </div>
      </div>

      <!-- Controles de navegación -->
      <a class="carousel-control-prev" href="#carousel-landing" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carousel-landing" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </a>
    </div>
  </div>
</header>