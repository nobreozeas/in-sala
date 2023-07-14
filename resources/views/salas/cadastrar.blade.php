@extends('layout.app')
@section('content')
    <div class="container">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('salas.index') }}">Salas</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cadastrar Sala</li>
            </ol>
        </nav>

        <div class="box_form">
            <div class="d-flex justify-content-between">
                <div>
                    <h3>Cadastrar Sala</h3>
                </div>
                <div class="d-flex">
                    <a class="btn btn-secondary me-2" href="{{ route('salas.index') }}"><i class="fa fa-arrow-left me-2"
                            aria-hidden="true"></i>Voltar</a>

                </div>
            </div>
            <form class="row g-3" action="" enctype="multipart/form-data">
                @csrf
                <div class="col-md-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
                <div class="col-md-3">
                    <label for="capacidade" class="form-label">Capacidade</label>
                    <input type="number" class="form-control input-number" id="capacidade" name="capacidade" required>
                </div>
                <div class="col-md-3">
                    <label for="largura" class="form-label">Largura</label>
                    <input type="number" class="form-control input-number" id="largura" name="largura" required>
                </div>
                <div class="col-md-3">
                    <label for="comprimento" class="form-label">Comprimento</label>
                    <input type="number" class="form-control input-number" id="comprimento" name="comprimento" required>
                </div>

                <div class="col-md-12">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
                </div>

                <div class="col-md-6">
                    <label for="imagem" class="form-label">Imagem</label>
                    <input type="file" class="form-control" id="imagem" name="imagem" required>
                </div>

                <div class="col-md-6">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="1">Ativo</option>
                        <option value="2">Inativo</option>
                    </select>
                </div>

                <div class="col-md-12 d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" id="btn_add"><i class="fa fa-save me-2"
                            aria-hidden="true"></i>Cadastrar</button>
                </div>

            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

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
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Selecione uma imagem!',
                        confirmButtonColor: '#3085d6',
                    })
                    return false;

                }


                if (nome == '' || capacidade == '' || largura == '' || comprimento == '' || descricao ==
                    '' || imagem == '' || status == '') {
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
                        url: '{{ route('salas.salvar') }}',
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
                                text: 'Sala cadastrada com sucesso!',
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
