<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'IBJobCoach')</title>

    {{-- ===== CSS ===== --}}
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <!-- intl-tel-input CSS (versión segura y fija) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.3.1/build/css/intlTelInput.min.css">

    <!-- Otros CSS externos -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">

    <!-- FontAwesome kit (si lo necesitas para iconos pro) -->
    <script src="https://kit.fontawesome.com/c353473263.js" crossorigin="anonymous"></script>

    {{-- Tus estilos propios --}}
    <link rel="stylesheet" href="{{ asset('css/general.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/layout/inicio.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/masthead/masthead.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/layout/nav/nav.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/beneficios/beneficios.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/formprueba/formprueba.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/nosotros/nosotros.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/footer/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth/testimonios.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ebook/info_ebook.css') }}">
    <!-- <link rel="stylesheet" href="{{ asset('css/home/layout/style-min.css') }}"> -->
    <!-- <link rel="stylesheet" href="{{ asset('css/ebook/pago_ebook.css') }}"> -->

    <!--Permitirá validar si está logueado o no para proceder con el pago-->
    <script>
        window.isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
    </script>
    <script src="{{ asset('js/home/layout/nav/nav.js') }}"></script>
    @stack('styles')
</head>

<body>
    @include('shared.partials.nav')
    @include('shared.partials.modal')

    <main role="main" style="min-height: 100vh;">
        @yield('content')
    </main>

    @include('shared.partials.footer')
    @include('Home.Empresa.form_empresa')

    {{-- Significa la ruta del login, que se dirigirá en caso que no se haya logueado --}}
    <script>
        const checkoutRedirectURL = "{{ route('login') }}?redirect=" + encodeURIComponent(window.location.pathname);
    </script>
    <script src="{{ asset('js/home/carrito.js') }}"></script>
    {{-- ===== JS ===== --}}
    <!-- Bootstrap 5 Bundle (NO jQuery necesario) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- intl-tel-input JS (versión segura y fija) -->
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.3.1/build/js/intlTelInput.min.js"></script>
    <!-- utils para formato y validación de números -->
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.3.1/build/js/utils.js"></script>

    <!-- Inputmask (si usas para otros campos) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.8/browser/inputmask.min.js"></script>

    <!-- Otros JS externos (por ejemplo, animate.css necesita wow.js si usas animaciones scroll) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>

    {{-- JS propio --}}

    <script src="{{ asset('js/home/masthead/carousel.js') }}"></script>
    <script src="{{ asset('js/home/footer/user.js') }}"></script>
    <script src="{{ asset('js/home/formprueba/formprueba.js') }}"></script>

    @stack('scripts')
</body>

</html>