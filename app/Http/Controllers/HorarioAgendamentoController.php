<?php

namespace App\Http\Controllers;

use App\Models\DataHorario;
use App\Models\HorarioAgendamento;
use App\Models\Sala;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HorarioAgendamentoController extends Controller
{
    public function index()
    {
        return view('horarios.index');
    }

    public function cadastrar()
    {
        $salas = Sala::all();
        return view('horarios.cadastrar', compact('salas'));
    }

    public function salvar(Request $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();

            $verifica_data = DataHorario::whereDate('data', $request->data)
                ->where('id_sala', $request->sala)
                ->first();
            if($verifica_data){
                throw new \Exception('Já existem horários para essa data!');
            }

            $data_horario = DataHorario::create([
                'id_usuario_criacao' => auth()->user()->id,
                'data' => $request->data,
                'id_sala' => $request->sala,
            ]);

            //criar horarios
            $horarios = $request->horarios;
            foreach ($horarios as $horario) {
                HorarioAgendamento::create([
                    'id_usuario_criacao' => auth()->user()->id,

                    'id_data_horario' => $data_horario->id,
                    'horario_inicio' => $horario['horario_inicial'],
                    'horario_fim' => $horario['horario_final'],
                ]);
            }



            DB::commit();

            return response()->json(['msg' => 'Horário cadastrado com sucesso!'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['msg' => $e->getMessage()], 500);
        }
    }

    public function consultaData(Request $request)
    {

        try{
            $data_horario = DataHorario::where('id_sala', $request->sala)
            ->where('status_datas_horarios', '1')
            ->where('data', '>=', date('Y-m-d'))
            ->with('horarios', function($query){
                $query->where('status_horarios_agendamentos', '1');
            })
            ->get();

            


            if(!$data_horario){
                throw new \Exception('Nenhuma data encontrada!');
            }

            return response()->json(['datas' => $data_horario], 200);
        }catch(\Exception $e){
            return response()->json(['msg' => $e->getMessage()], 500);
        }





        // if ($data_horario) {
        //     $horarios = HorarioAgendamento::where('id_data_horario', $data_horario->id)->get();
        //     return response()->json(['horarios' => $horarios], 200);
        // } else {
        //     return response()->json(['horarios' => []], 200);
        // }
    }
}
