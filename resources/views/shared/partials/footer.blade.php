<footer class="footer wow fadeInUp pt-5 pb-4" id="contacto">
    <div class="container">
        <div class="row g-4">
            {{-- ========= GRUPO IBcorp ========= --}}
            <div class="col-12 col-md-3 text-center text-md-start">
                <h5 class="footer-title">SOMOS PARTE DEL GRUPO IBcorp</h5>
                <a href="https://iboutplacement.com" target="_blank" rel="noopener noreferrer">
                    <img src="{{ asset('img/home/beneficios/logo_iboutplacement_good.png') }}" alt="Logo IBOutplacement"
                        class="img-fluid mt-2" loading="lazy" style="max-height: 60px;">
                </a>
            </div>

            {{-- ========= PRESENCIA ========= --}}
            <div class="col-12 col-md-3">
                <h5 class="footer-title">PRESENCIA</h5>
                <div class="d-flex flex-wrap gap-2 mt-2">
                    @php
                        $flags = ['chile', 'peru', 'colombia', 'panama', 'bolivia', 'argentina', 'espana', 'mexico', 'uruguay'];
                    @endphp
                    @foreach($flags as $flag)
                        <img class="flag-footer" src="{{ asset("img/home/nav/banderas/{$flag}.png") }}"
                            alt="{{ ucfirst($flag) }}" width="32" loading="lazy">
                    @endforeach
                </div>
            </div>

            {{-- ========= APOYADOS POR ========= --}}
            <div class="col-12 col-md-3 text-center text-md-start">
                <h5 class="footer-title">APOYADOS POR</h5>
                <img src="{{ asset('img/home/footer/partners/logoibcorp.png') }}" alt="IBCorp" class="img-fluid mt-2"
                    style="max-width: 120px;" loading="lazy">
            </div>

            {{-- ========= MAPA DEL SITIO ========= --}}
            <div class="col-12 col-md-3">
                <h5 class="footer-title">MAPA DEL SITIO</h5>
                <ul class="list-unstyled mt-2">
                    <li><i class="fas fa-house me-2 text-white-50"></i><a href="{{ url('/') }}"
                            class="footer-link">Inicio</a></li>
                    <li><i class="fas fa-book me-2 text-white-50"></i><a href="{{ route('ebook') }}"
                            class="footer-link">eBooks</a></li>
                    <li><i class="fas fa-file-contract me-2 text-white-50"></i><a href="{{ route('terminos') }}"
                            class="footer-link">Términos y Condiciones</a></li>
                </ul>
            </div>
        </div>

        {{-- ========= REDES SOCIALES ========= --}}
        <div class="row mt-4">
            <div class="col text-center">
                <a href="https://www.facebook.com/iboutplacement" target="_blank" class="social-icon me-2"
                    aria-label="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://www.linkedin.com/company/iboutplacement" target="_blank" class="social-icon me-2"
                    aria-label="LinkedIn">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a href="https://www.instagram.com/iboutplacement" target="_blank" class="social-icon"
                    aria-label="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
        </div>

        {{-- ========= INFORMACIÓN DIRECCIÓN ========= --}}
        <p class="text-center mt-4 small">
            IBOutplacement:
            <a href="https://www.google.com/maps/place/Av.+Circunvalaci%C3%B3n+Golf+Los+Incas+208,+Santiago+de+Surco+15023,+Per%C3%BA"
                target="_blank" rel="noopener noreferrer" style="color: #ffffff; text-decoration: underline;">
                Av. Circunvalación Golf Los Incas Nro. 208, Torre 3, Oficina 602B, Santiago de Surco
            </a>
            &vert; Central: (511) 748-5112
        </p>


        {{-- POP-UP --}}
        @if(Route::currentRouteName() != 'info_ebook' && Route::currentRouteName() != 'ver_ebook' && Route::currentRouteName() != 'verificar_voucher_ebook')
                <div class="footer-alert wow fadeInUp" data-wow-duration="3s">
                    <div class="alert alert-success" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>

                        <ul class="footer-alert-box">
                            <li class="footer-alert-title">¿Te interesa encontrar un nuevo trabajo?</li>
                            <li class="footer-alert-text">
                                Descubre cómo hacerlo a través de nuestro eBook:<br>
                                Guía rápida y económica para encontrar el trabajo ideal.
                            </li>
                            <li class="footer-alert-button">
                                <a href="{{ route('info_ebook') }}" rel="noopener noreferrer"
                                    class="btn btn-sm btn-download w-100">
                                    Descarga gratis
                                </a>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        @endif

    {{-- FONT AWESOME --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</footer>