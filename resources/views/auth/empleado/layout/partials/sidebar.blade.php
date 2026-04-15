<aside class="ib-sidebar">
  <div class="ib-logo">
    <a href="{{ url('/') }}" title="Inicio">
        <img src="{{ asset('img/auth/dashboard/javier2.png') }}"
         class="ib-logo-img" alt="Logo IBJOBCOACH" />
    </a>
  </div>
  <nav class="ib-sidebar-nav">
    <ul>
      <li class="ib-nav-item {{ request()->routeIs('dashboard') ? 'ib-active' : '' }}">
        <a href="{{ route('dashboard') }}"><i class="material-icons">home</i> Principal</a>
      </li>
      <li class="ib-nav-item"><a href="{{ route ('alumni.create') }}"><i class="material-icons">person</i> Alumni de Usuario</a></li>
      <li class="ib-nav-item"><a href="{{ route ('foro.create') }}"><i class="material-icons">assignment</i> Registro de foro</a></li>
      <li class="ib-nav-item"><a href="#"><i class="material-icons">book</i> Registro de PDF</a></li>
      <li class="ib-nav-item"><a href="{{ route ('contenidos.create') }}"><i class="material-icons">article</i> Registro Contenidos</a></li>
      <li class="ib-nav-item {{ request()->routeIs('articulos.index') ? 'ib-active' : '' }}">
        <a href="{{ route('articulos.index') }}">
          <i class="material-icons">content_paste</i> Tablas
        </a>
      </li>

      <li class="ib-nav-item"><a href="{{ route('map') }}"><i class="material-icons">location_ons</i> Maps</a></li>
      <li class="ib-nav-item"><a href="#"><i class="material-icons">notifications</i> Notificaciones</a></li>
    </ul>
  </nav>
</aside>
