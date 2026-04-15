{{-- resources/views/auth/layout/partials/navbar.blade.php --}}
<nav class="ib-navbar">
  <div class="ib-navbar-inner">
    <div class="ib-navbar-title">Contenidos actuales</div>

    <form class="ib-navbar-search" action="#" method="GET">
      <input type="text" name="q" placeholder="Buscar...">
      <button type="submit"><i class="material-icons">search</i></button>
    </form>

    @php
        /** @var \App\Models\Usuario|null $user */
        $user = Auth::user();
        $role = optional(optional($user)->role)->nombre; // admin | empleado | usuario

        // Helper para verificar rutas sin usar "use" dentro de @php
        $has = function (string $name): bool {
            return \Illuminate\Support\Facades\Route::has($name);
        };

        // Rutas de Perfil / Ajustes según rol (con fallback si no existen)
        if ($role === 'admin') {
            $perfilRoute  = $has('admin.perfil')  ? route('admin.perfil')  : '#';
            $ajustesRoute = $has('admin.ajustes') ? route('admin.ajustes') : '#';
        } elseif ($role === 'empleado') {
            $perfilRoute  = $has('empleado.perfil')  ? route('empleado.perfil')
                        : ($has('usuario.perfil') ? route('usuario.perfil') : '#');
            $ajustesRoute = $has('empleado.ajustes') ? route('empleado.ajustes')
                        : ($has('usuario.configuracion') ? route('usuario.configuracion') : '#');
        } else { // usuario
            $perfilRoute  = $has('usuario.perfil') ? route('usuario.perfil') : '#';
            $ajustesRoute = $has('usuario.configuracion') ? route('usuario.configuracion') : '#';
        }

        // Campana de notificaciones (en tu flujo actual solo admin recibe)
        $showNotifs  = ($role === 'admin');
        $unreadCount = $showNotifs && $user ? $user->unreadNotifications()->count() : 0;
        $notifs      = $showNotifs && $user ? $user->notifications()->latest()->take(8)->get() : collect();
    @endphp

    <div class="ib-navbar-actions" style="display:flex; align-items:center; gap:.75rem;">

      {{-- Notificaciones (solo admin por defecto) --}}
      @if($showNotifs)
        <div class="ib-profile-dropdown" style="position:relative;">
          <button id="ibNotifBtn" type="button" class="ib-notif-btn" title="Notificaciones" style="position:relative; display:flex; align-items:center; gap:.25rem;">
            <i class="material-icons">notifications</i>
            @if($unreadCount > 0)
              <span class="ib-badge" style="position:absolute; top:-4px; right:-4px; background:#e53935; color:#fff; border-radius:10px; padding:0 .35rem; font-size:.75rem; line-height:1.2;">
                {{ $unreadCount }}
              </span>
            @endif
          </button>

          <div id="ibNotifMenu" class="ib-dropdown-menu" style="position:absolute; right:0; top:110%;
              min-width: 320px; background:#fff; border:1px solid #e0e0e0; border-radius:8px; box-shadow:0 10px 20px rgba(0,0,0,.08);
              display:none; z-index:999;">
            <div style="padding:.75rem .75rem .5rem; border-bottom:1px solid #eee; display:flex; justify-content:space-between; align-items:center;">
              <strong>Notificaciones</strong>
              @if($unreadCount > 0 && $has('admin.notificaciones.marcar'))
                <form action="{{ route('admin.notificaciones.marcar') }}" method="POST">
                  @csrf
                  <button type="submit" class="btn btn-link" style="font-size:.85rem;">Marcar todas como leídas</button>
                </form>
              @endif
            </div>

            <div style="max-height:360px; overflow:auto;">
              @forelse($notifs as $n)
                @php
                  $data     = $n->data ?? [];
                  $foroId   = $data['foro_id'] ?? null;
                  $autor    = $data['respondedor'] ?? 'Alguien';
                  $titulo   = $data['foro_titulo'] ?? 'Tema del foro';
                  $mensaje  = \Illuminate\Support\Str::limit($data['mensaje'] ?? '', 90);
                  $isUnread = is_null($n->read_at);
                @endphp

                <div style="padding:.75rem; border-bottom:1px solid #f2f2f2; background:{{ $isUnread ? '#f9fbff' : '#fff' }}">
                  <div style="display:flex; align-items:flex-start; gap:.5rem;">
                    <i class="material-icons" style="font-size:20px;">chat_bubble</i>
                    <div style="flex:1;">
                      <div style="font-size:.9rem;">
                        <strong>{{ $autor }}</strong> respondió en
                        <a href="{{ $foroId ? route('admin.foro.show', $foroId) : '#' }}" style="text-decoration:underline;">
                          {{ $titulo }}
                        </a>
                      </div>
                      @if($mensaje)
                        <div style="font-size:.85rem; color:#666; margin-top:.25rem;">“{{ $mensaje }}”</div>
                      @endif
                      <div style="display:flex; gap:.5rem; align-items:center; margin-top:.5rem;">
                        @if($foroId)
                          <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.foro.show', $foroId) }}">Ver hilo</a>
                        @endif
                        @if($isUnread && $has('admin.notificaciones.marcar'))
                          <form action="{{ route('admin.notificaciones.marcar') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $n->id }}">
                            <button type="submit" class="btn btn-sm btn-light">Marcar leída</button>
                          </form>
                        @endif
                      </div>
                    </div>
                  </div>
                  <div style="margin-top:.35rem; font-size:.75rem; color:#999;">
                    {{ $n->created_at->diffForHumans() }}
                  </div>
                </div>
              @empty
                <div style="padding:1rem; color:#777;">No tienes notificaciones.</div>
              @endforelse
            </div>
          </div>
        </div>
      @endif

      {{-- Perfil --}}
      <div class="ib-navbar-profile">
        <div class="ib-profile-dropdown">
          <button id="ibProfileBtn" type="button"><i class="material-icons">person</i></button>
          <div class="ib-dropdown-menu" id="ibProfileMenu">
            <a href="{{ $perfilRoute }}">Perfil</a>
            <a href="{{ $ajustesRoute }}">Ajustes</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar sesión</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>

{{-- Script de toggles --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
  const notifBtn  = document.getElementById('ibNotifBtn');
  const notifMenu = document.getElementById('ibNotifMenu');
  const profBtn   = document.getElementById('ibProfileBtn');
  const profMenu  = document.getElementById('ibProfileMenu');

  function closeAll() {
    if (notifMenu) notifMenu.style.display = 'none';
    if (profMenu)  profMenu.style.display  = 'none';
  }

  if (notifBtn && notifMenu) {
    notifBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      const open = notifMenu.style.display === 'block';
      closeAll();
      notifMenu.style.display = open ? 'none' : 'block';
    });
  }

  if (profBtn && profMenu) {
    profBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      const open = profMenu.style.display === 'block';
      closeAll();
      profMenu.style.display = open ? 'none' : 'block';
    });
  }

  document.addEventListener('click', function () { closeAll(); });
});
</script>
