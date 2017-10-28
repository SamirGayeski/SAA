<?php

namespace App\Http\Controllers;

use App\Atendimento;
use App\Agendamento;
use App\ExameFisico;
use App\HipoteseDiagnostica;
use App\Anamnese;
use App\Http\Requests\ExameFisicoRequest;
use App\Log;
use App\Usuario;
use Illuminate\Http\Request;
use App\Http\Requests\AtendimentoRequest;
use App\Http\Requests\HipoteseDiagnosticaRequest;
use App\Http\Requests\AnamneseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AtendimentosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create($id){
        $agendamento = Agendamento::find($id);
        $historicos = DB::table('atendimentos')
                        ->join('agendamentos', 'atendimentos.agendamento_id', '=', 'agendamentos.id')
                        ->join('pacientes', 'agendamentos.paciente_id', '=', 'pacientes.id')
                        ->join('hipotese_diagnosticas', 'hipotese_diagnosticas.atendimento_id', '=', 'atendimentos.id')
                        ->join('anamnese', 'anamnese.atendimento_id', '=', 'atendimentos.id')
                        ->join('exame_fisicos', 'exame_fisicos.atendimento_id', '=', 'atendimentos.id')
                        ->join('usuarios', 'agendamentos.usuario_id', '=', 'usuarios.id')
                        ->where('pacientes.id', '=', $agendamento->paciente_id)
                        ->where('agendamentos.data', '<', $agendamento->data)
                        ->orderBy('agendamentos.data', 'desc')
                        ->select('atendimentos.*', 'hipotese_diagnosticas.*', 'anamnese.*', 'exame_fisicos.*', 'agendamentos.*', 'usuarios.nome')
                        ->get();
        return view('atendimentos.create', compact('agendamento'), compact('historicos'));
    }

    public function store(AtendimentoRequest $request_atendimento, AnamneseRequest $request_anamnese, ExameFisicoRequest $request_examefisico, HipoteseDiagnosticaRequest $request_hipotese){
        $novo_atendimento = $request_atendimento->all();
        $atendimento = Atendimento::create($novo_atendimento);

        $usuario = DB::table('atendimentos')
            ->join('agendamentos', 'atendimentos.agendamento_id', '=', 'agendamentos.id')
            ->join('usuarios', 'agendamentos.usuario_id', '=', 'usuarios.id')
            ->where('atendimentos.id', '=', $atendimento->id)
            ->select('usuarios.nome')->get();
        Log::create(['usuario'=>Auth::user()->nome, 'email'=>Auth::user()->email, 'acao'=>'create', 'descricao'=>$usuario->first()->nome, 'tabela'=>'atendimento']);

        Anamnese::create([
            'queixaPrincipal'=>$request_anamnese->queixaPrincipal,
            'historia'=>$request_anamnese->historia,
            'problemasRenais'=>$request_anamnese->problemasRenais,
            'problemasArticulares'=>$request_anamnese->problemasArticulares,
            'problemasCardiacos'=>$request_anamnese->problemasCardiacos,
            'problemasRespiratorios'=>$request_anamnese->problemasRespiratorios,
            'problemasGastricos'=>$request_anamnese->problemasGastricos,
            'alergias'=>$request_anamnese->alergias,
            'hepatite'=>$request_anamnese->hepatite,
            'gravidez'=>$request_anamnese->gravidez,
            'diabetes'=>$request_anamnese->diabetes,
            'usoMedicamento'=>$request_anamnese->usoMedicamento,
            'atendimento_id'=>$atendimento->id
        ]);
        Log::create(['usuario'=>Auth::user()->nome, 'email'=>Auth::user()->email, 'acao'=>'create', 'descricao'=>$usuario->first()->nome, 'tabela'=>'anamnese']);

        ExameFisico::create([
            'altura'=>$request_examefisico->altura,
            'peso'=>$request_examefisico->peso,
            'frenquenciaCardiaca'=>$request_examefisico->frenquenciaCardiaca,
            'pressaoSistolica'=>$request_examefisico->pressaoSistolica,
            'pressaoDiastolica'=>$request_examefisico->pressaoDiastolica,
            'observacoesGerais'=>$request_examefisico->observacoesGerais,
            'atendimento_id'=>$atendimento->id
        ]);
        Log::create(['usuario'=>Auth::user()->nome, 'email'=>Auth::user()->email, 'acao'=>'create', 'descricao'=>$usuario->first()->nome, 'tabela'=>'exame físico']);

        HipoteseDiagnostica::create([
            'diagnostico'=>$request_hipotese->diagnostico,
            'observacoes'=>$request_hipotese->observacoes,
            'atendimento_id'=>$atendimento->id
        ]);
        Log::create(['usuario'=>Auth::user()->nome, 'email'=>Auth::user()->email, 'acao'=>'create', 'descricao'=>$usuario->first()->nome, 'tabela'=>'hipótese diagnóstica']);

        flash('Atendimento finalizado com sucesso!')->success();
        return redirect()->route('agendamentos');
    }

    public function edit($id){
        $agendamento = Agendamento::find($id);
        $historicos = DB::table('atendimentos')
            ->join('agendamentos', 'atendimentos.agendamento_id', '=', 'agendamentos.id')
            ->join('pacientes', 'agendamentos.paciente_id', '=', 'pacientes.id')
            ->join('hipotese_diagnosticas', 'hipotese_diagnosticas.atendimento_id', '=', 'atendimentos.id')
            ->join('anamnese', 'anamnese.atendimento_id', '=', 'atendimentos.id')
            ->join('exame_fisicos', 'exame_fisicos.atendimento_id', '=', 'atendimentos.id')
            ->join('usuarios', 'agendamentos.usuario_id', '=', 'usuarios.id')
            ->where('pacientes.id', '=', $agendamento->paciente_id)
            ->where('agendamentos.data', '<', $agendamento->data)
            ->orderBy('agendamentos.data', 'desc')
            ->select('atendimentos.*', 'hipotese_diagnosticas.*', 'anamnese.*', 'exame_fisicos.*', 'agendamentos.*', 'usuarios.nome')
            ->get();
        return view('atendimentos.edit', compact('agendamento'), compact('historicos'));
    }

    public function update(AtendimentoRequest $request_atendimento, HipoteseDiagnosticaRequest $request_hipotese, AnamneseRequest $request_anamnese, ExameFisicoRequest $request_examefisico, $id){
        $atendimento = Atendimento::find($id)->update($request_atendimento->all());

        $usuario = DB::table('atendimentos')
            ->join('agendamentos', 'atendimentos.agendamento_id', '=', 'agendamentos.id')
            ->join('usuarios', 'agendamentos.usuario_id', '=', 'usuarios.id')
            ->where('atendimentos.id', '=', $id)
            ->select('usuarios.nome')->get();
        Log::create(['usuario'=>Auth::user()->nome, 'email'=>Auth::user()->email, 'acao'=>'update', 'descricao'=>$usuario->first()->nome, 'tabela'=>'atendimento']);

        $anamnese_id = Anamnese::where('atendimento_id', '=', $id)->select('id');
        $anamnese = Anamnese::find($anamnese_id->first()->id)->update($request_anamnese->all());
        Log::create(['usuario'=>Auth::user()->nome, 'email'=>Auth::user()->email, 'acao'=>'update', 'descricao'=>$usuario->first()->nome, 'tabela'=>'anamnese']);

        $hipotesediagnostica_id = HipoteseDiagnostica::where('atendimento_id', '=', $id)->select('id');
        $hipotesediagnostica = HipoteseDiagnostica::find($hipotesediagnostica_id->first()->id)->update($request_hipotese->all());
        Log::create(['usuario'=>Auth::user()->nome, 'email'=>Auth::user()->email, 'acao'=>'update', 'descricao'=>$usuario->first()->nome, 'tabela'=>'hipótese diagnóstica']);

        $examefisico_id = ExameFisico::where('atendimento_id', '=', $id)->select('id');
        $examefisico= ExameFisico::find($examefisico_id->first()->id)->update($request_examefisico->all());
        Log::create(['usuario'=>Auth::user()->nome, 'email'=>Auth::user()->email, 'acao'=>'update', 'descricao'=>$usuario->first()->nome, 'tabela'=>'exame físico']);

        flash('Atendimento editado com sucesso!')->success();
        return redirect()->route('agendamentos');
    }
}
