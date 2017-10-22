<?php

namespace App\Http\Controllers;

use App\Convenio;
use App\Http\Requests\PlanoRequest;
use App\Paciente;
use App\Plano;
use App\Http\Requests\ConvenioRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConveniosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $convenios = Convenio::paginate(15);
        return view('convenios.index', ['convenios'=>$convenios]);
    }

    public function create(){
        return view('convenios.create');
    }

    public function store(ConvenioRequest $request, PlanoRequest $request_plano){
        $novo_convenio = $request->all();
        $convenio = Convenio::create($novo_convenio);
        if($request_plano->descricao != null){
            Plano::create(['descricao'=>$request_plano->descricao, 'convenio_id'=>$convenio->id]);
            return redirect()->route('convenios.edit', ['id'=>$convenio->id]);
        }
        flash('Convênio incluído com sucesso!')->success();
        return redirect()->route('convenios');
    }

    public function storeplano($id, PlanoRequest $request_plano){
         Plano::create(['descricao'=>$request_plano->descricao, 'convenio_id'=>$id]);
        flash('Plano incluído com sucesso!')->success();
         return redirect()->route('convenios.edit', ['id'=>$id]);
    }

    public function destroy($id){
        if(Paciente::where('convenio_id', '=', $id)->count() == 0){
            Convenio::find($id)->delete();
            flash('Convênio excluído com sucesso!')->success();
        } else {
            flash('Convênio não pode ser excluído! O mesmo possui relacionamentos ativos.')->error();
        }
        return redirect()->route ('convenios');
    }

    public function destroyplano($id, $id_convenio){
        if(Paciente::where('plano_id', '=', $id)->count() == 0){
            Plano::find($id)->delete();
            flash('Plano excluído com sucesso!')->success();
        } else {
            flash('Plano não pode ser excluído! O mesmo possui relacionamentos ativos.')->error();
        }
        return redirect()->route('convenios.edit', ['id'=>$id_convenio]);
    }

    public function edit($id){
        $convenio = Convenio::find($id);
        $planos = Plano::where('convenio_id', '=', $id)->get();
        return view('convenios.edit', compact('convenio'), ['planos'=>$planos]);

    }

    public function update(ConvenioRequest $request, $id){
         $convenio = Convenio::find($id)->update($request->all());
        flash('Convênio editado com sucesso!')->success();
         return redirect()->route('convenios');
    }

    public function updateplano(PlanoRequest $request_plano, $id_convenio){
        $plano = Plano::find($request_plano->id)->update($request_plano->all());
        flash('Plano editado com sucesso!')->success();
        return redirect()->route('convenios.edit', ['id'=>$id_convenio]);
    }
}
