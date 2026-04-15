<nav class="ib-navbar">
    <div class="ib-navbar-inner">
        <div class="ib-navbar-title">Contenidos actuales</div>
        <form class="ib-navbar-search">
            <input type="text" placeholder="Buscar...">
            <button type="submit"><i class="material-icons">search</i></button>
        </form>
        <div class="ib-navbar-profile">
            <div class="ib-profile-dropdown">
                <button id="ibProfileBtn" type="button"><i class="material-icons">person</i></button>
                <div class="ib-dropdown-menu" id="ibProfileMenu">
                    <a href="#">Perfil </a>
                    <a href="#">Ajustes</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar sesión</a>
                </div>
            </div>
        </div>
    </div>
</nav>
