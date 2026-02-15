<nav class="samca-nav">
    <div class="nav-wrapper container">
        <a href="{{ route('proprietario.dashboard') }}" class="brand-logo samca-title">Coliving SAMCA</a>
        <a href="#" data-target="nav-mobile-proprietario" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        
        <ul class="right hide-on-med-and-down">
            <li class="{{ request()->routeIs('proprietario.dashboard') ? 'active' : '' }}">
                <a href="{{ route('proprietario.dashboard') }}"><i class="material-icons left">dashboard</i>Dashboard</a>
            </li>
            
            <li class="{{ request()->routeIs('proprietario.publicar') ? 'active' : '' }}">
                <a href="{{ route('proprietario.publicar') }}"><i class="material-icons left">add_circle</i>Publicar Oferta</a>
            </li>

            <li class="{{ request()->routeIs('proprietario.gerenciar') ? 'active' : '' }}">
                <a href="{{ route('proprietario.gerenciar') }}"><i class="material-icons left">business</i>Gerenciar</a>
            </li>
            
            <li class="{{ request()->routeIs('proprietario.mensagens') ? 'active' : '' }}">
                <a href="{{ route('proprietario.mensagens') }}"><i class="material-icons left">mail</i>Mensagens</a>
            </li>
            
            <li>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="waves-effect waves-light">
                        <i class="material-icons left">exit_to_app</i>Sair
                    </a>
                </form>
            </li>
        </ul>
    </div>
</nav>

<ul class="sidenav" id="nav-mobile-proprietario">
    <li class="{{ request()->routeIs('proprietario.dashboard') ? 'active' : '' }}">
        <a href="{{ route('proprietario.dashboard') }}"><i class="material-icons left">dashboard</i>Dashboard</a>
    </li>
    <li class="{{ request()->routeIs('proprietario.publicar') ? 'active' : '' }}">
        <a href="{{ route('proprietario.publicar') }}"><i class="material-icons left">add_circle</i>Publicar Oferta</a>
    </li>
    <li class="{{ request()->routeIs('proprietario.gerenciar') ? 'active' : '' }}">
        <a href="{{ route('proprietario.gerenciar') }}"><i class="material-icons left">business</i>Gerenciar</a>
    </li>
    <li class="{{ request()->routeIs('proprietario.mensagens') ? 'active' : '' }}">
        <a href="{{ route('proprietario.mensagens') }}"><i class="material-icons left">mail</i>Mensagens</a>
    </li>
    <li><div class="divider"></div></li>
    <li>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                <i class="material-icons left">exit_to_app</i>Sair
            </a>
        </form>
    </li>
</ul>