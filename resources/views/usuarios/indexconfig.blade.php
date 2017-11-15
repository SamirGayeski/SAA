@extends('app')

@section('content')
    <div class="container">
        <h3>Recepcionista: {{$recepcionista->nome}}</h3>
        <hr size="300" width="100%" align="left">

        @if($errors->any())
            <ul class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        @endif

        <?php
        if (count($usuarios) != 0){
        ?>
        <div class="form-group" style="padding: 30px;">

            <button type="button" class="btn-sm btn btn-outline-info" data-toggle="modal" data-target=".bs-example-modal-sm" style="font-weight: bold; float:right; margin-bottom: 10px;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Vincular Profissional</button>
            <h5>Profissionais que atende:</h5>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th style="text-align: center; width: 10%">Ação</th>
                </tr>
                </thead>
                <tbody>
                @foreach($usuarios as $user)
                    <tr>
                        <td>{{$user->nome}}</td>
                        <td style="text-align: center;">
                            <a onclick="return confirm('O profissional {{$user->nome}} será removido, deseja continuar ?')" href="{{ route('usuarios.destroyconfig', ['id_recepcionista'=>$recepcionista->id, 'id_profissional'=>$user->id]) }}" class="btn-sm btn-danger"><i class="fa fa-trash-o " aria-hidden="true"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
        <hr size="300" width="100%" align="left" style="padding: 5px;">

        <?php
        } else {
        ?>
        <div class="form-group" style="padding: 20px;">
            <button data-toggle="modal" data-target="#modalplano" type="button" class="btn-sm btn btn-outline-info" style="font-weight: bold; margin-left: 40%; padding: 5px 30px 5px 30px;">
                <i class="fa fa-plus-circle" aria-hidden="true"></i> Vincular Profissional</button>
        </div>
        <hr size="300" width="100%" align="left">
        <?php
        }

        $profRecep = \App\RecepcionistaAtende::where('recepcionista_id', '=', $recepcionista->id)->select('profissionalsaude_id')->get();

        ?>

        <div id="modalplano" class="modal bs-example-modal-sm" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content" style="width: 450px;">
                    <div class="modal-header">
                        <h class="modal-title" style="font-weight: 600;" id="gridSystemModalLabel">Profissional</h>
                    </div>
                    <div>
                        {!! Form::open(['route' => ["usuarios.storeconfig", $recepcionista->id], 'method'=>'put']) !!}
                        <div class="col-md-12" style="margin-top: 20px; margin-botton: 20px;">
                            {{ Form::select('profissionalsaude_id', \App\usuario::where('tipoUsuario', '=', 'Profissional da Saúde')->whereNotIn('id', $profRecep)->orderBy('nome')->pluck('nome','id')->toArray(), null, ['class'=>'form-control', 'placeholder' => 'Selecione um profissional', 'id' => 'profissional', 'style'=>'height: 40px;']) }}
                        </div>
                        <div class="form-group" style="margin: 15px 15px 15px 0px; float: right;">
                            <button type="button" class="btn btn-danger" class="close" data-dismiss="modal">Cancelar</button>
                            {!! Form::submit('Incluir', ['class'=>'btn btn-success', 'id'=>'buttons']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection