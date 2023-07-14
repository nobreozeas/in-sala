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

        <div class="row">
            <div class="col-md-4">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="busca" id="busca"
                        placeholder="Identificador, sequência inicial, sequência final" aria-label="Recipient's username"
                        aria-describedby="basic-addon2">
                    <span class="input-group-text" id="basic-addon2"><i class="fa-solid fa-magnifying-glass"></i></span>
                </div>
            </div>
            <div class="col-md-3">
                <select name="status" id="status" class="form-select">
                    <option value="">Situação</option>
                    <option value="1">Pago</option>
                    <option value="2">Pendente</option>
                    <option value="3">Cancelado</option>
                </select>
            </div>


            <div class="col-md-2">
                <button class="btn" id="limpa_filtro"><i class="fa-regular fa-filter me-2"></i>Limpar</button>
            </div>

        </div>

        <div>
            <table id="tabela_encomenda" class="table table-responsive table-striped">
                <thead>
                    <tr>
                        <th class="">#</th>
                        <th class="text-center">Cliente</th>
                        <th class="text-center">Documento</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Vencimento</th>
                        <th class="text-center">Situação</th>
                        <th class="text-center">Tipo de Pagamento</th>
                        <th class="text-center">Usuário</th>
                        <th class="text-center">Criação</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody></tbody>


            </table>
        </div>



    </div>
@endsection
@push('scripts')
@endpush
