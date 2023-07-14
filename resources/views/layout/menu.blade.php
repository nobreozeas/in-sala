<nav class="navbar navbar-expand-sm menu">
    <div class="container">
        <a class="navbar-brand" href="{{route("home")}}">
            <img src="{{ asset('assets/images/logotipo.png') }}" alt="" width="100">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto me-auto">
                <li class="nav-item px-3">
                    <a class="nav-link @if(Route::is('agendamentos.index') or Route::is('agendamentos.cadastrar') ) active @endif" aria-current="page" href="{{route('agendamentos.index')}}">Agendamentos</a>
                </li>
                <li class="nav-item px-3">
                    <a class="nav-link @if(Route::is('salas.index') or Route::is('salas.cadastrar') or Route::is('salas.editar')) active @endif" href="{{route('salas.index')}}">Salas</a>
                </li>
                <li class="nav-item px-3">
                    <a class="nav-link @if(Route::is('horarios.index') or Route::is('horarios.cadastrar')) active @endif" href="{{route('horarios.index')}}">Horários</a>
                </li>
            </ul>
        </div>

        <div class="pe-3" id="botao_logout">
            <div class="dropdown">
                <div class="nav-item text-nowrap">
                    <a class="nav-link px-3 dropdown-toggle d-flex justify-content-center align-items-center"
                        href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
                        aria-expanded="false" style="font-size: 16px; font-weight:600">
                        @php
                            $nome = explode(' ', Auth::user()->nome);
                            $nome = $nome[0];
                        @endphp
                        Olá, {{ Str::ucfirst($nome) }} <div id="img_perfil"><span></span></div> <i
                            class="fa fa-ellipsis-vertical ms-2" aria-hidden="true"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="margin-left: -11px;">
                        <li><a class="dropdown-item" href="#"><i class="fa-solid fa-user me-2"></i>Perfil</a></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}"><i
                                    class="fa-solid fa-right-from-bracket me-2"></i>Sair</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
