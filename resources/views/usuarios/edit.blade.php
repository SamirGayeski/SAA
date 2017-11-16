@extends('app')

@section('content')
    <div class="container">
        <h3>Editando usuário: {{$usuario->nome}}</h3>
        <hr size="300" width="100%" align="left">
        @if($errors->any())
            <ul class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        @endif

        {!! Form::open(['route' => ["usuarios.update", $usuario->id], 'method'=>'put']) !!}

        <div class="row" style="padding: 5px;">
            <div class="col-md-6">
                {!! Form::label('nome', 'Nome:') !!}
                {!! Form::text('nome', $usuario->nome, ['class'=>'form-control']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('sexo', 'Sexo:') !!}
                {!! Form::select('sexo', array('Masculino' => 'Masculino', 'Feminino' => 'Feminino'), $usuario->sexo, ['class'=>'form-control']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('dataCriacao', 'Data Criação:') !!}
                {!! Form::date('dataCriacao', $usuario->dataCriacao, ['class'=>'form-control', 'readonly']) !!}
            </div>
        </div>

        <div class="row" style="padding: 5px;">
            <div class="col-md-4">
                {!! Form::label('email', 'Email:') !!}
                {!! Form::text('email', $usuario->email, ['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="row" style="padding: 5px;">
            <div class="col-md-4">
                {!! Form::label('telefone', 'Telefone:') !!}
                {!! Form::text('telefone', $usuario->telefone, ['class'=>'form-control']) !!}
            </div>
        </div>

        <?php
        if ($usuario->situacao == 'Ativo'){
            $ativo = 'true';
            $inativo = '';
        } else if ($usuario->situacao == 'Inativo') {
            $ativo = '';
            $inativo = 'true';
        }
        if ($usuario->flagAdmin == true){
            $true = 'true';
            $false = '';
        } else if ($usuario->flagAdmin == false) {
            $true = '';
            $false = 'true';
        }
        ?>

        <div class="row" style="padding: 5px;">
            <div class="col-md-2">
                {!! Form::label('situacao', 'Situação:') !!}
                <br/>
                <label class="checkbox-inline">
                    {!! Form::radio('situacao', 'Ativo', $ativo) !!}
                    Ativo</label>&nbsp;&nbsp;
                <label class="checkbox-inline">
                    {!! Form::radio('situacao', 'Inativo', $inativo) !!}
                    Inativo</label>
            </div>
            <div class="col-md-2">
                {!! Form::label('flagAdmin', 'Administrador:') !!}
                <br/>
                <label class="checkbox-inline">
                    {!! Form::radio('flagAdmin', 1, $true) !!}
                    Sim</label>&nbsp;&nbsp;
                <label class="checkbox-inline">
                    {!! Form::radio('flagAdmin', 0, $false) !!}
                    Não</label>
            </div>
        </div>


        <div class="row" style="padding: 5px;">
            <div id="select_tipo" class="col-md-4">
                {!! Form::label('tipoUsuario', 'Tipo do Usuário:') !!}
                {!! Form::text('tipoUsuario', $usuario->tipoUsuario, ['class'=>'form-control', 'readonly', 'id'=>'tipoUsuario']) !!}
            </div>
        </div>

        <?php
        if ($usuario->tipoUsuario != 'Recepcionista'){
            $conselho = $usuario_pro->first()->conselho;
            $registroConselho = $usuario_pro->first()->registroConselho;
            $especialidade = $usuario_pro->first()->especialidade;
        } else {
            $conselho = null;
            $registroConselho = null;
            $especialidade = null;
        }
        ?>

        <div id="profissional_saude" class="row" style="padding: 5px; display: none;">
            <div class="col-md-3">
                {!! Form::label('conselho', 'Conselho:') !!}
                {!! Form::text('conselho', $conselho, ['class'=>'form-control']) !!}
            </div>

            <div class="col-md-3">
                {!! Form::label('registroConselho', 'Registro Conselho:') !!}
                {!! Form::text('registroConselho', $registroConselho, ['class'=>'form-control']) !!}
            </div>

            <div class="col-md-3">
                {!! Form::label('especialidade', 'Especialidade:') !!}
                {!! Form::text('especialidade', $especialidade, ['class'=>'form-control']) !!}
            </div>
        </div>

        <div id="alter_password" class="row" style="padding: 20px 0px 0px 20px">
            <div class="form-group">
                <input type="button" class="btn-sm btn btn-outline-dark" value="Alterar Senha" id="alter_password">
            </div>
        </div>

        <div id="div_password" class="row" style="padding: 5px; display: none;">
            <hr size="300" width="100%" align="left" style="padding: 5px;">
            <h6>Alteração Senha</h6>
        </div>

        <div id="new_password" class="row" style="padding: 5px; display: none;">
            <div class="col-md-4">
                {!! Form::label('password', 'Nova senha:') !!}
                {!! Form::password('password', ['class'=>'form-control']) !!}
            </div>
        </div>
        <div id="new_password_confirm" class="row" style="padding: 5px; display: none;">
            <div class="col-md-4">
                {!! Form::label('password_confirmed', 'Confirmar senha:') !!}
                {!! Form::password('password_confirmed', ['class'=>'form-control']) !!}
            </div>
            <hr size="300" width="100%" align="left" style="padding: 5px;">
        </div>

        <div class="row" style="padding: 20px;">
            <div class="form-group">
                <a href="{{ route('usuarios') }}" class="btn-sm btn btn-danger">Cancelar</a>
                {!! Form::submit('Salvar', ['class'=>'btn-sm btn btn-success']) !!}
            </div>
        </div>

        {!! Form::close() !!}

        <script type="text/javascript">
            //ativa campos profissional_saude
            $(document).ready(function() {
                    var id = document.getElementById('tipoUsuario').value;
                    if(id == 'Recepcionista') {
                        document.getElementById('profissional_saude').style = 'padding: 5px; display: none;';
                    } else {
                        document.getElementById('profissional_saude').style = 'padding: 5px; display: flex;';
                    }

                    $('#alter_password').click(function(){
                        document.getElementById('div_password').style = 'padding: 5px; display: flex;';
                        document.getElementById('new_password').style = 'padding: 5px; display: flex;';
                        document.getElementById('new_password_confirm').style = 'padding: 5px; display: flex;';
                        document.getElementById('alter_password').style = 'display: none;';
                    });
            });

            //mascara campos
            $('input[name="telefone"]').mask('(00) 00000-0000');

        </script>

    </div>
@endsection