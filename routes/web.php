<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Route::group(['middleware' => ['web']], function () {

    Route::group(['prefix'=>'convenios', 'where'=>['id'=>'[0-9]+']], function (){
        Route::get('', ['as'=>'convenios', 'uses'=>'ConveniosController@index']);
        Route::get('create', ['as'=>'convenios.create', 'uses'=>'ConveniosController@create']);
        Route::post('store', ['as'=>'convenios.store', 'uses'=>'ConveniosController@store']);
        Route::post('plano', ['as'=>'convenios.plano', 'uses'=>'ConveniosController@plano']);
        Route::get('{id}/destroy', ['as'=>'convenios.destroy', 'uses'=>'ConveniosController@destroy']);
        Route::get('{id}/edit', ['as'=>'convenios.edit', 'uses'=>'ConveniosController@edit']);
        Route::put('{id}/update', ['as'=>'convenios.update', 'uses'=>'ConveniosController@update']);

        //planos
        Route::put('{id}/storeplano', ['as'=>'convenios.storeplano', 'uses'=>'ConveniosController@storeplano']);
        Route::get('{id}/{id_convenio}/destroyplano', ['as'=>'convenios.destroyplano', 'uses'=>'ConveniosController@destroyplano']);
        Route::put('{id_convenio}/updateplano', ['as'=>'convenios.updateplano', 'uses'=>'ConveniosController@updateplano']);
    });

    Route::group(['prefix'=>'procedimentos', 'where'=>['id'=>'[0-9]+']], function (){
        Route::get('', ['as'=>'procedimentos', 'uses'=>'ProcedimentosController@index']);
        Route::get('create', ['as'=>'procedimentos.create', 'uses'=>'ProcedimentosController@create']);
        Route::post('store', ['as'=>'procedimentos.store', 'uses'=>'ProcedimentosController@store']);
        Route::get('{id}/destroy', ['as'=>'procedimentos.destroy', 'uses'=>'ProcedimentosController@destroy']);
        Route::get('{id}/edit', ['as'=>'procedimentos.edit', 'uses'=>'ProcedimentosController@edit']);
        Route::put('{id}/update', ['as'=>'procedimentos.update', 'uses'=>'ProcedimentosController@update']);
    });

    Route::group(['prefix'=>'cidades', 'where'=>['id'=>'[0-9]+']], function (){
        Route::get('', ['as'=>'cidades', 'uses'=>'CidadesController@index']);
        Route::get('create', ['as'=>'cidades.create', 'uses'=>'CidadesController@create']);
        Route::post('store', ['as'=>'cidades.store', 'uses'=>'CidadesController@store']);
        Route::get('{id}/destroy', ['as'=>'cidades.destroy', 'uses'=>'CidadesController@destroy']);
        Route::get('{id}/edit', ['as'=>'cidades.edit', 'uses'=>'CidadesController@edit']);
        Route::put('{id}/update', ['as'=>'cidades.update', 'uses'=>'CidadesController@update']);
    });

    Route::group(['prefix'=>'pacientes', 'where'=>['id'=>'[0-9]+']], function (){
        Route::get('', ['as'=>'pacientes', 'uses'=>'PacientesController@index']);
        Route::get('search', ['as'=>'pacientes.search', 'uses'=>'PacientesController@search']);
        Route::get('create', ['as'=>'pacientes.create', 'uses'=>'PacientesController@create']);
        Route::post('store', ['as'=>'pacientes.store', 'uses'=>'PacientesController@store']);
        Route::get('{id}/destroy', ['as'=>'pacientes.destroy', 'uses'=>'PacientesController@destroy']);
        Route::get('{id}/edit', ['as'=>'pacientes.edit', 'uses'=>'PacientesController@edit']);
        Route::put('{id}/update', ['as'=>'pacientes.update', 'uses'=>'PacientesController@update']);

        //select box convenio x plano create
        Route::get('ajax-planos', function(){
            $convenio_id = \Illuminate\Support\Facades\Input::get('convenio');
            $planos = \App\Plano::where('convenio_id', '=', $convenio_id)->get();
            return Response::json($planos);
        });
        //select box convenio x plano edit
        Route::get('{id}/ajax-planos', function(){
            $convenio_id = \Illuminate\Support\Facades\Input::get('convenio');
            $planos = \App\Plano::where('convenio_id', '=', $convenio_id)->get();
            return Response::json($planos);
        });
        //select box uf x cidade create
        Route::get('ajax-cidades', function(){
            $uf = \Illuminate\Support\Facades\Input::get('uf');
            $cidades = \App\Cidade::where('uf', '=', $uf)->get();
            return Response::json($cidades);
        });
        //select box uf x cidade edit
        Route::get('{id}/ajax-cidades', function(){
            $uf = \Illuminate\Support\Facades\Input::get('uf');
            $cidades = \App\Cidade::where('uf', '=', $uf)->get();
            return Response::json($cidades);
        });

        //planos
        Route::put('{id}/storefamiliar', ['as'=>'pacientes.storefamiliar', 'uses'=>'PacientesController@storefamiliar']);
        Route::get('{id}/{id_paciente}/destroyfamiliar', ['as'=>'pacientes.destroyfamiliar', 'uses'=>'PacientesController@destroyfamiliar']);
        Route::put('{id_paciente}/updatefamiliar', ['as'=>'pacientes.updatefamiliar', 'uses'=>'PacientesController@updatefamiliar']);
    });

    Route::group(['prefix'=>'usuarios', 'where'=>['id'=>'[0-9]+']], function (){
        Route::get('', ['as'=>'usuarios', 'uses'=>'UsuariosController@index']);
        Route::get('search', ['as'=>'usuarios.search', 'uses'=>'UsuariosController@search']);
        Route::get('create', ['as'=>'usuarios.create', 'uses'=>'UsuariosController@create']);
        Route::post('store', ['as'=>'usuarios.store', 'uses'=>'UsuariosController@store']);
        Route::get('{id}/destroy', ['as'=>'usuarios.destroy', 'uses'=>'UsuariosController@destroy']);
        Route::get('{id}/edit', ['as'=>'usuarios.edit', 'uses'=>'UsuariosController@edit']);
        Route::put('{id}/update', ['as'=>'usuarios.update', 'uses'=>'UsuariosController@update']);
    });

    Route::group(['prefix'=>'agendamentos', 'where'=>['id'=>'[0-9]+']], function (){
        Route::get('', ['as'=>'agendamentos', 'uses'=>'AgendamentosController@index']);
        Route::get('create', ['as'=>'agendamentos.create', 'uses'=>'AgendamentosController@create']);
        Route::post('store', ['as'=>'agendamentos.store', 'uses'=>'AgendamentosController@store']);
        Route::get('{id}/destroy', ['as'=>'agendamentos.destroy', 'uses'=>'AgendamentosController@destroy']);
        Route::get('{id}/edit', ['as'=>'agendamentos.edit', 'uses'=>'AgendamentosController@edit']);
        Route::get('{id}/profissional', ['as'=>'agendamentos.profissional', 'uses'=>'AgendamentosController@profissional']);
        Route::put('{id}/update', ['as'=>'agendamentos.update', 'uses'=>'AgendamentosController@update']);

        //select  paciente e carrega convenio create
        Route::get('ajax-pacientes', function(){
            $convenio = DB::table('pacientes')->join('convenios', function ($join){$join->on('pacientes.convenio_id', '=', 'convenios.id')->where('pacientes.id', '=', \Illuminate\Support\Facades\Input::get('paciente'));})->select('convenios.nome')->get();
            return Response::json($convenio);
        });

        //select  paciente e carrega suas informações create
        Route::get('ajax-pacientesinfo', function(){
            $paciente_id = \Illuminate\Support\Facades\Input::get('paciente');
            $paciente = \App\Paciente::where('id', '=', $paciente_id)->get();
            return Response::json($paciente);
        });

        //select  paciente e carrega convenio edit
        Route::get('{id}/ajax-pacientes', function(){
            $convenio = DB::table('pacientes')->join('convenios', function ($join){$join->on('pacientes.convenio_id', '=', 'convenios.id')->where('pacientes.id', '=', \Illuminate\Support\Facades\Input::get('paciente'));})->select('convenios.nome')->get();
            return Response::json($convenio);
        });

        //select  paciente e carrega suas informações edit
        Route::get('{id}/ajax-pacientesinfo', function(){
            $paciente_id = \Illuminate\Support\Facades\Input::get('paciente');
            $paciente = \App\Paciente::where('id', '=', $paciente_id)->get();
            return Response::json($paciente);
        });

        //datas disponiveis create
        Route::get('ajax-agendamentodata', function(){
            $data = \Illuminate\Support\Facades\Input::get('data');
            $usuario_id = \Illuminate\Support\Facades\Input::get('usuario_id');
            $dataagendada = \App\Agendamento::where('usuario_id', '=', $usuario_id)
                                            ->where('data', '=', $data)
                                            ->where('status', '!=', 'Cancelado')
                                            ->select('horario')->get();
            $horariodisponivel = \App\Horario::whereNotIn('horario', $dataagendada)->select('horario')->get();

            return Response::json($horariodisponivel);
        });

        //conflito de horarios create
        Route::get('ajax-agendamentohorario', function(){
            $data = \Illuminate\Support\Facades\Input::get('data');
            $usuario_id = \Illuminate\Support\Facades\Input::get('usuario_id');
            $horario = \Illuminate\Support\Facades\Input::get('horario');
            $procedimento_id = \Illuminate\Support\Facades\Input::get('procedimento');

            $hor = substr($horario, 0, -6) * 60;
            $min = substr($horario, -5, 2) + $hor;

            $duracaoproc = \App\Procedimento::where('id', '=', $procedimento_id)->select('duracao');
            $horproc = substr($duracaoproc->first()->duracao, 0, -6) * 60;
            $minproc = substr($duracaoproc->first()->duracao, -5, 2) + $horproc + $min;


            $count1 = DB::table('agendamentos')->join('procedimentos', function ($join){$join->on('agendamentos.procedimento_id', '=', 'procedimentos.id');})
                            ->where('agendamentos.usuario_id','=', $usuario_id)
                            ->where('agendamentos.data','=', $data)
                            ->where('agendamentos.status', '!=', 'Cancelado')
                            ->where(DB::raw('(extract(hour from agendamentos.horario)*60)+(extract(minute from agendamentos.horario))'), '<=', $min)
                            ->where(DB::raw('((extract(hour from agendamentos.horario)*60)+(extract(minute from agendamentos.horario)))+((extract(hour from procedimentos.duracao)*60)+(extract(minute from procedimentos.duracao)))'), '>', $min)
                            ->count('agendamentos.id');

            $count2 = \App\Agendamento::where('usuario_id', '=', $usuario_id)
                                        ->where('data', '=', $data)
                                        ->where('status', '!=', 'Cancelado')
                                        ->where('horario', '>', $horario)
                                        ->where(DB::raw('(extract(hour from horario)*60)+(extract(minute from horario))'), '<', $minproc)->count('id');

            if($count1 > 0 or $count2 > 0){
                $choquehorario = array(true);
            }else{
                $choquehorario = array(false);
            }
            return Response::json($choquehorario);
        });

        //datas disponiveis edit
        Route::get('{id}/ajax-agendamentodata', function(){
            $data = \Illuminate\Support\Facades\Input::get('data');
            $usuario_id = \Illuminate\Support\Facades\Input::get('usuario_id');
            $agendamento_id = \Illuminate\Support\Facades\Input::get('agendamento_id');
            $dataagendada = \App\Agendamento::where('usuario_id', '=', $usuario_id)
                                            ->where('data', '=', $data)
                                            ->where('status', '!=', 'Cancelado')
                                            ->where('id', '!=', $agendamento_id)
                                            ->select('horario')->get();
            $horariodisponivel = \App\Horario::whereNotIn('horario', $dataagendada)->select('horario')->get();

            return Response::json($horariodisponivel);
        });

        //conflito de horarios edit
        Route::get('{id}/ajax-agendamentohorario', function(){
            $data = \Illuminate\Support\Facades\Input::get('data');
            $usuario_id = \Illuminate\Support\Facades\Input::get('usuario_id');
            $horario = \Illuminate\Support\Facades\Input::get('horario');
            $procedimento_id = \Illuminate\Support\Facades\Input::get('procedimento');
            $agendamento_id = \Illuminate\Support\Facades\Input::get('agendamento_id');

            $hor = substr($horario, 0, -6) * 60;
            $min = substr($horario, -5, 2) + $hor;

            $duracaoproc = \App\Procedimento::where('id', '=', $procedimento_id)->select('duracao');
            $horproc = substr($duracaoproc->first()->duracao, 0, -6) * 60;
            $minproc = substr($duracaoproc->first()->duracao, -5, 2) + $horproc + $min;


            $count1 = DB::table('agendamentos')->join('procedimentos', function ($join){$join->on('agendamentos.procedimento_id', '=', 'procedimentos.id');})
                ->where('agendamentos.usuario_id','=', $usuario_id)
                ->where('agendamentos.data','=', $data)
                ->where('agendamentos.status', '!=', 'Cancelado')
                ->where('agendamentos.id', '!=', $agendamento_id)
                ->where(DB::raw('(extract(hour from agendamentos.horario)*60)+(extract(minute from agendamentos.horario))'), '<=', $min)
                ->where(DB::raw('((extract(hour from agendamentos.horario)*60)+(extract(minute from agendamentos.horario)))+((extract(hour from procedimentos.duracao)*60)+(extract(minute from procedimentos.duracao)))'), '>', $min)
                ->count('agendamentos.id');

            $count2 = \App\Agendamento::where('usuario_id', '=', $usuario_id)
                ->where('data', '=', $data)
                ->where('status', '!=', 'Cancelado')
                ->where('id', '!=', $agendamento_id)
                ->where('horario', '>', $horario)
                ->where(DB::raw('(extract(hour from horario)*60)+(extract(minute from horario))'), '<', $minproc)->count('id');

            if($count1 > 0 or $count2 > 0){
                $choquehorario = array(true);
            }else{
                $choquehorario = array(false);
            }
            return Response::json($choquehorario);
        });
    });

    Route::group(['prefix'=>'atendimentos', 'where'=>['id'=>'[0-9]+']], function (){
        Route::get('{id}/create', ['as'=>'atendimentos.create', 'uses'=>'AtendimentosController@create']);
        Route::post('store', ['as'=>'atendimentos.store', 'uses'=>'AtendimentosController@store']);
        Route::get('{id}/edit', ['as'=>'atendimentos.edit', 'uses'=>'AtendimentosController@edit']);
        Route::put('{id}/update', ['as'=>'atendimentos.update', 'uses'=>'AtendimentosController@update']);
    });

    Route::group(['prefix'=>'historicos', 'where'=>['id'=>'[0-9]+']], function (){
        Route::get('', ['as'=>'historicos', 'uses'=>'HistoricosController@index']);
        Route::post('search', ['as'=>'historicos.search', 'uses'=>'HistoricosController@search']);
    });

    Route::group(['prefix'=>'logs', 'where'=>['id'=>'[0-9]+']], function (){
        Route::get('', ['as'=>'logs', 'uses'=>'LogsController@index']);
    });

    Route::group(['prefix'=>'relatorios', 'where'=>['id'=>'[0-9]+']], function (){
        Route::get('', ['as'=>'relatorios', 'uses'=>'ReportController@index']);
        Route::get('pacientes', ['as'=>'relatorios.pacientes', 'uses'=>'ReportController@paciente']);
        Route::get('{status}/agendamentos', ['as'=>'relatorios.agendamentos', 'uses'=>'ReportController@agendamentos']);
        Route::get('{datainicial}/{datafinal}/atendimentos', ['as'=>'relatorios.atendimentos', 'uses'=>'ReportController@atendimentos']);

        //verifica status
        Route::get('ajax-reportsagendamento', function(){
            $status = \Illuminate\Support\Facades\Input::get('status');
            $count = \App\Agendamento::where('status', '=', $status)->count('*');
            if($count > 0){
                $reportstatus = array(true);
            }else{
                $reportstatus = array(false);
            }
            return Response::json($reportstatus);
        });

        //data inicial e final
        Route::get('ajax-reportsatendimento', function(){
            $datainicial = \Illuminate\Support\Facades\Input::get('datainicial');
            $datafinal = \Illuminate\Support\Facades\Input::get('datafinal');

            $count = DB::table('atendimentos')->join('agendamentos', function ($join){$join->on('atendimentos.agendamento_id', '=', 'agendamentos.id');})
                                ->whereBetween('agendamentos.data', [$datainicial, $datafinal])->count('*');
            if($count > 0){
                $reportdata = array(true);
            }else{
                $reportdata = array(false);
            }
            return Response::json($reportdata);
        });
    });

    Route::group(['prefix'=>'dashboard', 'where'=>['id'=>'[0-9]+']], function (){
        Route::get('', ['as'=>'dashboard', 'uses'=>'DashboardsController@index']);
    });
});

Auth::routes();

