@extends('shared.layout')

@section('title', 'Precios – IBJobCoach')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.1.1/css/intlTelInput.min.css" />
    <link rel="stylesheet" href="{{ asset('css/home/precios/tab.css') }}">
@endpush

@section('content')
    <header class="bg-light">
        <div class="container-lg d-flex flex-column flex-md-row align-items-center py-4">
            <img src="{{ asset('img/home/precios/fondo_precios.jpg') }}" class="img-fluid col-md-8 p-0" alt="Precios">
            <div class="col-md-4 text-center p-md-5">
                <h2 class="fw-bold">En <span style="color:#D70000">IBVIRTUAL</span><br>tenemos lo que necesitas</h2>
                <a href="#precios" class="btn btn-primary mt-3 text-uppercase " style="background-color:#D70000">¡Cotiza ya!</a>
            </div>
        </div>
    </header>

    <section id="precios" class="py-5">
        <ul class="nav nav-tabs justify-content-center" id="preciosTab" role="tablist">
            <li class="nav-item mx-5" role="presentation">
                <button class="nav-link active fs-4" id="licencias-tab" data-bs-toggle="tab" data-bs-target="#licencias" type="button" role="tab" aria-controls="licencias" aria-selected="true">
                    IBvirtual Licencias
                </button>
            </li>
            <li class="nav-item mx-5" role="presentation">
                <button class="nav-link fs-4" id="plus-tab" data-bs-toggle="tab" data-bs-target="#plus" type="button" role="tab" aria-controls="plus" aria-selected="false">
                    IBvirtual Plus
                </button>
            </li>
            <li class="nav-item mx-5" role="presentation">
                <button class="nav-link fs-4" id="webinars-tab" data-bs-toggle="tab" data-bs-target="#webinars" type="button" role="tab" aria-controls="webinars" aria-selected="false">
                    Webinars
                </button>
            </li>
        </ul>

        <div class="container tab-content mt-5">
            <!-- TAB DE LICENCIAS -->
            <div class="tab-pane fade show active" id="licencias" role="tabpanel" aria-labelledby="licencias-tab">
                <p class="text-center fs-4 fw-light my-4">
                    Indícanos tu posición y te ayudamos a definir cuánto tiempo contratar IBVirtual
                </p>
                <form id="form_cargos" class="row g-3 mb-3">
                    <div class="col-md-4">
                        <select name="cargos" id="cargos" class="form-select">
                            <option value="">Selecciona tu posición</option>
                            @foreach($positions as $position)
                                <option 
                                    data-meses="{{ $position->meses }}" 
                                    data-precio="{{ $position->precio }}">
                                    {{ $position->nombre }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" id="mescargoSelect1" class="form-control" placeholder="Número de meses" disabled>
                    </div>
                    <div class="col-md-4">
                        <input type="text" id="valorcargoSelect1" class="form-control" placeholder="Precio (Soles) / mes" disabled>
                    </div>
                </form>


                <p id="recomendacion" class="my-3 d-none">
                    A un <span class="nomcargo fw-bold"></span> le toma en promedio
                    <span class="nmes fw-bold"></span> meses encontrar trabajo con un programa de Outplacement…
                </p>
                <p class="text-center my-4">
                    Según estudios, lo que te demoras en conseguir la recolocación laboral está directamente relacionado con la pirámide laboral...
                </p>
                <form method="POST" action="{{ route('precios.checkout') }}" id="formComprar" autocomplete="off">
                    @csrf

                    {{-- STEP 1 --}}
                    <div id="step1" class="text-center mb-4">
                        <h4 class="fw-light mb-3">¡Ya sé cuántos meses quiero!</h4>
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            <select class="form-select form-select-lg border-warning" id="selectMeses" style="max-width: 180px; border-width: 3px;" name="meses" required>
                                <option value="">Selecciona...</option>
                                <option value="1">1 mes</option>
                                <option value="2">2 meses</option>
                                <option value="3">3 meses</option>
                                <option value="4">4 meses</option>
                                <option value="5">5 meses</option>
                                <option value="6">6 meses</option>
                                <option value="7">7 meses</option>
                                <option value="8">8 meses</option>
                            </select>
                            <input type="text" class="form-control form-control-lg border-warning text-center" style="max-width: 200px; border-width: 3px;"
                                id="precioMes" value="S/ 60.000 / mes" disabled>
                            <button type="button" class="btn btn-teal btn-lg px-5" id="btnSiguiente" disabled>
                                SIGUIENTE
                            </button>
                        </div>

                    </div>

                    {{-- STEP 2 (al inicio oculto) --}}
                    <div id="step2" class="row justify-content-center align-items-start g-5" style="display: none;">
                        <div class="col-md-6">
                            <div class="row g-3">
                                <div class="col-6">
                                    <input type="text" name="nombre" id="nombreInput"
                                        class="form-control form-control-lg" placeholder="Nombre" required>
                                </div>
                                <div class="col-6">
                                    <input type="text" name="apellido" id="apellidoInput"
                                        class="form-control form-control-lg" placeholder="Apellido" required>
                                </div>
                                <div class="col-6">
                                    <input type="email" name="correo" id="correoInput"
                                        class="form-control form-control-lg" placeholder="Correo" required>
                                </div>
                                <div class="col-6">
                                    <input type="password" name="clave" id="claveInput"
                                        class="form-control form-control-lg" placeholder="Crear una clave" required>
                                </div>
                                <div class="col-6">
                                    <input type="text" name="telefono" id="telefonoInput"
                                        class="form-control form-control-lg" placeholder="Teléfono" required>
                                </div>
                                <div class="col-6 position-relative">
                                    <input type="text" name="cupon" id="cuponInput"
                                        class="form-control form-control-lg" placeholder="Cupón de Descuento">
                                </div>
                                <div class="col-12 d-flex align-items-center gap-2 mt-1">
                                    <button type="button" class="btn btn-teal btn-lg" id="btnValidarCupon" style="display:none;">VALIDAR CUPÓN</button>
                                    <span id="errorCupon" class="text-danger small ms-2"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex flex-column align-items-center">
                            <div class="mb-3">
                                <strong class="fs-4">Seleccione una forma de pago</strong>
                            </div>
                            <div class="d-flex gap-4 mb-4 justify-content-center">
                                <input type="radio" class="btn-check" name="pago" id="pagoPayPal" value="paypal" autocomplete="off" checked>
                                <label class="d-flex flex-column align-items-center" for="pagoPayPal" style="cursor:pointer;">
                                    <img src="{{ asset('img/paypal-logo.jpg') }}" alt="PayPal" class="shadow rounded p-2" style="width:120px;">
                                    <span class="mt-2">PayPal</span>
                                </label>
                                <input type="radio" class="btn-check" name="pago" id="pagoTransfer" value="transfer" autocomplete="off">
                                <label class="d-flex flex-column align-items-center" for="pagoTransfer" style="cursor:pointer;">
                                    <img src="{{ asset('img/transferencia-bancaria.png') }}" alt="Transferencia" style="width:100px;">
                                    <span class="mt-2 text-muted" style="font-size: 0.97em;">Transferencia</span>
                                </label>
                            </div>
                            <div id="datos-transferencia" class="mb-3" style="display:none; width:100%;">
                                <div class="bg-light p-3 rounded" style="font-size: 0.98rem;">
                                    <strong>Para activar la licencia:</strong> Transfiera el valor del paquete comprado y envíe el comprobante al correo <b>cm.outplacement.coaching@corpibgroup.com</b>.<br>
                                    <b>Banco:</b> Scotiabank<br>
                                    <b>Cuenta Corriente N°:</b> 50402050100010547<br>
                                    <b>Nombre:</b> IBvirtual<br>
                                    <b>RUT:</b> 76.834.203-2<br>
                                    <small class="text-muted">La cuenta será activada en las próximas 24 horas.</small>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-teal btn-lg w-100 mt-4" id="btnComprar" style="max-width:200px;">COMPRAR</button>
                            <button type="button" class="btn btn-teal btn-lg w-100 mt-4" id="btnPaypal" style="max-width:200px; display:none;">PAGAR CON PAYPAL</button>
                        </div>
                    </div>
                </form>
            </div>
           <!-- TAB IBVIRTUAL PLUS -->
            <div class="tab-pane fade" id="plus" role="tabpanel" aria-labelledby="plus-tab">
                <div class="pt-3"></div>
                <h5 class="title-pagos">
                    Además de tener acceso a IBvirtual, asesórate con expertos a través de
                    <span class="text-secondary">sesiones individuales Expertos IBGroup.</span>
                    Así logras potenciar de mejor manera tu perfil laboral.
                </h5>
                <div class="container my-4">
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-body sesiones">
                                    <h5 class="card-title">2 SESIONES</h5>
                                    <p class="card-text">Sesiones Individuales con Consultores y Head Hunters IBGroup en empleabilidad</p>
                                    <button class="btn" data-bs-toggle="modal" data-bs-target="#modal2Plus">SABER MÁS</button>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-body sesiones">
                                    <h5 class="card-title">3 SESIONES</h5>
                                    <p class="card-text">Sesiones Individuales con Consultores y Head Hunters IBGroup en empleabilidad</p>
                                    <button class="btn" data-bs-toggle="modal" data-bs-target="#modal3Plus">SABER MÁS</button>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-body sesiones">
                                    <h5 class="card-title">5 SESIONES</h5>
                                    <p class="card-text">Sesiones Individuales con Consultores y Head Hunters IBGroup en empleabilidad</p>
                                    <button class="btn" data-bs-toggle="modal" data-bs-target="#modal5Plus">SABER MÁS</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Modales para Plus --}}
                @include('Home.Precios.modals.plus')
            </div>
            <!-- TAB WEBINARS -->
            <div class="tab-pane fade" id="webinars" role="tabpanel" aria-labelledby="webinars-tab">
                <div class="pt-3"></div>
                <h5 class="title-pagos">
                    Además de tener acceso a IBvirtual, también participa de
                    <span class="text-secondary">talleres online con Expertos IBGroup</span>
                    guiados por expertos en transición laboral.
                </h5>
                <div class="container my-4">
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-body webinar">
                                    <h5 class="card-title">2 WEBINAR</h5>
                                    <button class="btn" data-bs-toggle="modal" data-bs-target="#modal2Webinar">SABER MÁS</button>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-body webinar">
                                    <h5 class="card-title">3 WEBINAR</h5>
                                    <button class="btn" data-bs-toggle="modal" data-bs-target="#modal3Webinar">SABER MÁS</button>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-body webinar">
                                    <h5 class="card-title">5 WEBINAR</h5>
                                    <button class="btn" data-bs-toggle="modal" data-bs-target="#modal5Webinar">SABER MÁS</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Modales para Webinars --}}
                @include('Home.Precios.modals.webinars')
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.1.1/js/intlTelInput.min.js" defer></script>
    <script src="{{ asset('js/home/precios/precios.js') }}" defer></script>
@endpush

