@extends('layout.app')

@section('content')

<div class="container">

    <div class="row my-3">
        <div class="col-md-12 d-flex justify-content-end">
            <a class="btn btn-primary" href="{{route('horarios.cadastrar')}}"><i class="fa fa-plus me-2" aria-hidden="true"></i>Adicionar</a>
        </div>
    </div>


</div>


@endsection
