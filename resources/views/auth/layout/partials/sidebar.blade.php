<aside class="ib-sidebar">
  <div class="ib-logo">
    <a href="{{ url('/') }}" title="Inicio">
      <img src="{{ asset('img/auth/dashboard/javier2.png') }}"
           class="ib-logo-img" alt="Logo IBVIRTUAL" />
    </a>
  </div>
  <nav class="ib-sidebar-nav">
    <ul>
      {{-- Sidebar ADMIN --}}
      @if(Auth::user()->role->nombre === 'admin')
        <li class="ib-nav-item {{ request()->routeIs('admin.dashboard') ? 'ib-active' : '' }}">
          <a href="{{ route('admin.dashboard') }}"><i class="material-icons">home</i> Principal</a>
        </li>
        <li class="ib-nav-item {{ request()->routeIs('admin.usuarios') ? 'ib-active' : '' }}">
          <a href="{{ route('admin.usuarios') }}"><i class="material-icons">people</i> Gestión de Usuarios</a>
        </li>
        <li class="ib-nav-item {{ request()->routeIs('admin.empleados') ? 'ib-active' : '' }}">
          <a href="{{ route('admin.empleados') }}"><i class="material-icons">supervisor_account</i> Gestión de Empleados</a>
        </li>
        <li class="ib-nav-item {{ request()->routeIs('admin.ebooks') ? 'ib-active' : '' }}">
          <a href="{{ route('admin.ebooks') }}"><i class="material-icons">book</i> Gestión de Ebooks</a>
        </li>
        <li class="ib-nav-item {{ request()->routeIs('admin.foro') ? 'ib-active' : '' }}">
          <a href="{{ route('admin.foro') }}"><i class="material-icons">forum</i> Gestión de Foros</a>
        </li>
        <li class="ib-nav-item {{ request()->routeIs('admin.contenidos') ? 'ib-active' : '' }}">
          <a href="{{ route('admin.contenidos') }}"><i class="material-icons">article</i> Gestión de Contenidos</a>
        </li>
        <li class="ib-nav-item {{ request()->routeIs('admin.reportes') ? 'ib-active' : '' }}">
          <a href="{{ route('admin.reportes') }}"><i class="material-icons">assessment</i> Reportes</a>
        </li>
        <li class="ib-nav-item">
          <a href="#"><i class="material-icons">notifications</i> Notificaciones</a>
        </li>
        <li class="ib-nav-item">
          <a href="#"><i class="material-icons">history</i> Logs</a>
        </li>
      @endif

      {{--
      @if(Auth::user()->role->nombre === 'empleado')
        <li class="ib-nav-item {{ request()->routeIs('empleado.dashboard') ? 'ib-active' : '' }}">
          <a href="{{ route('empleado.dashboard') }}"><i class="material-icons">home</i> Principal</a>
        </li>
        <li class="ib-nav-item">
          <a href="{{ route('empleado.usuarios') }}"><i class="material-icons">people</i> Usuarios Asignados</a>
        </li>
        <li class="ib-nav-item">
          <a href="{{ route('empleado.progreso') }}"><i class="material-icons">trending_up</i> Monitorear Progreso</a>
        </li>
        <li class="ib-nav-item">
          <a href="{{ route('empleado.foro') }}"><i class="material-icons">forum</i> Foros</a>
        </li>
        <li class="ib-nav-item">
          <a href="{{ route('empleado.historial') }}"><i class="material-icons">history</i> Historial de Usuarios</a>
        </li>
        <li class="ib-nav-item">
          <a href="#"><i class="material-icons">notifications</i> Notificaciones</a>
        </li>
      @endif--}}

      @if(Auth::user()->role->nombre === 'usuario')
        <li class="ib-nav-item {{ request()->routeIs('usuario.dashboard') ? 'ib-active' : '' }}">
        <a href="{{ route('usuario.dashboard') }}"><i class="material-icons">home</i> Principal</a>
        </li>
        <li class="ib-nav-item">
        <a href="{{ route('usuario.ebooks') }}"><i class="material-icons">book</i> Mis Ebooks</a>
        </li>
        <li class="ib-nav-item">
        <a href="{{ route('usuario.progreso') }}"><i class="material-icons">trending_up</i> Mi Progreso</a>
        </li>
        <li class="ib-nav-item">
        <a href="{{ route('usuario.foro') }}"><i class="material-icons">forum</i> Foros</a>
        </li>
        <li class="ib-nav-item">
        <a href="{{ route('usuario.retroalimentacion') }}"><i class="material-icons">feedback</i> Retroalimentación</a>
      @endif
      
    </ul>
  </nav>
</aside>