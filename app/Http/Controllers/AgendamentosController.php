<?php

namespace App\Http\Controllers;

use App\Log;
use App\Usuario;
use Illuminate\Http\Request;
use App\Http\Requests\AgendamentoRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use MaddHatter\LaravelFullcalendar\Calendar;
use App\Agendamento;
use App\Http\Controllers\Controller;

class AgendamentosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $events = [];
        $data = Agendamento::all();
        if($data->count()){
            foreach ($data as $key => $value) {

                //minutos que serão acrescidos para time final do event
                $parse = date_parse($value->procedimento->duracao);
                $minutes = $parse['hour'] * 60 + $parse['minute'];

                //colors status
                if($value->status == 'Agendado'){
                    $status = '#58ACFA'; //azul
                }else if($value->status == 'Confirmado'){
                    $status = '#D8D8D8'; //cinza
                }else if($value->status == 'Cancelado'){
                    $status = '#FA5858'; //vermelho
                }else if($value->status == 'Aguardando atendimento'){
                    $status = '#F5A9F2'; //lilas
                }else if($value->status == 'Não compareceu'){
                    $status = '#F7BE81'; //laranja
                }else if($value->status == 'Atendido'){
                    $status = '#A9F5A9'; //verde
                }else if($value->status == 'Em andamento'){
                    $status = '#F4FA58'; //amarelo
                }

                //verifica status e muda route
                if($value->status == 'Atendido'){
                    $url = route('atendimentos.edit', ['id'=>$value->id]);
                } else {
                    $url = route('agendamentos.edit', ['id'=>$value->id]);
                }

                //array com as informaçõs do agendamento
                $events[] = Calendar::event(
                    $value->paciente->nome.' - '.$value->procedimento->descricao,
                    false,
                    new \DateTime($value->data.$value->horario),
                    new \DateTime($value->data.$value->horario.' +'.$minutes.' minute'),
                    $value->id,
                    ['color'=>$status, 'url'=>$url,'textColor'=>'#4f4f4f']
                );
            }
        }
        $calendar = \MaddHatter\LaravelFullcalendar\Facades\Calendar::addEvents($events);
        return view('agendamentos.index', compact('calendar'));
    }

    public function profissional($id){
        $events = [];
        if($id == 0){
            $data = Agendamento::all();
        } else {
            $data = Agendamento::where('usuario_id', '=', $id)->get();
            $profissional = DB::table('agendamentos')->join('usuarios', function ($join){$join->on('agendamentos.usuario_id', '=', 'usuarios.id');})
                                                     ->where('agendamentos.usuario_id','=', $id)->select('usuarios.nome')->get();
            if(isset($profissional)){
                $profissional = Usuario::where('id','=', $id);
            }
        }

        if($data->count()){
            foreach ($data as $key => $value) {

                //minutos que serão acrescidos para time final do event
                $parse = date_parse($value->procedimento->duracao);
                $minutes = $parse['hour'] * 60 + $parse['minute'];

                //colors status
                if($value->status == 'Agendado'){
                    $status = '#58ACFA'; //azul
                }else if($value->status == 'Confirmado'){
                    $status = '#D8D8D8'; //cinza
                }else if($value->status == 'Cancelado'){
                    $status = '#FA5858'; //vermelho
                }else if($value->status == 'Aguardando atendimento'){
                    $status = '#F5A9F2'; //lilas
                }else if($value->status == 'Não compareceu'){
                    $status = '#F7BE81'; //laranja
                }else if($value->status == 'Atendido'){
                    $status = '#A9F5A9'; //verde
                }else if($value->status == 'Em andamento'){
                    $status = '#F4FA58'; //amarelo
                }

                //verifica status e muda route
                if($value->status == 'Atendido'){
                    $url = route('atendimentos.edit', ['id'=>$value->id]);
                } else {
                    $url = route('agendamentos.edit', ['id'=>$value->id]);
                }

                //array com as informaçõs do agendamento
                $events[] = Calendar::event(
                    $value->paciente->nome.' - '.$value->procedimento->descricao,
                    false,
                    new \DateTime($value->data.$value->horario),
                    new \DateTime($value->data.$value->horario.' +'.$minutes.' minute'),
                    $value->id,
                    ['color'=>$status, 'url'=>$url,'textColor'=>'#4f4f4f']
                );
            }
        }
        $calendar = \MaddHatter\LaravelFullcalendar\Facades\Calendar::addEvents($events);
        return view('agendamentos.index', compact('calendar'), compact('profissional'));
    }

    public function create(){
        return view('agendamentos.create');
    }

    public function store(AgendamentoRequest $request){
        $novo_agendamento = $request->all();
        Agendamento::create($novo_agendamento);
        $usuario = Usuario::where('id','=', $request->usuario_id)->get();
        Log::create(['usuario'=>Auth::user()->nome, 'email'=>Auth::user()->email, 'acao'=>'create', 'descricao'=>$usuario->first()->nome, 'tabela'=>'agendamento']);

        flash('Agendamento incluído com sucesso!')->success();
        return redirect()->route('agendamentos');
    }

    public function edit($id){
        $agendamento = Agendamento::find($id);
        return view('agendamentos.edit', compact('agendamento'));
    }

    public function update(AgendamentoRequest $request, $id){
        $agendamento = Agendamento::find($id)->update($request->all());
        $usuario = Usuario::where('id','=', $request->usuario_id)->select('nome')->get();
        Log::create(['usuario'=>Auth::user()->nome, 'email'=>Auth::user()->email, 'acao'=>'update', 'descricao'=>$usuario->first()->nome, 'tabela'=>'agendamento']);

        flash('Agendamento editado com sucesso!')->success();
        return redirect()->route('agendamentos');
    }
}
