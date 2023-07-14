@extends('layout.app')
@push('styles')
@endpush

@section('content')
    <div class="container">

        <div class="row my-3">
            <div class="col-md-12 d-flex justify-content-end">
                <a class="btn btn-primary" href="{{ route('horarios.cadastrar') }}"><i class="fa fa-plus me-2"
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
                        <th class="text-center">Status</th>
                        <th class="text-center">Horarios</th>
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
                    url: "{{ route('horarios.listar') }}",
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
                            return data.sala.nome;
                        }
                    }, {
                        data: null,
                        orderable: false,
                        className: 'text-center align-middle',
                        render: function(data) {
                            return moment(data.data).format('DD/MM/YYYY');
                        }
                    }, {
                        data: null,
                        orderable: false,
                        className: 'text-center align-middle',
                        render: function(data) {
                            let status = '';

                            if (data.status_datas_horarios == '1') {
                                status = '<span class="badge bg-success">Ativo</span>';
                            } else {
                                status = '<span class="badge bg-danger">Inativo</span>';
                            }
                            return status;
                        }
                    }, {
                        data: null,
                        orderable: false,
                        className: 'align-middle',
                        render: function(data) {
                            if(data.horarios.length > 0){
                                let horarios = '';
                                data.horarios.forEach(horario => {
                                    horarios += `<span class="badge bg-primary">${horario.horario_inicio}- ${horario.horario_fim} </span> `;
                                });
                                return horarios;
                            }else{
                                return '<span class="badge bg-danger">Sem horarios</span>';
                            }
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        className: 'text-center align-middle',
                        render: function(data) {
                            let acoes = '';

                            acoes += `
                            <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            `;
                            return acoes;

                        }
                    },


                ]
            });


        })
    </script>
@endpush
