<nav class="samca-nav">
    <div class="nav-wrapper container">
        <a href="{{ route('aluno.dashboard') }}" class="brand-logo samca-title">Coliving SAMCA</a>
        <a href="#" data-target="nav-mobile-aluno" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        
        <ul class="right hide-on-med-and-down">
            <li class="{{ request()->routeIs('aluno.dashboard') ? 'active' : '' }}">
                <a href="{{ route('aluno.dashboard') }}"><i class="material-icons left">dashboard</i>Dashboard</a>
            </li>
            
            <li class="{{ request()->routeIs('aluno.buscar') ? 'active' : '' }}">
                <a href="{{ route('aluno.buscar') }}"><i class="material-icons left">search</i>Buscar Moradia</a>
            </li>
            
            <li class="{{ request()->routeIs('aluno.mensagens') ? 'active' : '' }}">
                <a href="{{ route('aluno.mensagens') }}"><i class="material-icons left">mail</i>Mensagens</a>
            </li>
            
            <li class="{{ request()->routeIs('aluno.perfil*') ? 'active' : '' }}">
                <a href="{{ route('aluno.perfil') }}">
                    <i class="material-icons left">person</i>Meu Perfil
                </a>
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

<ul class="sidenav" id="nav-mobile-aluno">
    <li class="{{ request()->routeIs('aluno.dashboard') ? 'active' : '' }}">
        <a href="{{ route('aluno.dashboard') }}"><i class="material-icons left">dashboard</i>Dashboard</a>
    </li>
    <li class="{{ request()->routeIs('aluno.buscar') ? 'active' : '' }}">
        <a href="{{ route('aluno.buscar') }}"><i class="material-icons left">search</i>Buscar Moradia</a>
    </li>
    <li class="{{ request()->routeIs('aluno.mensagens') ? 'active' : '' }}">
        <a href="{{ route('aluno.mensagens') }}"><i class="material-icons left">mail</i>Mensagens</a>
    </li>
    <li class="{{ request()->routeIs('aluno.perfil') ? 'active' : '' }}">
        <a href="{{ route('aluno.perfil') }}"><i class="material-icons left">person</i>Meu Perfil</a>
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