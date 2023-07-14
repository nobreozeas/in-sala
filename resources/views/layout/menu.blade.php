{{-- <header class="navbar sticky-top flex-md-nowrap p-0  nav_top">

    <div class="container">
        <a href="" class="navbar-brand col-md-3 col-lg-2 me-0 px-3">
            <img src="{{ asset('assets/images/logotipo.png') }}" alt="" width="100">
        </a>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Features</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Pricing</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Dropdown link
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#">Action</a></li>
                  <li><a class="dropdown-item" href="#">Another action</a></li>
                  <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
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
        <button class="navbar-toggler position-absolute d-md-none collapsed button_menu" type="button"
            data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
            <span><i class="fa-solid fa-bars"></i></span>
        </button>
    </div>
</header> --}}

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
                    <a class="nav-link @if(Route::is('agendamentos.index')) active @endif" aria-current="page" href="{{route('agendamentos.index')}}">Agendamentos</a>
                </li>
                <li class="nav-item px-3">
                    <a class="nav-link @if(Route::is('salas.index')) active @endif" href="{{route('salas.index')}}">Salas</a>
                </li>
                <li class="nav-item px-3">
                    <a class="nav-link @if(Route::is('horarios.index')) active @endif" href="{{route('horarios.index')}}">Horários</a>
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
