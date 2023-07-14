@extends('layout.app')
@section('content')

<div class="container">
    <div class="main">
        <div>
            <img src="{{asset('assets/images/banner.png')}}" alt="" width="400">
        </div>
        <div class="mt-3">
            <h3>Bem vindo ao InSala, o seu sistema de agendamento de salas de reunião</h3>
        </div>
        <div class="mt-3">
            <a href="{{route('agendamentos.index')}}" class="button_agendamento">Agendar uma sala</a>
        </div>
    </div>
</div>


@endsection
