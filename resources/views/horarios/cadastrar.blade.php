@extends('layout.app')
@section('content')
    <div class="container">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('horarios.index') }}">Horários</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cadastrar data e horário</li>
            </ol>
        </nav>

        <div class="box_form">
            <div class="d-flex justify-content-between">
                <div>
                    <h3>Cadastrar Data Horário</h3>
                </div>
                <div class="d-flex">
                    <a class="btn btn-secondary me-2" href="{{ route('horarios.index') }}"><i
                            class="fa fa-arrow-left me-2" aria-hidden="true"></i>Voltar</a>

                </div>
            </div>
            <form class="row g-3" action="">
                @csrf
                <div class="col-md-6">
                    <label for="sala" class="form-label">Sala</label>
                    <select name="sala" id="sala" class="form-select" required>
                        <option value="">Selecione</option>
                        @foreach ($salas as $sala)
                            <option value="{{ $sala->id }}">{{ $sala->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="data" class="form-label">Data</label>
                    <input type="date" class="form-control input-number" id="data" name="data" required>
                </div>

                <span><strong>Horários</strong></span>


                <div class="horarios">
                    <div class="row">
                        <div class="col-md-5">
                            <span>Horário Inicial</span>
                        </div>
                        <div class="col-md-5">
                            <span>Horário Final</span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-5">
                            <input type="time" class="form-control input-number horario_inicial" name="horario_inicial[]"
                                required>
                        </div>
                        <div class="col-md-5">
                            <input type="time" class="form-control input-number horario_final" name="horario_final[]"
                                required>
                        </div>

                    </div>

                </div>
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary" id="add_horario"><i class="fa fa-plus me-2"
                            aria-hidden="true"></i>Adicionar Horário</button>
                </div>

                <div class="col-md-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" id="btn_add"><i class="fa fa-save me-2"
                            aria-hidden="true"></i>Cadastrar</button>
                </div>

            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            //ao clicar no botao de add horario ele adiciona um novo campo de horario para ser preenchido pelo usuario lado a lado
            $('body').on('click', '#add_horario', function() {
                $('.horarios').append(`
                    <div class="row mb-2">
                        <div class="col-md-5">
                            <input type="time" class="form-control input-number horario_inicial" name="horario_inicial[]" required>
                        </div>
                        <div class="col-md-5">
                            <input type="time" class="form-control input-number horario_final" name="horario_final[]" required>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn_remove"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        </div>
                    </div>
                `);
            });

            //ao clicar no botao de remover horario ele remove o campo de horario

            $(document).on('click', '.btn_remove', function() {
                $(this).closest('.row').remove();
            });

            $('body').on('change', '.horario_final', function() {
                let horario_inicial = $(this).closest('.row').find('.horario_inicial').val();
                let horario_final = $(this).closest('.row').find('.horario_final').val();

                if (horario_inicial > horario_final) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: 'Horário final não pode ser menor que o horário inicial',
                        confirmButtonText: 'Ok',
                        confirmButtonColor: '#3085d6',

                    });
                    $(this).closest('.row').find('.horario_final').val('');
                }
                if (horario_inicial == horario_final) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: 'Horário final não pode ser igual ao horário inicial',
                        confirmButtonText: 'Ok',
                        confirmButtonColor: '#3085d6',

                    });
                    $(this).closest('.row').find('.horario_final').val('');
                }
            })

            $('#btn_add').on('click', function(event) {
                event.preventDefault();

                //verifica se todos os campos foram preenchidos
                let sala = $('#sala').val();
                let data = $('#data').val();
                let horario_inicial = $('.horario_inicial').val();
                let horario_final = $('.horario_final').val();

                if (sala == '' || data == '' || horario_inicial == '' || horario_final == '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: 'Preencha todos os campos',
                        confirmButtonText: 'Ok',
                        confirmButtonColor: '#3085d6',

                    });
                    return false;
                }

                let dados = {
                    sala: $('#sala').val(),
                    data: $('#data').val(),

                };

                let horarios = [];

                $('.horarios .row').next().each(function() {
                    let horario_inicial = $(this).find('.horario_inicial').val();
                    let horario_final = $(this).find('.horario_final').val();

                    horarios.push({
                        horario_inicial: horario_inicial,
                        horario_final: horario_final
                    });
                });

                dados.horarios = horarios;


                var loading;
                $.ajax({
                    url: "{{ route('horarios.salvar') }}",
                    type: 'POST',
                    data: dados,
                    beforeSend: function() {
                        loading = Swal.fire({
                            title: 'Aguarde...',
                            html: 'Salvando sala',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading()
                            },
                        });
                    },
                    complete: function() {
                        loading.close();
                    },
                    success: function(data) {
                        console.log(data);
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: data.msg,
                            confirmButtonText: 'Ok',
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {
                            window.location.href = "{{ route('horarios.index') }}";
                        });

                    },
                    error: function(error) {
                        console.log(error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro!',
                            text: error.responseJSON.msg,
                            confirmButtonText: 'Ok',
                            confirmButtonColor: '#3085d6',

                        });
                    }
                });


            });










        });
    </script>
@endpush
