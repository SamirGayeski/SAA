<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecepcionistaAtendeRequest;
use App\Log;
use App\RecepcionistaAtende;
use App\Usuario;
use Illuminate\Http\Request;

class UsuariosConfigController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id){
        $atende = RecepcionistaAtende::where('recepcionista_id', '=', $id)->select('profissionalsaude_id');
        $usuarios = Usuario::whereIn('id', $atende)->orderBy('tipoUsuario')->orderBy('nome')->get();
        $recepcionista = Usuario::where('id', '=', $id)->get()->first();
        return view('usuarios.indexconfig', ['usuarios'=>$usuarios, 'recepcionista'=>$recepcionista]);
    }

    public function storeconfig($id, RecepcionistaAtendeRequest $request){
        RecepcionistaAtende::create(['recepcionista_id'=>$id, 'profissionalsaude_id'=>$request->profissionalsaude_id]);
        flash('Profissional incluído com sucesso!')->success();
        return redirect()->route('usuarios.config', ['id'=>$id]);
    }

    public function destroyconfig($id_recepcionista, $id_profissional){
        $id = RecepcionistaAtende::where('recepcionista_id', '=', $id_recepcionista)->where('profissionalsaude_id', '=',$id_profissional)->first();
        RecepcionistaAtende::find($id->id)->delete();
        flash('Profissional foi excluído com sucesso!')->success();
        return redirect()->route('usuarios.config', ['id'=>$id_recepcionista]);
    }
}
