<?php

namespace App\Http\Controllers;

use App\Convenio;
use App\Http\Requests\PlanoRequest;
use App\Log;
use App\Paciente;
use App\Plano;
use App\Http\Requests\ConvenioRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        Log::create(['usuario'=>Auth::user()->nome, 'email'=>Auth::user()->email, 'acao'=>'create', 'descricao'=>$request->nome, 'tabela'=>'convênio']);
        if($request_plano->descricao != null){
            Plano::create(['descricao'=>$request_plano->descricao, 'convenio_id'=>$convenio->id]);
            Log::create(['usuario'=>Auth::user()->nome, 'email'=>Auth::user()->email, 'acao'=>'create', 'descricao'=>$request_plano->descricao, 'tabela'=>'plano']);
            return redirect()->route('convenios.edit', ['id'=>$convenio->id]);
        }
        flash('Convênio incluído com sucesso!')->success();
        return redirect()->route('convenios');
    }

    public function storeplano($id, PlanoRequest $request_plano){
         Plano::create(['descricao'=>$request_plano->descricao, 'convenio_id'=>$id]);
         Log::create(['usuario'=>Auth::user()->nome, 'email'=>Auth::user()->email, 'acao'=>'create', 'descricao'=>$request_plano->descricao, 'tabela'=>'plano']);
         flash('Plano incluído com sucesso!')->success();
         return redirect()->route('convenios.edit', ['id'=>$id]);
    }

    public function destroy($id){
        if(Paciente::where('convenio_id', '=', $id)->count() == 0){
            $convenio = Convenio::where('id', '=',$id)->get();
            Log::create(['usuario'=>Auth::user()->nome, 'email'=>Auth::user()->email, 'acao'=>'delete', 'descricao'=>$convenio->first()->nome, 'tabela'=>'convênio']);
            Convenio::find($id)->delete();
            flash('Convênio excluído com sucesso!')->success();
        } else {
            flash('Convênio não pode ser excluído! O mesmo possui relacionamentos ativos.')->error();
        }
        return redirect()->route ('convenios');
    }

    public function destroyplano($id, $id_convenio){
        if(Paciente::where('plano_id', '=', $id)->count() == 0){
            $plano = Plano::where('id', '=',$id)->get();
            Log::create(['usuario'=>Auth::user()->nome, 'email'=>Auth::user()->email, 'acao'=>'delete', 'descricao'=>$plano->first()->descricao, 'tabela'=>'plano']);
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
         Log::create(['usuario'=>Auth::user()->nome, 'email'=>Auth::user()->email, 'acao'=>'update', 'descricao'=>$request->nome, 'tabela'=>'convênio']);
         flash('Convênio editado com sucesso!')->success();
         return redirect()->route('convenios');
    }

    public function updateplano(PlanoRequest $request_plano, $id_convenio){
        $plano = Plano::find($request_plano->id)->update($request_plano->all());
        Log::create(['usuario'=>Auth::user()->nome, 'email'=>Auth::user()->email, 'acao'=>'update', 'descricao'=>$request_plano->descricao, 'tabela'=>'plano']);
        flash('Plano editado com sucesso!')->success();
        return redirect()->route('convenios.edit', ['id'=>$id_convenio]);
    }
}
