<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\DataHorario;
use App\Models\Sala;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgendamentoController extends Controller
{

    public function index()
    {
        return view('agendamentos.index');
    }

    public function cadastrar()
    {
        $salas = Sala::all();
        return view('agendamentos.cadastrar', compact('salas'));
    }

    public function salvar(Request $request)
    {
        try {
            DB::beginTransaction();
            $data_horario = DataHorario::whereDate('data', $request->data)->where('id_sala', $request->sala)->first();
            if (!$data_horario) {
                return response()->json(['msg' => 'Não existem horários para essa data!'], 400);
            }
            $horario = $data_horario->horarios()
                ->where('horario_inicio', $request->horario_inicio)
                ->where('horario_fim', $request->horario_fim)
                ->first();

            if (!$horario) {
                return response()->json(['msg' => 'Não existem horários para essa data!'], 400);
            }
            $horario->update([
                'status_horarios_agendamentos' => '2',
            ]);

            $agendamento = $horario->agendamentos()->create([
                'id_usuario_criacao' => auth()->user()->id,
                'id_data_horario' => $data_horario->id,
                'id_horario_agendamento' => $horario->id,
                'id_sala' => $data_horario->id_sala,
                'id_usuario' => auth()->user()->id,
                'status_agendamento' => '1',
            ]);

            DB::commit();

            return response()->json(['msg' => 'Agendamento cadastrado com sucesso!'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['msg' => 'Erro ao cadastrar agendamento!'], 500);
        }
    }

    public function visualizar($id)
    {
        try {
            $agendamento = Agendamento::with('sala')
                ->with('dataHorario')
                ->with('horarioAgendamento')
                ->with('usuarioCriacao')
                ->with('usuarioAlteracao')
                ->find($id);

            if (!$agendamento) {
                throw new \Exception('Agendamento não encontrado!');
            }

            return response()->json($agendamento, 200);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage() ], 500);
        }
    }

    public function listar(Request $request)
    {

        $agendamentos = Agendamento::with('sala')
            ->with('dataHorario')
            ->with('horarioAgendamento')
            ->with('usuarioCriacao')
            ->with('usuarioAlteracao')
            ->select('agendamentos.*');



        $orders = [
            'id',
            'id_sala',
            '',
            '',
            '',
            '',
            '',
            '',

        ];

        $agendamentos = $agendamentos->orderBy($orders[$request->order[0]['column']], $request->order[0]['dir'])->paginate($request->length, ['*'], 'page', ($request->start / $request->length) + 1)->toArray();

        return ["draw" => $request->draw, "recordsTotal" => (int) $agendamentos['to'], "recordsFiltered" => (int) $agendamentos['total'], "data" => $agendamentos["data"]];
    }

    public function cancelar(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $agendamento = Agendamento::find($id);
            if (!$agendamento) {
                throw new \Exception('Agendamento não encontrado!');
            }
            $agendamento->update([
                'status_agendamento' => '2',
                'motivo_cancelamento' => $request->motivo_cancelamento,

            ]);

            $horario = $agendamento->horarioAgendamento;
            $horario->update([
                'status_horarios_agendamentos' => '1',
            ]);

            DB::commit();

            return response()->json(['msg' => 'Agendamento cancelado com sucesso!'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['msg' => 'Erro ao cancelar agendamento!'], 500);
        }
    }
}
