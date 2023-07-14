<?php

namespace App\Http\Controllers;

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
}
