<?php

namespace App\Http\Controllers;

use App\Http\Requests\HistoricoRequest;
use App\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoricosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('historicos.index');
    }

    public function search(HistoricoRequest $request){
        $paciente = Paciente::where('id', '=', $request->paciente)->get();
        $historicos = DB::table('atendimentos')
            ->join('agendamentos', 'atendimentos.agendamento_id', '=', 'agendamentos.id')
            ->join('pacientes', 'agendamentos.paciente_id', '=', 'pacientes.id')
            ->join('hipotese_diagnosticas', 'hipotese_diagnosticas.atendimento_id', '=', 'atendimentos.id')
            ->join('anamnese', 'anamnese.atendimento_id', '=', 'atendimentos.id')
            ->join('exame_fisicos', 'exame_fisicos.atendimento_id', '=', 'atendimentos.id')
            ->join('usuarios', 'agendamentos.usuario_id', '=', 'usuarios.id')
            ->where('pacientes.id', '=', $request->paciente)
            ->orderBy('agendamentos.data', 'desc')
            ->select('atendimentos.*', 'hipotese_diagnosticas.*', 'anamnese.*', 'exame_fisicos.*', 'agendamentos.*', 'usuarios.nome')
            ->get();

        return view('historicos.historic', compact('historicos'), compact('paciente'));
    }
}
