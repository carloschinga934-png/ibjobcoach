<nav id="mainNav" class="navbar navbar-expand-lg shadow-sm">
    <div class="container">
        {{-- Logo --}}
        <a class="navbar-brand js-scroll-trigger" href="{{ url('/') }}">
            <img src="{{ asset('img/home/nav/ibjobcoach.jpg') }}" style="height:30px" alt="IBJobCoach">
        </a>

        {{-- Botón hamburguesa --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
            aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa-solid fa-bars fa-2xl" style="color: #000000;"></i>
        </button>

        {{-- Ítems --}}
        <div id="navbarResponsive" class="collapse navbar-collapse bg-white" style="z-index: 999;">
            <ul class="navbar-nav text-uppercase ms-auto text-center">
                <!-- Dropdown IBJOBCOACH -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="ibDropdown" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        ¿QUÉ ES IBJOBCOACH?
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="ibDropdown">
                        <li><a class="dropdown-item" href="{{ route('home') }}#nosotros">NOSOTROS</a></li>
                        <li><a class="dropdown-item" href="{{ route('home') }}#beneficios">BENEFICIOS</a></li>
                        <li><a class="dropdown-item" href="{{ route('precios.index') }}">PRECIOS</a></li>
                        <li><a class="dropdown-item" href="{{ route('home') }}#prueba">CONOCER MÁS</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="modal" data-bs-target="#modalContactoEmpresa"
                        href="#">EMPRESAS</a>
                </li>

                <!-- Dropdown E-BOOK -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="ebookDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">E-BOOK</a>
                    <ul class="dropdown-menu" aria-labelledby="ebookDropdown">
                        <li><a class="dropdown-item" href="{{ route('info_ebook') }}">Información</a></li>
                        <li><a class="dropdown-item" href="{{ route('ver_ebook') }}">Ver Ebooks</a></li>
                        <li><a class="dropdown-item" href="{{ route('verificar_voucher_ebook') }}">Verificar voucher</a>
                        </li>
                    </ul>
                </li>

                <!-- Dropdown Usuarios (solo si el usuario es empleado) -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="usersDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Usuarios</a>
                    <ul class="dropdown-menu" aria-labelledby="usersDropdown">
                        @if(auth()->check() && auth()->user()->tieneRol('empleado')) <!-- Verifica que el usuario esté autenticado y tenga el rol de 'empleado' -->
                            <li><a class="dropdown-item" href="{{ route('users.index') }}">Ver Usuarios</a></li>
                        @endif
                    </ul>
                </li>

                <!-- Dropdown Tickets (solo si el usuario es empleado) -->
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="ticketsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Tickets</a>
    <ul class="dropdown-menu" aria-labelledby="ticketsDropdown">
        @if(auth()->check() && auth()->user()->tieneRol('empleado')) <!-- Verifica que el usuario esté autenticado y tenga el rol de 'empleado' -->
            <li><a class="dropdown-item" href="{{ route('tickets.dashboard') }}">Dashboard de Tickets</a></li>
            <li><a class="dropdown-item" href="{{ route('tickets.general') }}">Ver Todos los Tickets</a></li>
            <li><a class="dropdown-item" href="{{ route('tickets.create', auth()->user()->idusuario) }}">Crear Nuevo Ticket</a></li>
            <li><a class="dropdown-item" href="{{ route('tickets.historial', auth()->user()->idusuario) }}">Historial de Tickets</a></li> <!-- Opción para el historial de tickets -->
            <li><a class="dropdown-item" href="{{ route('tickets.kanban') }}">Vista Kanban</a></li> <!-- Opción para la vista Kanban -->
            <li><a class="dropdown-item" href="{{ route('tickets.reportes', auth()->user()->idusuario) }}">Reportes de Tickets</a></li>
        @endif
    </ul>
</li>



                <li class="li-carrito-compras" onclick="openCartModal();">
                    <div>
                        <div class="nro_notificacion">0</div>
                        <i class="fa-solid fa-cart-shopping fa-lg" style="color: #000000;"></i>
                    </div>
                </li>

                {{-- Login / Cuenta --}}
                <li class="nav-item">
                    @guest
                        <a class="btn-login nav-link" href="{{ route('login') }}">
                        LOGIN <i class="fa-solid fa-right-to-bracket"></i>
                        </a>
                    @else
                    @php
                        $user = Auth::user();

                        // Default seguro
                        $dashRoute = 'home';

                        if ($user && method_exists($user, 'tieneRol')) {
                            if ($user->tieneRol('admin')) {
                                $dashRoute = 'admin.dashboard';
                            } elseif ($user->tieneRol('empleado')) {
                                $dashRoute = 'empleado.dashboard';
                            } elseif ($user->tieneRol('usuario')) {
                                $dashRoute = 'usuario.dashboard';
                            }
                        }

                        // Fallback defensivo si el nombre de ruta no existe
                        if (!\Illuminate\Support\Facades\Route::has($dashRoute)) {
                            $dashRoute = 'home';
                        }
                    @endphp




                        <div class="dropdown">
                        <a class="btn-login nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false" id="accountDropdown">
                            {{ Auth::user()->nombre ?? Auth::user()->name ?? 'Mi cuenta' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                            <li>
                            <a class="dropdown-item" href="{{ route($dashRoute) }}">
                                <i class="fa-solid fa-gauge-high"></i> Dashboard
                            </a>
                            </li>
                            <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger" type="submit">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar sesión
                                </button>
                            </form>
                            </li>
                        </ul>
                        </div>
                    @endguest
                </li>

                {{-- Selector de idioma --}}
                <li class="nav-item dropdown dropdown-bandera">
                    <a class="nav-link" href="#" id="idiomaDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                        role="button">
                        <img src="{{ asset('img/home/nav/banderas/' . $lang['Bandera'] . '.png') }}"
                            alt="Idioma actual">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end p-2" aria-labelledby="idiomaDropdown"
                        style="min-width:auto;">
                        <form method="POST" action="{{ route('cambiar.idioma') }}"
                            class="d-flex flex-row flex-wrap gap-2">
                            @csrf
                            @php
                                $idiomas = [
                                    'es_PE' => 'peru',
                                    'en_US' => 'usa'
                                ];
                            @endphp
                            @foreach ($idiomas as $codigo => $bandera)
                                <button class="bandera-btn btn btn-link p-0" type="submit"
                                    name="mltlngg_change_display_lang" value="{{ $codigo }}" title="{{ $codigo }}">
                                    <img src="{{ asset('img/home/nav/banderas/' . $bandera . '.png') }}"
                                        alt="{{ $bandera }}">
                                </button>
                            @endforeach
                        </form>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
