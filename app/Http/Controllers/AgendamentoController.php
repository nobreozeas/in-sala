<?php

namespace App\Http\Controllers;

use App\Models\Sala;
use Illuminate\Http\Request;

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
}
