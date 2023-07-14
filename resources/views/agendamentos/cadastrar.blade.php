@extends('layout.app')
@push('styles')
    <style>
        table {
            border-collapse: collapse;
        }

        td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
            cursor: pointer;
        }

        td.disabled {
            background-color: lightgray;
            cursor: not-allowed;
        }

        td.enabled:hover {
            background-color: lightblue;
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
            <div class="d-flex justify-content-between">
                <div>
                    <h3>Cadastrar Agendamento</h3>
                </div>
                <div class="d-flex">
                    <a class="btn btn-secondary me-2" href="{{ route('agendamentos.index') }}"><i class="fa fa-arrow-left me-2"
                            aria-hidden="true"></i>Voltar</a>

                </div>
            </div>
            <form class="row g-3" action="">
                @csrf

                <div class="col-md-4">
                    <label for="sala" class="form-label">Sala</label>
                    <select name="sala" id="sala" class="form-select" required>
                        <option value="">Selecione</option>
                        @foreach ($salas as $sala)
                            <option value="{{ $sala->id }}">{{ $sala->nome }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="col-md-4">
                    <label for="calendario" class="form-label" id="label_calendario">Selecione uma data</label>
                    <input type="text" class="form-control" name="calendario" id="calendario" placeholder="dd/mm/aaaa"
                        required readonly>

                </div>
                <div class="col-md-4">

                    <div id="horario"></div>
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

            $('#label_horario').hide();
            $('#label_calendario').hide();
            $('#calendario').hide();
            $('#horario').hide();

            $('#sala').on('change', function() {
                let sala = $(this).val();

                if (sala != "") {
                    $.ajax({
                        url: "{{ route('horarios.consultaData') }}",
                        method: 'POST',
                        data: {
                            sala: sala,
                        },
                        success: function(response) {
                            // for (let i in response.datas) {
                            //     if(response.datas[i].horarios.length == 0){
                            //         Swal.fire({
                            //             icon: 'error',
                            //             title: 'Oops...',
                            //             text: 'Não há horários disponíveis para essa sala!',
                            //             confirmButtonColor: '#3085d6',
                            //         })
                            //         $('#btn_add').hide();
                            //         return false;
                            //     }
                            // }

                            $('#label_calendario').show();
                            $('#calendario').show();

                            var datas = [];
                            var horario_inicial = [];
                            var horario_final = [];
                            let dias = response.datas;



                            dias.forEach(data => {
                                datas.push(data.data);
                            });

                            function verificarDataDisponivel(date) {
                                var dataFormatada = $.datepicker.formatDate("yy-mm-dd",
                                    date); // Formata a data como "yyyy-mm-dd"
                                return [datas.indexOf(dataFormatada) > -1];
                            }

                            $('#label_horario').show();
                            $("#calendario").datepicker({
                                dateFormat: "dd/mm/yy",
                                beforeShowDay: verificarDataDisponivel,
                                closeText: 'Fechar',
                                prevText: '&#x3C;Anterior',
                                nextText: 'Próximo&#x3E;',
                                currentText: 'Hoje',
                                monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril',
                                    'Maio', 'Junho',
                                    'Julho', 'Agosto', 'Setembro', 'Outubro',
                                    'Novembro', 'Dezembro'
                                ],
                                monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai',
                                    'Jun',
                                    'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'
                                ],
                                dayNames: ['Domingo', 'Segunda-feira', 'Terça-feira',
                                    'Quarta-feira', 'Quinta-feira', 'Sexta-feira',
                                    'Sábado'
                                ],
                                dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui',
                                    'Sex',
                                    'Sáb'
                                ],
                                dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex',
                                    'Sáb'
                                ],
                                weekHeader: 'Sm',
                                firstDay: 0,
                                isRTL: false,
                                showMonthAfterYear: false,
                                yearSuffix: ''
                            });


                            $("#calendario").on("change", function() {
                                //limpa options
                                $('#horario').html('');
                                $('#horario').show();
                                horario_inicial = [];
                                horario_final = [];



                                var data = $(this).val();
                                let dataFormatada = data.split('/').reverse().join('-');
                                let conteudo = '';

                                for (let i in dias) {
                                    if (dias[i].data == dataFormatada) {
                                        console.log(dias[i]);
                                        for (let j in dias[i].horarios) {
                                            console.log(dias[i].horarios[j]);
                                            horario_inicial.push(dias[i].horarios[j]
                                                .horario_inicio);
                                            horario_final.push(dias[i].horarios[j]
                                                .horario_fim);
                                        }
                                    }

                                }



                                $("#horario").html('');

                                conteudo +=
                                    '<label for="horario" class="form-label">Horário</label>';
                                conteudo +=
                                    '<select name="horario" id="horarios" class="form-select" required>';
                                conteudo += '<option value="">Selecione</option>';
                                for (let i in horario_inicial) {
                                    conteudo += `
                                    <option value="${horario_inicial[i]}-${horario_final[i]}">${horario_inicial[i]} - ${horario_final[i]}</option>
                                `;
                                }
                                conteudo += '</select>';

                                $("#horario").html(conteudo);

                            });

                            $('body').on('click', '#btn_add', function(e) {
                                //verifica se todos os campos estão diferentes de vazio
                                console.log($('#sala').val());
                                console.log($('#calendario').val());
                                console.log($('#horarios').val());

                                //pegar o valor do select

                                if ($('#sala').val() == '' || $('#calendario').val() ==
                                    '' || $('#horarios').val() == '') {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Preencha todos os campos!',
                                        confirmButtonColor: '#3085d6',
                                    })
                                    return false;
                                }


                                e.preventDefault();
                                let dados = [];
                                let sala = $('#sala').val();
                                let calendario = $('#calendario').val();
                                let horario = $('#horarios').val();
                                let horario_inicio = horario.split('-')[0];
                                let horario_fim = horario.split('-')[1];
                                //formatar data
                                let data = calendario.split('/').reverse().join('-');
                                var loading;

                                $.ajax({
                                    url: "{{ route('agendamentos.salvar') }}",
                                    method: 'POST',
                                    data: {
                                        sala: sala,
                                        data: data,
                                        horario_inicio: horario_inicio,
                                        horario_fim: horario_fim,
                                    },
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
                                    success: function(response) {
                                        console.log(response);

                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Sucesso!',
                                            text: response.msg,
                                            confirmButtonColor: '#3085d6',
                                            confirmButtonText: 'Ok'
                                        }).then((result) => {
                                            window.location.href = "{{ route('agendamentos.index') }}";
                                        })

                                    },
                                    error: function(error) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: error.responseJSON.msg,
                                            confirmButtonColor: '#3085d6',
                                        })
                                    }

                                })



                            })





                        },
                        error: function(error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: error.responseJSON.message,
                                confirmButtonColor: '#3085d6',
                            })
                        }

                    })
                }


            })
        });
    </script>
@endpush
