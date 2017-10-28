<?php

namespace App\Http\Controllers;

use App\Cidade;
use App\Http\Requests\CidadeRequest;
use App\Log;
use App\Paciente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CidadesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $cidades = Cidade::paginate(15);
        return view('cidades.index', ['cidades'=>$cidades]);
    }

    public function create(){
        return view('cidades.create');
    }

    public function store(CidadeRequest $request){
        $novo_cidade = $request->all();
        Cidade::create($novo_cidade);
        Log::create(['usuario'=>Auth::user()->nome, 'email'=>Auth::user()->email, 'acao'=>'create', 'descricao'=>$request->nome, 'tabela'=>'cidade']);

        flash('Cidade incluída com sucesso!')->success();
        return redirect()->route('cidades');
    }

    public function destroy($id){
        if(Paciente::where('cidade_id', '=', $id)->count() == 0){
            $cidade = Cidade::where('id', '=',$id)->get();
            Log::create(['usuario'=>Auth::user()->nome, 'email'=>Auth::user()->email, 'acao'=>'delete', 'descricao'=>$cidade->first()->nome, 'tabela'=>'cidade']);
            Cidade::find($id)->delete();
            flash('Cidade excluída com sucesso!')->success();
        } else {
            flash('Cidade não pode ser excluída! A mesma possui relacionamentos ativos.')->error();
        }
        return redirect()->route('cidades');
    }

    public function edit($id){
        $cidade = Cidade::find($id);
        return view('cidades.edit', compact('cidade'));
    }

    public function update(CidadeRequest $request, $id){
        $cidade = Cidade::find($id)->update($request->all());
        Log::create(['usuario'=>Auth::user()->nome, 'email'=>Auth::user()->email, 'acao'=>'update', 'descricao'=>$request->nome, 'tabela'=>'cidade']);
        flash('Cidade editada com sucesso!')->success();
        return redirect()->route('cidades');
    }
}
