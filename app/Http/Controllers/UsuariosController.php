<?php

namespace App\Http\Controllers;

use App\Agendamento;
use App\Log;
use App\RecepcionistaAtende;
use App\Usuario;
use App\ProfissionalSaude;
use App\Http\Requests\UsuarioRequest;
use App\Http\Requests\ProfissionalSaudeRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UsuariosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $usuarios = Usuario::orderBy('tipoUsuario')->orderBy('nome')->paginate(15);
        return view('usuarios.index', ['usuarios'=>$usuarios]);
    }

    public function search(){
        $usuarios = Usuario::where('nome', 'like', '%Mat%')->get();
        return view('usuarios.index', ['usuarios'=>$usuarios]);
    }

    public function create(){
        return view('usuarios.create');
    }

    public function store(UsuarioRequest $request, ProfissionalSaudeRequest $request_pro){
        $novo_usuario = $request->all();
        $usuario = Usuario::create($novo_usuario);
        Log::create(['usuario'=>Auth::user()->nome, 'email'=>Auth::user()->email, 'acao'=>'create', 'descricao'=>$request->nome, 'tabela'=>'usuário']);
        if($usuario->tipoUsuario == 'Profissional da Saúde'){
            $conselho = $request_pro->conselho;
            $registroConselho = $request_pro->registroConselho;
            $especialidade = $request_pro->especialidade;
            $usuario_id = $usuario->id;
            ProfissionalSaude::create(['conselho'=>$conselho, 'registroConselho'=>$registroConselho, 'especialidade'=>$especialidade, 'usuario_id'=>$usuario_id]);
            Log::create(['usuario'=>Auth::user()->nome, 'email'=>Auth::user()->email, 'acao'=>'create', 'descricao'=>$request_pro->especialidade, 'tabela'=>'profissional da saúde']);
        }

        flash('Usuário incluído com sucesso!')->success();
        return redirect()->route('usuarios');
    }

    public function destroy($id){
        if(Agendamento::where('usuario_id', '=', $id)->count() == 0 && RecepcionistaAtende::where('recepcionista_id', '=', $id)->count() == 0){
            $usuario = Usuario::where('id', '=',$id)->get();
            Log::create(['usuario'=>Auth::user()->nome, 'email'=>Auth::user()->email, 'acao'=>'delete', 'descricao'=>$usuario->first()->nome, 'tabela'=>'profissional da saúde']);
            Usuario::find($id)->delete();
            flash('Usuário excluído com sucesso!')->success();
        } else {
            flash('Usuário não pode ser excluído! O mesmo possui relacionamentos ativos.')->error();
        }
        return redirect()->route('usuarios');
    }

    public function edit($id){
        $usuario = Usuario::find($id);
        $usuario_pro = ProfissionalSaude::where('usuario_id', '=', $id);
        return view('usuarios.edit', compact('usuario'), compact('usuario_pro'));

    }

    public function update(UsuarioRequest $request, $id, ProfissionalSaudeRequest $request_pro){
        if($request->password != null) {
            $usuario = Usuario::find($id)->update($request->all());
            Log::create(['usuario'=>Auth::user()->nome, 'email'=>Auth::user()->email, 'acao'=>'update', 'descricao'=>$request->nome, 'tabela'=>'usuário']);
            if ($request->tipoUsuario != 'Recepcionista') {
                $conselho = $request_pro->conselho;
                $registroConselho = $request_pro->registroConselho;
                $especialidade = $request_pro->especialidade;
                $usuario_id = $id;
                $usuario_pro = ProfissionalSaude::where('usuario_id', '=', $id)->update([
                    'conselho' => $conselho,
                    'registroConselho' => $registroConselho,
                    'especialidade' => $especialidade,
                    'usuario_id' => $usuario_id]);
                Log::create(['usuario'=>Auth::user()->nome, 'email'=>Auth::user()->email, 'acao'=>'update', 'descricao'=>$request_pro->nome, 'tabela'=>'profissional da saúde']);
            }
        } else {
            $nome = $request->nome;
            $sexo = $request->sexo;
            $dataCriacao = $request->dataCriacao;
            $email = $request->email;
            $telefone = $request->telefone;
            $login = $request->login;
            $situacao = $request->situacao;
            $flagAdmin = $request->flagAdmin;
            $tipoUsuario = $request->tipoUsuario;
            $usuario = Usuario::find($id)->update([
                'nome' => $nome,
                'sexo' => $sexo,
                'dataCriacao' => $dataCriacao,
                'email' => $email,
                'telefone' => $telefone,
                'login' => $login,
                'situacao' => $situacao,
                'flagAdmin' => $flagAdmin,
                'tipoUsuario' => $tipoUsuario]);
            Log::create(['usuario'=>Auth::user()->nome, 'email'=>Auth::user()->email, 'acao'=>'update', 'descricao'=>$request->nome, 'tabela'=>'usuário']);

            if ($request->tipoUsuario != 'Recepcionista') {
                $conselho = $request_pro->conselho;
                $registroConselho = $request_pro->registroConselho;
                $especialidade = $request_pro->especialidade;
                $usuario_id = $id;
                $usuario_pro = ProfissionalSaude::where('usuario_id', '=', $id)->update([
                    'conselho' => $conselho,
                    'registroConselho' => $registroConselho,
                    'especialidade' => $especialidade,
                    'usuario_id' => $usuario_id]);
                Log::create(['usuario'=>Auth::user()->nome, 'email'=>Auth::user()->email, 'acao'=>'update', 'descricao'=>$request_pro->nome, 'tabela'=>'profissional da saúde']);
            }
        }
        flash('Usuário editado com sucesso!')->success();
        return redirect()->route('usuarios');
    }
}
