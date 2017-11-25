<?php

namespace App\Http\Controllers;

use App\Agendamento;
use App\Atendimento;
use App\Http\Requests\DashboardsRequest;
use App\Procedimento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class dashboardsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        $datainicial = new \DateTime('-1 month');
        $datainicial->format('Y-m-d');
        $datafinal = new \DateTime('+1 day');
        $datafinal->format('Y-m-d');

        $datafinalview = new \DateTime();
        $datafinalview->format('Y-m-d');

        $atende = DB::table('recepcionista_atendes')
            ->join('usuarios', 'recepcionista_atendes.profissionalsaude_id', '=', 'usuarios.id')
            ->where('recepcionista_atendes.recepcionista_id', '=', Auth::user()->id)
            ->select('usuarios.id');

        if(Auth::user()->tipoUsuario == 'Recepcionista'){

            $profissional = 972382;

            $agendados = Agendamento::orWhere('status', '=', 'Agendado')
                ->orWhere('status', '=', 'Confirmado')
                ->orWhere('status', '=', 'Aguardando atendimento')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->whereIn('usuario_id', $atende)
                ->count();

            $confirmados = Agendamento::where('status', '=', 'Confirmado')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->whereIn('usuario_id', $atende)
                ->count();

            $atendidos = Agendamento::where('status', '=', 'Atendido')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->whereIn('usuario_id', $atende)
                ->count();

            $naocompareceu = Agendamento::where('status', '=', 'Não compareceu')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->whereIn('usuario_id', $atende)
                ->count();

            $duracao = DB::table('atendimentos')->join('agendamentos', 'atendimentos.agendamento_id', '=', 'agendamentos.id')
                ->whereBetween('agendamentos.data', array($datainicial, $datafinal))
                ->whereIn('agendamentos.usuario_id', $atende)
                ->select(DB::raw('AVG(atendimentos."duracaoAtendimento") as duracao'))
                ->first();

            $particular = Agendamento::where('convenio', '=', 'Particular')
                ->where('status', '=', 'Atendido')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->whereIn('usuario_id', $atende)
                ->count('*');

            $convenio = Agendamento::where('convenio', '!=', 'Particular')
                ->where('status', '=', 'Atendido')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->whereIn('usuario_id', $atende)
                ->count('*');

            $homens = DB::table('agendamentos')
                ->join('pacientes', 'agendamentos.paciente_id', '=', 'pacientes.id')
                ->where('pacientes.sexo', '=', 'Masculino')
                ->where('agendamentos.status', '=', 'Atendido')
                ->whereBetween('agendamentos.data', array($datainicial, $datafinal))
                ->whereIn('agendamentos.usuario_id', $atende)->count('*');

            $mulheres = DB::table('agendamentos')
                ->join('pacientes', 'agendamentos.paciente_id', '=', 'pacientes.id')
                ->where('pacientes.sexo', '=', 'Feminino')
                ->where('agendamentos.status', '=', 'Atendido')
                ->whereBetween('agendamentos.data', array($datainicial, $datafinal))
                ->whereIn('agendamentos.usuario_id', $atende)->count('*');

        } elseif (Auth::user()->tipoUsuario == 'Profissional da Saúde' && Auth::user()->flagAdmin == false){

            $profissional = Auth::user()->id;

            $agendados = Agendamento::where('status', '=', 'Agendado')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->where('usuario_id', '=', $profissional)
                ->count();
            $agendados += Agendamento::where('status', '=', 'Confirmado')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->where('usuario_id', '=', $profissional)
                ->count();
            $agendados += Agendamento::where('status', '=', 'Aguardando atendimento')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->where('usuario_id', '=', $profissional)
                ->count();

            $confirmados = Agendamento::where('status', '=', 'Confirmado')
                ->where('usuario_id', '=', $profissional)
                ->whereBetween('data', array($datainicial, $datafinal))
                ->count();

            $atendidos = Agendamento::where('status', '=', 'Atendido')
                ->where('usuario_id', '=', $profissional)
                ->whereBetween('data', array($datainicial, $datafinal))
                ->count();

            $naocompareceu = Agendamento::where('status', '=', 'Não compareceu')
                ->where('usuario_id', '=', $profissional)
                ->whereBetween('data', array($datainicial, $datafinal))
                ->count();

            $duracao = DB::table('atendimentos')->join('agendamentos', 'atendimentos.agendamento_id', '=', 'agendamentos.id')
                ->whereBetween('agendamentos.data', array($datainicial, $datafinal))
                ->where('agendamentos.usuario_id', '=', $profissional)
                ->select(DB::raw('AVG(atendimentos."duracaoAtendimento") as duracao'))
                ->first();

            $particular = Agendamento::where('convenio', '=', 'Particular')
                ->where('usuario_id', '=', $profissional)
                ->where('status', '=', 'Atendido')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->count('*');

            $convenio = Agendamento::where('convenio', '!=', 'Particular')
                ->where('usuario_id', '=', $profissional)
                ->where('status', '=', 'Atendido')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->count('*');

            $homens = DB::table('agendamentos')
                ->join('pacientes', 'agendamentos.paciente_id', '=', 'pacientes.id')
                ->where('pacientes.sexo', '=', 'Masculino')
                ->where('agendamentos.status', '=', 'Atendido')
                ->whereBetween('agendamentos.data', array($datainicial, $datafinal))
                ->where('agendamentos.usuario_id', '=', $profissional)->count('*');

            $mulheres = DB::table('agendamentos')
                ->join('pacientes', 'agendamentos.paciente_id', '=', 'pacientes.id')
                ->where('pacientes.sexo', '=', 'Feminino')
                ->where('agendamentos.status', '=', 'Atendido')
                ->whereBetween('agendamentos.data', array($datainicial, $datafinal))
                ->where('agendamentos.usuario_id', '=', $profissional)->count('*');

        } else {

            $profissional = 0;

            $agendados = Agendamento::orWhere('status', '=', 'Agendado')
                ->orWhere('status', '=', 'Confirmado')
                ->orWhere('status', '=', 'Aguardando atendimento')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->count();

            $confirmados = Agendamento::where('status', '=', 'Confirmado')
                ->whereBetween('data', array($datainicial, $datafinal))->count();

            $atendidos = Agendamento::where('status', '=', 'Atendido')
                ->whereBetween('data', array($datainicial, $datafinal))->count();

            $naocompareceu = Agendamento::where('status', '=', 'Não compareceu')
                ->whereBetween('data', array($datainicial, $datafinal))->count();

            $duracao = DB::table('atendimentos')
                ->join('agendamentos', 'atendimentos.agendamento_id', '=', 'agendamentos.id')
                ->whereBetween('agendamentos.data', array($datainicial, $datafinal))
                ->select(DB::raw('AVG(atendimentos."duracaoAtendimento") as duracao'))
                ->first();

            $particular = Agendamento::where('convenio', '=', 'Particular')
                ->where('status', '=', 'Atendido')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->count('*');

            $convenio = Agendamento::where('convenio', '!=', 'Particular')
                ->where('status', '=', 'Atendido')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->count('*');

            $homens = DB::table('agendamentos')
                ->join('pacientes', 'agendamentos.paciente_id', '=', 'pacientes.id')
                ->where('pacientes.sexo', '=', 'Masculino')
                ->where('agendamentos.status', '=', 'Atendido')
                ->whereBetween('agendamentos.data', array($datainicial, $datafinal))
                ->count('*');

            $mulheres = DB::table('agendamentos')
                ->join('pacientes', 'agendamentos.paciente_id', '=', 'pacientes.id')
                ->where('pacientes.sexo', '=', 'Feminino')
                ->where('agendamentos.status', '=', 'Atendido')
                ->whereBetween('agendamentos.data', array($datainicial, $datafinal))
                ->count('*');
        }

        return view('dashboard.index',
            [
                'profissional'=>$profissional,
                'particular'=>$particular,
                'convenio'=>$convenio,
                'agendados'=>$agendados,
                'confirmados'=>$confirmados,
                'naocompareceu'=>$naocompareceu,
                'duracao'=>$duracao,
                'atendidos'=>$atendidos,
                'datainicial'=>$datainicial,
                'datafinal'=>$datafinalview,
                'homens'=>$homens,
                'mulheres'=>$mulheres
            ]
        );
    }

    public function search(DashboardsRequest $request){
        return redirect()->route('dashboard.result',
            [
                'datainicial'=>$request->datainicial,
                'datafinal'=>$request->datafinal,
                'profissional'=>$request->profissional
            ]
        );
    }

    public function result($datainicial, $datafinal, $profissional){

        $atende = DB::table('recepcionista_atendes')
            ->join('usuarios', 'recepcionista_atendes.profissionalsaude_id', '=', 'usuarios.id')
            ->where('recepcionista_atendes.recepcionista_id', '=', Auth::user()->id)
            ->select('usuarios.id');

        if($profissional == 0){

            $agendados = Agendamento::orWhere('status', '=', 'Agendado')
                ->orWhere('status', '=', 'Confirmado')
                ->orWhere('status', '=', 'Aguardando atendimento')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->count();

            $confirmados = Agendamento::where('status', '=', 'Confirmado')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->count();

            $atendidos = Agendamento::where('status', '=', 'Atendido')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->count();

            $naocompareceu = Agendamento::where('status', '=', 'Não compareceu')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->count();

            $duracao = DB::table('atendimentos')
                ->join('agendamentos', 'atendimentos.agendamento_id', '=', 'agendamentos.id')
                ->whereBetween('agendamentos.data', array($datainicial, $datafinal))
                ->select(DB::raw('AVG(atendimentos."duracaoAtendimento") as duracao'))
                ->first();

            $particular = Agendamento::where('convenio', '=', 'Particular')
                ->where('status', '=', 'Atendido')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->count('*');

            $convenio = Agendamento::where('convenio', '!=', 'Particular')
                ->where('status', '=', 'Atendido')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->count('*');

            $homens = DB::table('agendamentos')
                ->join('pacientes', 'agendamentos.paciente_id', '=', 'pacientes.id')
                ->where('pacientes.sexo', '=', 'Masculino')
                ->where('agendamentos.status', '=', 'Atendido')
                ->whereBetween('agendamentos.data', array($datainicial, $datafinal))
                ->count('*');

            $mulheres = DB::table('agendamentos')
                ->join('pacientes', 'agendamentos.paciente_id', '=', 'pacientes.id')
                ->where('pacientes.sexo', '=', 'Feminino')
                ->where('agendamentos.status', '=', 'Atendido')
                ->whereBetween('agendamentos.data', array($datainicial, $datafinal))
                ->count('*');

        } elseif ($profissional == 972382) {

            $agendados = Agendamento::where('status', '=', 'Agendado')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->whereIn('usuario_id', $atende)
                ->count();

            $agendados += Agendamento::where('status', '=', 'Confirmado')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->whereIn('usuario_id', $atende)
                ->count();

            $agendados += Agendamento::where('status', '=', 'Aguardando atendimento')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->whereIn('usuario_id', $atende)
                ->count();

            $confirmados = Agendamento::where('status', '=', 'Confirmado')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->whereIn('usuario_id', $atende)
                ->count();

            $atendidos = Agendamento::where('status', '=', 'Atendido')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->whereIn('usuario_id', $atende)
                ->count();

            $naocompareceu = Agendamento::where('status', '=', 'Não compareceu')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->whereIn('usuario_id', $atende)
                ->count();

            $duracao = DB::table('atendimentos')
                ->join('agendamentos', 'atendimentos.agendamento_id', '=', 'agendamentos.id')
                ->whereBetween('agendamentos.data', array($datainicial, $datafinal))
                ->whereIn('agendamentos.usuario_id', $atende)
                ->select(DB::raw('AVG(atendimentos."duracaoAtendimento") as duracao'))
                ->first();

            $particular = Agendamento::where('convenio', '=', 'Particular')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->where('status', '=', 'Atendido')
                ->whereIn('usuario_id', $atende)
                ->count('*');

            $convenio = Agendamento::where('convenio', '!=', 'Particular')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->where('status', '=', 'Atendido')
                ->whereIn('usuario_id', $atende)
                ->count('*');

            $homens = DB::table('agendamentos')
                ->join('pacientes', 'agendamentos.paciente_id', '=', 'pacientes.id')
                ->where('pacientes.sexo', '=', 'Masculino')
                ->where('agendamentos.status', '=', 'Atendido')
                ->whereBetween('agendamentos.data', array($datainicial, $datafinal))
                ->whereIn('agendamentos.usuario_id', $atende)->count('*');

            $mulheres = DB::table('agendamentos')
                ->join('pacientes', 'agendamentos.paciente_id', '=', 'pacientes.id')
                ->where('pacientes.sexo', '=', 'Feminino')
                ->where('agendamentos.status', '=', 'Atendido')
                ->whereBetween('agendamentos.data', array($datainicial, $datafinal))
                ->whereIn('agendamentos.usuario_id', $atende)->count('*');

        } else {

            $agendados = Agendamento::where('status', '=', 'Agendado')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->where('usuario_id', '=', $profissional)
                ->count();
            $agendados += Agendamento::where('status', '=', 'Confirmado')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->where('usuario_id', '=', $profissional)
                ->count();
            $agendados += Agendamento::where('status', '=', 'Aguardando atendimento')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->where('usuario_id', '=', $profissional)
                ->count();

            $confirmados = Agendamento::where('status', '=', 'Confirmado')
                ->where('usuario_id', '=', $profissional)
                ->whereBetween('data', array($datainicial, $datafinal))
                ->count();

            $atendidos = Agendamento::where('status', '=', 'Atendido')
                ->where('usuario_id', '=', $profissional)
                ->whereBetween('data', array($datainicial, $datafinal))
                ->count();

            $naocompareceu = Agendamento::where('status', '=', 'Não compareceu')
                ->where('usuario_id', '=', $profissional)
                ->whereBetween('data', array($datainicial, $datafinal))
                ->count();

            $duracao = DB::table('atendimentos')->join('agendamentos', 'atendimentos.agendamento_id', '=', 'agendamentos.id')
                ->whereBetween('agendamentos.data', array($datainicial, $datafinal))
                ->where('agendamentos.usuario_id', '=', $profissional)
                ->select(DB::raw('AVG(atendimentos."duracaoAtendimento") as duracao'))
                ->first();

            $particular = Agendamento::where('convenio', '=', 'Particular')
                ->where('usuario_id', '=', $profissional)
                ->where('status', '=', 'Atendido')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->count('*');

            $convenio = Agendamento::where('convenio', '!=', 'Particular')
                ->where('usuario_id', '=', $profissional)
                ->where('status', '=', 'Atendido')
                ->whereBetween('data', array($datainicial, $datafinal))
                ->count('*');

            $homens = DB::table('agendamentos')
                ->join('pacientes', 'agendamentos.paciente_id', '=', 'pacientes.id')
                ->where('pacientes.sexo', '=', 'Masculino')
                ->where('agendamentos.status', '=', 'Atendido')
                ->whereBetween('agendamentos.data', array($datainicial, $datafinal))
                ->where('agendamentos.usuario_id', '=', $profissional)->count('*');

            $mulheres = DB::table('agendamentos')
                ->join('pacientes', 'agendamentos.paciente_id', '=', 'pacientes.id')
                ->where('pacientes.sexo', '=', 'Feminino')
                ->where('agendamentos.status', '=', 'Atendido')
                ->whereBetween('agendamentos.data', array($datainicial, $datafinal))
                ->where('agendamentos.usuario_id', '=', $profissional)->count('*');
        }

        return view('dashboard.index',
            [
                'profissional'=>$profissional,
                'particular'=>$particular,
                'convenio'=>$convenio,
                'agendados'=>$agendados,
                'confirmados'=>$confirmados,
                'naocompareceu'=>$naocompareceu,
                'duracao'=>$duracao,
                'atendidos'=>$atendidos,
                'datainicial'=>$datainicial,
                'datafinal'=>$datafinal,
                'homens'=>$homens,
                'mulheres'=>$mulheres
            ]
        );

    }

}
