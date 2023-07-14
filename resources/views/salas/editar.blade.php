@extends('layout.app')
@section('content')
    <div class="container">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('salas.index') }}">Salas</a></li>
                <li class="breadcrumb-item active" aria-current="page">Editar Sala</li>
            </ol>
        </nav>

        <div class="box_form">
            <div class="d-flex justify-content-between">
                <div>
                    <h3>Editar Sala</h3>
                </div>
                <div class="d-flex">
                    <a class="btn btn-primary me-2" href="{{ route('salas.index') }}"><i class="fa fa-arrow-left me-2"
                            aria-hidden="true"></i>Voltar</a>

                    <button class="btn btn-success" id="btn_edita"><i class="fa fa-pencil me-2" aria-hidden="true"></i>Editar</button>
                </div>
            </div>
            <form class="row g-3" action="" enctype="multipart/form-data">
                @csrf
                <div class="col-md-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" required value="{{$sala->nome}}" disabled>
                </div>
                <div class="col-md-3">
                    <label for="capacidade" class="form-label">Capacidade</label>
                    <input type="number" class="form-control input-number" id="capacidade" name="capacidade" required value="{{$sala->capacidade}}" disabled>
                </div>
                <div class="col-md-3">
                    <label for="largura" class="form-label">Largura</label>
                    <input type="number" class="form-control input-number" id="largura" name="largura" required value="{{$sala->largura}}" disabled>
                </div>
                <div class="col-md-3">
                    <label for="comprimento" class="form-label">Comprimento</label>
                    <input type="number" class="form-control input-number" id="comprimento" name="comprimento" required value="{{$sala->comprimento}}" disabled>
                </div>

                <div class="col-md-12">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea class="form-control" id="descricao" name="descricao" rows="3" required disabled>{{$sala->descricao}}</textarea>
                </div>

                <div class="col-md-6">
                    <label for="imagem" class="form-label">Imagem</label>
                    <input type="file" class="form-control" id="imagem" name="imagem" required disabled>
                </div>

                <div class="col-md-6">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select" required disabled>
                        <option value="1">Ativo</option>
                        <option value="2">Inativo</option>
                    </select>
                </div>

                <div class="col-md-12 d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" id="btn_add"><i class="fa fa-save me-2"
                            aria-hidden="true"></i>Salvar</button>
                </div>

            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('#btn_add').hide();

            $('#btn_edita').on('click', function() {
                $('#nome').prop('disabled', false);
                $('#capacidade').prop('disabled', false);
                $('#largura').prop('disabled', false);
                $('#comprimento').prop('disabled', false);
                $('#descricao').prop('disabled', false);
                $('#imagem').prop('disabled', false);
                $('#status').prop('disabled', false);
                $('#btn_add').show();
            })

            $('#btn_add').on('click', function() {
                let nome = $('#nome').val();
                let capacidade = $('#capacidade').val();
                let largura = $('#largura').val();
                let comprimento = $('#comprimento').val();
                let descricao = $('#descricao').val();
                let imagem = $('#imagem').prop('files')[0];
                let status = $('#status').val();
                var loading;

                if (imagem) {
                    if (imagem.type != 'image/png' && imagem.type != 'image/jpeg' && imagem.type !=
                        'image/jpg') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Formato de imagem inválido!',
                            confirmButtonColor: '#3085d6',
                        })
                        return false;
                    }
                }


                if (nome == '' || capacidade == '' || largura == '' || comprimento == '' || descricao ==
                    '' || status == '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Preencha todos os campos!',
                        confirmButtonColor: '#3085d6',
                    })
                } else {

                    let form = new FormData();
                    form.append('nome', nome);
                    form.append('capacidade', capacidade);
                    form.append('largura', largura);
                    form.append('comprimento', comprimento);
                    form.append('descricao', descricao);
                    form.append('imagem', $('#imagem')[0].files[0]);
                    form.append('status', status);

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('salas.atualizar', '') }}/{{$sala->id}}',
                        data: form,
                        contentType: false,
                        processData: false,
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

                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso!',
                                text: data.msg,
                                confirmButtonColor: '#3085d6',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href =
                                        "{{ route('salas.index') }}";
                                }
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
                    });
                }
            })



        });
    </script>
@endpush
