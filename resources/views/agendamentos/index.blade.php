@extends('layout.app')
@push('styles')
@endpush

@section('content')
    <div class="container">

        <div class="row my-3">
            <div class="col-md-12 d-flex justify-content-end">
                <a class="btn btn-primary" href="{{ route('agendamentos.cadastrar') }}"><i class="fa fa-plus me-2"
                        aria-hidden="true"></i>Adicionar</a>
            </div>
        </div>


        <div>
            <table id="tabela_agendamento" class="table table-responsive table-striped">
                <thead>
                    <tr>
                        <th class="">#</th>
                        <th class="text-center">Sala</th>
                        <th class="text-center">Data</th>
                        <th class="text-center">Horário</th>
                        <th class="text-center">Usuário</th>
                        <th class="text-center">Situação</th>
                        <th class="text-center">Criado em</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody></tbody>


            </table>
        </div>



    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {

            var tabela = $('#tabela_agendamento').DataTable({
                "searching": false,
                "width": "100%",
                "order": [0, "DESC"],
                "processing": true,
                "serverSide": true,
                "bLengthChange": false,
                "responsive": true,
                "lenhtChange": false,
                "language": {
                    "url": "{{ asset('assets/js/pt-BR.json') }}"
                },
                "pageLength": 50,
                drawCallback: function(e) {
                    $('[data-toggle="tooltip"]').tooltip('destroy');
                    $('[data-toggle="popover"]').popover('destroy');

                    $('[data-bs-toggle="tooltip"]').tooltip();
                    $('[data-bs-toggle="popover"]').popover({
                        html: true
                    });

                },
                "ajax": {
                    url: "{{ route('agendamentos.listar') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: function(data) {

                    }
                },
                "columns": [{
                        data: null,
                        className: 'align-middle',
                        render: function(data) {

                            return data.id;
                        }
                    }, {
                        data: null,
                        className: 'align-middle text-center',
                        render: function(data) {
                            return data.sala.nome;
                        }
                    }, {
                        data: null,
                        orderable: false,
                        className: 'text-center align-middle',
                        render: function(data) {
                            return moment(data.data_horario.data).format('DD/MM/YYYY');
                        }
                    }, {
                        data: null,
                        className: 'text-center align-middle',
                        render: function(data) {
                            let horario_inicial = data.horario_agendamento.horario_inicio;
                            let horario_final = data.horario_agendamento.horario_fim;
                            return `${horario_inicial} - ${horario_final}`;
                        }
                    }, {
                        data: null,
                        className: 'text-center align-middle',
                        render: function(data) {
                            return data.usuario_criacao.nome;
                        }
                    },
                    {
                        data: null,
                        className: 'text-center align-middle',
                        render: function(data) {
                            let situacao = '';
                            let motivo = data.motivo_cancelamento;
                            if (data.status_agendamento == '1') {
                                situacao = `<span class="badge bg-success">Ativo</span>`;
                            } else {
                                situacao =
                                    `<span class="badge bg-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="${motivo ?? ' '}">Cancelado</span>`;
                            }
                            return situacao;
                        }
                    },
                    {
                        data: null,
                        className: 'text-center align-middle',
                        render: function(data) {
                            return moment(data.created_at).format('DD/MM/YYYY HH:mm');
                        }
                    },
                    {
                        data: null,
                        className: 'text-center align-middle',
                        render: function(data) {
                            let acoes = '';

                            acoes +=
                                `<button type="button"  class="btn btn-sm btn-primary me-2 btn_visualizar" data-id="${data.id} data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></button>`;

                            if (data.status_agendamento == '2') {
                                acoes +=
                                    `<button type="button" disabled class="btn btn-sm btn-danger btn_cancelar" data-id="${data.id}" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancelar"><i class="fa fa-ban" aria-hidden="true"></i></button>`;
                            } else {
                                acoes +=
                                    `<button type="button" class="btn btn-sm btn-danger btn_cancelar" data-id="${data.id}" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancelar"><i class="fa fa-ban" aria-hidden="true"></i></button>`;
                            }
                            return acoes;
                        }

                    },

                ]
            });

            $('body').on('click', '.btn_cancelar', function(event) {
                let id = $(this).attr('data-id');
                Swal.fire({
                    title: 'Deseja cancelar o agendamento?',
                    showCancelButton: true,
                    confirmButtonText: `Sim`,
                    confirmButtonColor: '#dc3545',
                    cancelButtonText: `Não`,
                    icon: 'warning',
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        const {
                            value: motivo
                        } = await Swal.fire({
                            title: 'Insira o motivo do cancelamento',
                            input: 'text',
                            confirmButtonText: 'Cancelar',
                            confirmButtonColor: '#dc3545',

                            inputValidator: (value) => {
                                if (!value) {
                                    return 'You need to write something!'
                                }
                            }
                        })


                        if (motivo) {
                            $.ajax({
                                url: `{{ route('agendamentos.cancelar', '') }}/${id}`,
                                type: "get",
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                data: {
                                    motivo_cancelamento: motivo
                                },
                                success: function(data) {
                                    Swal.fire({
                                        title: 'Sucesso!',
                                        text: data.msg,
                                        icon: 'success',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#dc3545',
                                    }).then((result) => {

                                        tabela.draw();

                                    })
                                },

                                error: function(data) {
                                    Swal.fire({
                                        title: 'Erro!',
                                        text: data.msg,
                                        icon: 'error',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#dc3545',
                                    })
                                }
                            })

                        }


                    }
                })
            })

            $('body').on('click', '.btn_visualizar', function() {
                let id = $(this).attr('data-id');

                $.ajax({
                    url: `{{ route('agendamentos.visualizar', '') }}/${id}`,
                    type: "get",
                    success: function(data) {
                        console.log(data);

                        let modal = `
                        <div class="modal fade" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Agendamento - ${data.id}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Data: ${moment(data.data_horario.data).format('DD/MM/YYYY')}</p>
                                    <p>Horário: ${data.horario_agendamento.horario_inicio} - ${data.horario_agendamento.horario_fim}</p>
                                    <p>Sala: ${data.sala.nome}</p>
                                    <p>Usuário: ${data.usuario_criacao.nome}</p>
                                    <p>Situação: ${data.status_agendamento == '1' ? 'Ativo' : 'Cancelado'}</p>
                                    <p>Motivo do cancelamento: ${data.motivo_cancelamento ?? ' '}</p>
                                    <p>Criado em: ${moment(data.created_at).format('DD/MM/YYYY HH:mm')}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>

                                </div>
                                </div>
                            </div>
                        </div>
                        `;
                        $('body').append(modal);
                        $('.modal').modal('show');
                        $('.modal').on('hidden.bs.modal', function(e) {
                            $(this).remove();
                        })

                    },
                    error: function(error) {

                    }
                })

            })




        })
    </script>
@endpush
