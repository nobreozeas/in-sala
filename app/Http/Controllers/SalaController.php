<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\DataHorario;
use App\Models\HorarioAgendamento;
use App\Models\Sala;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalaController extends Controller
{
    public function index()
    {
        return view('salas.index');
    }

    public function cadastrar()
    {
        return view('salas.cadastrar');
    }

    public function salvar(Request $request)
    {

        try {
            DB::beginTransaction();
            $nome_arquivo = '';
            if ($request->hasFile('imagem')) {
                $arquivo = $request->file('imagem');
                //dar nome aleatorio com md5
                $nome_arquivo = md5($arquivo->getClientOriginalName() . strtotime("now")) . "." . $arquivo->getClientOriginalExtension();
                //salvar na pasta storage/app/public/arquivos
                $arquivo->storeAs('public/arquivos', $nome_arquivo);
            }

            $sala = Sala::create([
                'nome' => $request->nome,
                'descricao' => $request->descricao,
                'imagem' => $nome_arquivo,
                'capacidade' => $request->capacidade,
                'status_sala' => $request->status,
                'comprimento' => $request->comprimento,
                'largura' => $request->largura,
                'id_usuario_criacao' => auth()->user()->id,
            ]);

            DB::commit();

            return response()->json(['msg' => 'Sala cadastrada com sucesso!'], 200);


        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['msg' => $e->getMessage()], 500);
        }
    }

    public function listar(Request $request)
    {

        $salas = Sala::select('salas.*');



        $orders = [
            'id',
            'nome',
            '',
            '',
            '',
            '',
            '',
        ];

        $salas = $salas->orderBy($orders[$request->order[0]['column']], $request->order[0]['dir'])->paginate($request->length, ['*'], 'page', ($request->start / $request->length) + 1)->toArray();

        return ["draw" => $request->draw, "recordsTotal" => (int) $salas['to'], "recordsFiltered" => (int) $salas['total'], "data" => $salas["data"]];
    }

    public function editar($id)
    {
        $sala = Sala::find($id);
        return view('salas.editar', compact('sala'));
    }

    public function atualizar(Request $request, $id){

        try {
            DB::beginTransaction();
            $sala = Sala::find($id);
            if($request->imagem != "undefined"){
                $nome_arquivo = $sala->imagem;
            if ($request->hasFile('imagem')) {
                $arquivo = $request->file('imagem');
                //dar nome aleatorio com md5
                $nome_arquivo = md5($arquivo->getClientOriginalName() . strtotime("now")) . "." . $arquivo->getClientOriginalExtension();
                //salvar na pasta storage/app/public/arquivos
                $arquivo->storeAs('public/arquivos', $nome_arquivo);
            }
            }

            $sala->update([
                'nome' => $request->nome,
                'descricao' => $request->descricao,
                'imagem' => $nome_arquivo ?? $sala->imagem,
                'capacidade' => $request->capacidade,
                'status_sala' => $request->status,
                'comprimento' => $request->comprimento,
                'largura' => $request->largura,
                'id_usuario_alteracao' => auth()->user()->id,
            ]);

            DB::commit();

            return response()->json(['msg' => 'Sala atualizada com sucesso!'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['msg' => $e->getMessage()], 500);
        }


    }

    public function deletar($id){

        //verifica se a sala esta sendo usada em algum agendamento ou horario
        $agendamento = Agendamento::where('id_sala', $id)->first();
        if($agendamento){
            return response()->json(['msg' => 'Não é possível excluir essa sala, pois ela está sendo usada em um agendamento!'], 400);
        }

        $horario = DataHorario::where('id_sala', $id)->first();
        if($horario){
            return response()->json(['msg' => 'Não é possível excluir essa sala, pois ela está sendo usada em um horário!'], 400);
        }

        $sala = Sala::find($id);
        if(!$sala){
            return response()->json(['msg' => 'Sala não encontrada!'], 400);
        }

        $sala->delete();

        return response()->json(['msg' => 'Sala excluída com sucesso!'], 200);


    }
}
