@extends('layout.app')
@push('styles')
@endpush

@section('content')
    <div class="container">

        <div class="row my-3">
            <div class="col-md-12 d-flex justify-content-end">
                <a class="btn btn-primary" href="{{ route('salas.cadastrar') }}"><i class="fa fa-plus me-2"
                        aria-hidden="true"></i>Adicionar</a>
            </div>
        </div>

        <div>
            <table id="tabela_agendamento" class="table table-responsive table-striped">
                <thead>
                    <tr>
                        <th class="">#</th>
                        <th class="text-center">Sala</th>
                        <th class="text-center">largura</th>
                        <th class="text-center">Comprimento</th>
                        <th class="text-center">Capacidade</th>
                        <th class="text-center">Status</th>
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
                    url: "{{ route('salas.listar') }}",
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
                            console.log(data);

                            return data.id;
                        }
                    }, {
                        data: null,
                        className: 'align-middle text-center',
                        render: function(data) {
                            return data.nome;
                        }
                    }, {
                        data: null,
                        orderable: false,
                        className: 'text-center align-middle',
                        render: function(data) {
                            return data.largura;
                        }
                    }, {
                        data: null,
                        orderable: false,
                        className: 'text-center align-middle',
                        render: function(data) {
                            return data.comprimento;
                        }
                    }, {
                        data: null,
                        orderable: false,
                        className: 'text-center align-middle',
                        render: function(data) {
                            return data.capacidade;
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        className: 'text-center align-middle',
                        render: function(data) {
                            let situacao = '';
                            let motivo = data.motivo_cancelamento;
                            if (data.status_sala == '1') {
                                situacao = `<span class="badge bg-success">Ativo</span>`;
                            } else {
                                situacao =
                                    `<span class="badge bg-danger">Inativo</span>`;
                            }
                            return situacao;
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        className: 'text-center align-middle',
                        render: function(data) {
                            let acoes = '';


                            acoes +=
                                `<a href="{{route('salas.editar', '')}}/${data.id}" class="btn btn-sm btn-primary me-2 btn_visualizar" data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>`;
                                acoes +=
                                    `<button type="button" class="btn btn-sm btn-danger btn_deletar" data-id="${data.id}" data-bs-toggle="tooltip" data-bs-placement="top" title="Remover"><i class="fa fa-trash" aria-hidden="true"></i></button>`;


                            return acoes;
                        }

                    },

                ]
            });

            $('body').on('click', '.btn_deletar', function(){
                let id = $(this).attr('data-id');

                Swal.fire({
                    title: 'Deseja realmente remover?',
                    text: "Não será possível reverter esta ação!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sim, remover!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `{{ route('salas.deletar', '') }}/${id}`,
                            type: "get",
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },

                            success: function(data) {
                                console.log(data);
                                // if (data.status == 'sucesso') {
                                //     Swal.fire(
                                //         'Removido!',
                                //         'Registro removido com sucesso.',
                                //         'success'
                                //     );
                                //     tabela.ajax.reload();
                                // } else {
                                //     Swal.fire(
                                //         'Erro!',
                                //         'Ocorreu um erro ao remover o registro.',
                                //         'error'
                                //     );
                                // }
                            },
                            error: function(data) {
                                console.log(data);
                                Swal.fire(
                                    'Erro!',
                                    'Ocorreu um erro ao remover o registro.',
                                    'error'
                                );
                            }
                        });
                    }
                })

            })
        })
    </script>
@endpush
