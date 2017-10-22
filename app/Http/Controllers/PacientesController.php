<?php

namespace App\Http\Controllers;

use App\Agendamento;
use App\DadosFamiliar;
use App\Http\Requests\DadosFamiliarRequest;
use App\Paciente;
use App\Http\Requests\PacienteRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PacientesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    $pacientes = Paciente::paginate(15);
    return view('pacientes.index', ['pacientes'=>$pacientes]);
}

    public function search(){
        $pacientes = Paciente::where('nome', 'like', '%Mat%')->get();
        return view('pacientes.index', ['pacientes'=>$pacientes]);
    }

    public function create(){
        return view('pacientes.create');
    }

    public function store(PacienteRequest $request, DadosFamiliarRequest $request_dadosfamiliar){
        $novo_paciente = $request->all();
        $paciente = Paciente::create($novo_paciente);
        if($request_dadosfamiliar->nomeFamiliar != null){
            DadosFamiliar::create(['nome'=>$request_dadosfamiliar->nomeFamiliar, 'parentesco'=>$request_dadosfamiliar->parentesco, 'telefone'=>$request_dadosfamiliar->telefone, 'paciente_id'=>$paciente->id]);
            return redirect()->route('pacientes.edit', ['id'=>$paciente->id]);
        }

        flash('Paciente incluído com sucesso!')->success();
        return redirect()->route('pacientes');
    }

    public function storefamiliar($id, DadosFamiliarRequest $request_dadosfamiliar){
        DadosFamiliar::create(['nome'=>$request_dadosfamiliar->nomeFamiliar, 'parentesco'=>$request_dadosfamiliar->parentesco, 'telefone'=>$request_dadosfamiliar->telefone, 'paciente_id'=>$id]);
        flash('Familiar incluído com sucesso!')->success();
        return redirect()->route('pacientes.edit', ['id'=>$id]);
    }

    public function destroy($id){
        if(Agendamento::where('paciente_id', '=', $id)->count() == 0){
            Paciente::find($id)->delete();
            flash('Paciente excluído com sucesso!')->success();
        } else {
            flash('Paciente não pode ser excluído! O mesmo possui relacionamentos ativos.')->error();
        }
        return redirect()->route('pacientes');
    }

    public function destroyfamiliar($id, $id_paciente){
        DadosFamiliar::find($id)->delete();
        flash('Familiar excluído com sucesso!')->error();
        return redirect()->route('pacientes.edit', ['id'=>$id_paciente]);
    }

    public function edit($id){
        $paciente = Paciente::find($id);
        $dadosfamiliar = DadosFamiliar::where('paciente_id', '=', $id)->get();
        return view('pacientes.edit', compact('paciente'), ['dadosfamiliar'=>$dadosfamiliar]);
    }

    public function update(PacienteRequest $request, $id){
        $paciente = Paciente::find($id)->update($request->all());
        flash('Paciente editado com sucesso!')->success();
        return redirect()->route('pacientes');
    }

    public function updatefamiliar(DadosFamiliarRequest $request_dadosfamiliar, $id_paciente){
        $dadosfamiliar = DadosFamiliar::find($request_dadosfamiliar->id)->update($request_dadosfamiliar->all());
        flash('Familiar editado com sucesso!')->success();
        return redirect()->route('pacientes.edit', ['id'=>$id_paciente]);
    }
}
