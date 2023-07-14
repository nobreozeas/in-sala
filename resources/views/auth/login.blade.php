@include('layout.header')
<link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
<style>
    .container {
        height: 100vh;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>

<div class="container">
    <div class="login">
        <div id="logotipo">
            <img src="{{ asset('assets/images/logotipo.png') }}" alt="">
        </div>
        <div class="texto_login">
            <h1 class="text-center">Login</h1>
        </div>
        <div class="formulario">
            @if (session('msgSucesso'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('msgSucesso') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($errors->has('msgErro'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Erro!</strong> {{ $errors->first('msgErro') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($errors->has('email'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Erro!</strong> {{ $errors->first('usuario') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($errors->has('password'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Erro!</strong> {{ $errors->first('password') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form class="row g-3" action="{{route('login')}}" method="POST">
                @csrf
                <div class="col-md-12">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="text" class="form-control" id="email" name="email"
                        value="{{ old('email') }}">
                </div>
                <div class="col-md-12">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="password" name="password"
                        value="{{ old('password') }}">
                </div>
                <div class="col-md-12">
                    <button type="submit" id="btn_entrar">Entrar</button>
                </div>
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('registrar') }}" class="text-decoration-none" style="color:#3173b1">Quero
                            criar uma conta</a>
                    </div>
                </div>


            </form>
        </div>




    </div>
    {{-- <div class="login_box d-flex flex-row justify-content-between">


        <div class="col">
            <div class="login">
                <h1 class="text-center">Login</h1>

                <div class="formulario">



                    <form action="" method="POST">
                        @csrf



                        @if ($errors->has('msgErro'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Erro!</strong> {{ $errors->first('msgErro') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif



                        @if ($errors->has('email'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Erro!</strong> {{ $errors->first('usuario') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if ($errors->has('password'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Erro!</strong> {{ $errors->first('password') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <label class="label-form" for="usuario">Usuário</label>
                                <input type="text" id="usuario" value="{{ old('usuario') }}" name="usuario" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="label-form" for="password">Senha</label>
                                <input type="password" id="password" value="{{ old('password') }}" name="password" class="form-control">
                            </div>
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <a href="" class="text-decoration-none" style="color:#3173b1">Esqueci minha
                                        senha</a>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-12 d-flex justify-content-center">
                                <button type="submit" class="btn btn-block btn-primary" id="btn_entrar"><i
                                        class="fa-solid fa-right-to-bracket me-2"></i>Entrar</button>
                            </div>
                        </div>
                    </form>


                </div>



            </div>
        </div>



    </div> --}}
</div>
</div>

@include('layout.rodape')
