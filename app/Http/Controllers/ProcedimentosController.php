<?php

namespace App\Http\Controllers;

use App\Agendamento;
use App\Procedimento;
use App\Http\Requests\ProcedimentoRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ProcedimentosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $procedimentos = Procedimento::paginate(15);
        return view('procedimentos.index', ['procedimentos'=>$procedimentos]);
    }

    public function create(){
        return view('procedimentos.create');
    }

    public function store(ProcedimentoRequest $request){
        $novo_procedimento = $request->all();
        Procedimento::create($novo_procedimento);

        flash('Procedimento incluído com sucesso!')->success();
        return redirect()->route('procedimentos');
    }

    public function destroy($id){
        if(Agendamento::where('procedimento_id', '=', $id)->count() == 0){
            Procedimento::find($id)->delete();
            flash('Procedimento excluído com sucesso!')->success();
        } else {
            flash('Procedimento não pode ser excluído! O mesmo possui relacionamentos ativos.')->error();
        }
        return redirect()->route('procedimentos');
    }

    public function edit($id){
        $procedimento = Procedimento::find($id);
        return view('procedimentos.edit', compact('procedimento'));
    }

    public function update(ProcedimentoRequest $request, $id){
        $procedimento = Procedimento::find($id)->update($request->all());
        flash('Procedimento editado com sucesso!')->success();
        return redirect()->route('procedimentos');
    }
}
