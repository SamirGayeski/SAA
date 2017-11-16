@extends('app')

@section('content')
    <div class="container">
        <h3>Novo Usuário</h3>
        <hr size="300" width="100%" align="left">
        @if($errors->any())
            <ul class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        @endif

        {!! Form::open(['route' => 'usuarios.store']) !!}

        <div class="row" style="padding: 5px;">
            <div class="col-md-6">
                {!! Form::label('nome', 'Nome:') !!}
                {!! Form::text('nome', null, ['class'=>'form-control']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('sexo', 'Sexo:') !!}
                {!! Form::select('sexo', array('Masculino' => 'Masculino', 'Feminino' => 'Feminino'), null, ['class'=>'form-control', 'placeholder' => 'Selecione o sexo']) !!}
            </div>
            <div class="col-md-3" style="display: none;">
                {!! Form::label('dataCriacao', 'Data Criação:') !!}
                {!! Form::date('dataCriacao', \Carbon\Carbon::now(), ['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="row" style="padding: 5px;">
            <div class="col-md-4">
                {!! Form::label('email', 'Email:') !!}
                {!! Form::text('email', null, ['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="row" style="padding: 5px;">
            <div class="col-md-4">
                {!! Form::label('telefone', 'Telefone:') !!}
                {!! Form::text('telefone', null, ['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="row" style="padding: 5px;">
            <div class="col-md-4">
                {!! Form::label('password', 'Senha:') !!}
                {!! Form::password('password', ['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="row" style="padding: 5px;">
            <div class="col-md-4">
                {!! Form::label('password_confirmed', 'Confirmar senha:') !!}
                {!! Form::password('password_confirmed', ['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="row" style="padding: 5px;">
            <div class="col-md-2">
                {!! Form::label('situacao', 'Situação:') !!}
                <br/>
                <label class="checkbox-inline">
                    {!! Form::radio('situacao', 'Ativo', true) !!}
                    Ativo</label>&nbsp;&nbsp;
                <label class="checkbox-inline">
                    {!! Form::radio('situacao', 'Inativo') !!}
                    Inativo</label>
            </div>
            <div class="col-md-2">
                {!! Form::label('flagAdmin', 'Administrador:') !!}
                <br/>
                <label class="checkbox-inline">
                    {!! Form::radio('flagAdmin', 1) !!}
                    Sim</label>&nbsp;&nbsp;
                <label class="checkbox-inline">
                    {!! Form::radio('flagAdmin', 0, true) !!}
                    Não</label>
            </div>
        </div>


        <div class="row" style="padding: 5px;">
            <div id="select_tipo" class="col-md-4">
                {!! Form::label('tipoUsuario', 'Tipo do Usuário:') !!}
                {!! Form::select('tipoUsuario', array('Recepcionista' => 'Recepcionista', 'Profissional da Saúde' => 'Profissional da Saúde'), null, ['class'=>'form-control', 'placeholder' => 'Selecione o tipo do usuário', 'id' => 'selectoptions']) !!}
            </div>
        </div>

        <div id="profissional_saude" class="row" style="padding: 5px; display: none;">
                <div class="col-md-3">
                    {!! Form::label('conselho', 'Conselho:') !!}
                    {!! Form::text('conselho', null, ['class'=>'form-control']) !!}
                </div>

                <div class="col-md-3">
                    {!! Form::label('registroConselho', 'Registro Conselho:') !!}
                    {!! Form::text('registroConselho', null, ['class'=>'form-control']) !!}
                </div>

                <div class="col-md-3">
                    {!! Form::label('especialidade', 'Especialidade:') !!}
                    {!! Form::text('especialidade', null, ['class'=>'form-control']) !!}
                </div>
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
                var index = document.getElementById('selectoptions').selectedIndex;
                var id = document.getElementById('selectoptions').options[index].value;
                if(id == 'Profissional da Saúde') {
                    document.getElementById('profissional_saude').style = 'padding: 5px; display: flex;';
                } else {
                    document.getElementById('profissional_saude').style = 'padding: 5px; display: none;';
                }
                document.getElementById('select_tipo').addEventListener('change', function(){
                    var index = document.getElementById('selectoptions').selectedIndex;
                    var id = document.getElementById('selectoptions').options[index].value;
                    if(id == 'Recepcionista') {
                        document.getElementById('profissional_saude').style = 'padding: 5px; display: none;';
                    } else {
                        document.getElementById('profissional_saude').style = 'padding: 5px; display: flex;';
                    }
                });
            });

            //mascara campos
            $('input[name="telefone"]').mask('(00) 00000-0000');

        </script>

    </div>
@endsection