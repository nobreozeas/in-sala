@extends('layout.app')
@push('styles')
    <style>
        #calendario{
            display: flex;
            align-self: center;
            width: 70%;
            height: 100%;
            border: 1px solid #ccc;
            padding: 20px;

            background-color: red;
        }

    </style>
@endpush
@section('content')
    <div class="container">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('agendamentos.index') }}">Agendamentos</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cadastrar Agendamento</li>
            </ol>
        </nav>

        <div class="box_form">
            <h3>Cadastrar Agendamento</h3>
            <form class="row g-3" action="">
                @csrf

                <div class="col-md-12">
                    <label for="sala" class="form-label">Sala</label>
                    <select name="sala" id="sala" class="form-select" required>
                        <option value="">Selecione</option>
                        @foreach ($salas as $sala)
                            <option value="{{ $sala->id }}">{{ $sala->nome }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="col-md-12 d-flex justify-content-center">
                    <div id="calendario"></div>
                </div>


                <div class="col-md-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" id="btn_add"><i class="fa fa-save me-2"
                            aria-hidden="true"></i>Agendar</button>
                </div>

            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('#sala').on('change', function(){
                let sala = $(this).val();

                $.ajax({
                    url: "{{ route('horarios.consultaData') }}",
                    method: 'POST',
                    data: {
                        sala: sala,
                    },
                    success: function(response) {


                        let datas = response.datas;


                    },
                    error: function(error) {
                        console.log(error);
                    }

                })
            })






        });
    </script>
@endpush
