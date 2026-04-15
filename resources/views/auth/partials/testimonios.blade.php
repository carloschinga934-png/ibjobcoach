@php
$testimonios = [
    ['nombre'=>'Marcelo Inchi','cargo'=>'Gerente',
     'foto'=>'img/testimonios/marcelo.jpg',
     'mensaje'=>'IBJobCoach me ayudó a redefinir mi perfil y encontrar un nuevo empleo en tiempo récord.'],
    ['nombre'=>'Paula Gómez','cargo'=>'Jefa de RR. HH.',
     'foto'=>'img/testimonios/paula.jpg',
     'mensaje'=>'La plataforma es intuitiva y las herramientas de coaching son excelentes.'],
    ['nombre'=>'Luis Ortega','cargo'=>'Analista Senior',
     'foto'=>'img/testimonios/luis.jpg',
     'mensaje'=>'Gracias a IBJobCoach logré actualizar mi CV y conseguir entrevistas rápidamente.'],
    ['nombre'=>'Verónica Pérez','cargo'=>'Consultora',
     'foto'=>'img/testimonios/veronica.jpg',
     'mensaje'=>'El acompañamiento personalizado marcó la diferencia en mi transición laboral.'],
    ['nombre'=>'Andrés Silva','cargo'=>'Project Manager',
     'foto'=>'img/testimonios/andres.jpg',
     'mensaje'=>'Me encantaron los recursos de video y las simulaciones de entrevista.'],
];
@endphp

<section class="bg-light py-1">
    <div class="testi-container">
        <h2 class="text-center fw-bold mb-5">
            ¡Ellos también usan <span class="text-danger">IBJobCoach</span>!
        </h2>

        <div id="testimoniosCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach (array_chunk($testimonios, 3) as $chunkIndex => $grupo)
                    <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                        <div class="d-flex justify-content-center">
                            @foreach ($grupo as $t)
                                <div class="testi-col">
                                    <div class="testi-card">
                                        <img src="{{ asset($t['foto']) }}" alt="{{ $t['nombre'] }}">
                                        <h5 class="testi-nombre">{{ $t['nombre'] }}</h5>
                                        <p class="testi-cargo">{{ $t['cargo'] }}</p>
                                        <p class="testi-mensaje">{{ $t['mensaje'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#testimoniosCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#testimoniosCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
    </div>
</section>
