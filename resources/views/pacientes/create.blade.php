@extends('app')

@section('content')
    <div class="container">
        <div class="row" style="margin: 10px 0px 10px 0px;">
            <div class="col-md-8" style="margin-top: 15px;">
                <h style="float: left; font-size: 12px; color: #1f648b;">*Dados Obrigatórios</h>
            </div>
            <div class="col-md-4">
                <h3 style="float: right;">Novo Paciente</h3>
            </div>
            <hr size="300" width="100%">
        </div>

        @if($errors->any())
            <ul class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        @endif

        {!! Form::open(['route' => 'pacientes.store']) !!}

        <h5>Dados Pessoais:</h5>
        <div class="row" style="padding: 5px;">
            <div class="col-md-6">
                {!! Form::label('nome', 'Nome: *') !!}
                {!! Form::text('nome', null, ['class'=>'form-control']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('dataNascimento', 'Data de Nascimento: *') !!}
                {!! Form::date('dataNascimento', null, ['class'=>'form-control']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('sexo', 'Sexo: *') !!}
                {!! Form::select('sexo', array('Masculino' => 'Masculino', 'Feminino' => 'Feminino'), null, ['class'=>'form-control', 'placeholder' => 'Selecione o sexo']) !!}
            </div>
        </div>

        <div class="row" style="padding: 5px;">
            <div class="col-md-8">
                {!! Form::label('email', 'Email:') !!}
                {!! Form::text('email', null, ['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="row" style="padding: 5px;">
            <div class="col-md-4">
                {!! Form::label('telefoneCelular', 'Telefone Celular: *') !!}
                {!! Form::text('telefoneCelular', null, ['class'=>'form-control']) !!}
            </div>
            <div class="col-md-4">
                {!! Form::label('telefoneResidencial', 'Telefone Residencial:') !!}
                {!! Form::text('telefoneResidencial', null, ['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="row" style="padding: 5px;">
            <div class="col-md-4">
                {!! Form::label('cpf', 'CPF: *') !!}
                {!! Form::text('cpf', null, ['class'=>'form-control']) !!}
            </div>

            <div class="col-md-4">
                {!! Form::label('rg', 'RG: *') !!}
                {!! Form::text('rg', null, ['class'=>'form-control']) !!}
            </div>
        </div>

        <hr size="300" width="100%" align="left" style="padding: 5px;">

        <h5>Endereço</h5>
        <div class="row" style="padding: 5px;">
            <div class="col-md-5">
                {!! Form::label('endereco', 'Rua/Avenida: *') !!}
                {!! Form::text('endereco', null, ['class'=>'form-control']) !!}
            </div>
            <div class="col-md-4">
                {!! Form::label('bairro', 'Bairro: *') !!}
                {!! Form::text('bairro', null, ['class'=>'form-control']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('numero', 'Número: *') !!}
                {!! Form::text('numero', null, ['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="row" style="padding: 5px;">

            <div class="col-md-5">
                {!! Form::label('complemento', 'Complemento:') !!}
                {!! Form::text('complemento', null, ['class'=>'form-control']) !!}
            </div>
            <div class="col-md-2">
                {!! Form::label('estado', 'Estado: *') !!}
                {{ Form::select('estado', \App\Cidade::orderBy('uf')->distinct('uf')->pluck('uf', 'uf')->toArray(), null,
                                ['class'=>'form-control', 'placeholder' => 'UF', 'id'=>'uf']) }}
            </div>
            <div class="col-md-5">
                {!! Form::label('cidade', 'Cidade: *') !!}
                {{ Form::select('cidade_id', \App\Cidade::orderBy('nome')->pluck('nome','id')->toArray(), null,
                                ['class'=>'form-control', 'placeholder' => 'Selecione uma cidade', 'id'=>'cidade']) }}
            </div>
        </div>

        <hr size="300" width="100%" align="left" style="padding: 5px;">

        <h5>Complemento</h5>
        <div class="row" style="padding: 5px;">
            <div class="col-md-4">
                {!! Form::label('estadoCivil', 'Estado Civil: *') !!}
                {!! Form::select('estadoCivil', array('Solteiro (a)' => 'Solteiro (a)',
                                                      'Casado (a)' => 'Casado (a)',
                                                      'Viúvo (a)' => 'Viúvo (a)',
                                                      'Divorciado (a)' => 'Divorciado (a)',
                                                      'Separado (a)' => 'Separado (a)'),
                                                      null, ['class'=>'form-control', 'placeholder' => 'Selecione estado civil']) !!}
            </div>
            <div class="col-md-4">
                {!! Form::label('profissao', 'Profissão:') !!}
                {!! Form::text('profissao', null, ['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="row" style="padding: 5px;">
            <div class="col-md-4">
                {!! Form::label('situacao', 'Situação:') !!}
                <br/>
                <label class="checkbox-inline">
                    {!! Form::radio('situacao', 'Ativo', true) !!}
                    Ativo</label>&nbsp;&nbsp;
                <label class="checkbox-inline">
                    {!! Form::radio('situacao', 'Inativo') !!}
                    Inativo</label>
            </div>
        </div>

        <hr size="300" width="100%" align="left" style="padding: 5px;">
        <h5>Convênio</h5>

        <div id="cns" class="row" style="padding: 5px;">
            <div class="col-md-6">
                {!! Form::label('cns', 'CNS:') !!}
                {!! Form::text('cns', null, ['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="row" style="padding: 5px;">
            <div id="select" class="col-md-6">
                {!! Form::label('convenio_id', 'Convênio:') !!}
                {{ Form::select('convenio_id', [null => 'Nenhum'] + \App\Convenio::orderBy('nome')->pluck('nome','id')->toArray(), null, ['class'=>'form-control', 'placeholder' => 'Selecione um convênio', 'id' => 'convenio']) }}
            </div>
        </div>

        <div id="infoconvenio" class="row" style="padding: 5px; display: none;">
            <div class="col-md-3">
                {!! Form::label('plano_id', 'Plano:') !!}
                {{ Form::select('plano_id', [null => 'Nenhum'], null, ['class'=>'form-control', 'placeholder' => 'Selecione um convênio', 'id' => 'plano']) }}
            </div>

            <div class="col-md-3">
                {!! Form::label('numeroCarteirinha', 'Número Carteirinha:') !!}
                {!! Form::text('numeroCarteirinha', null, ['class'=>'form-control']) !!}
            </div>

            <div class="col-md-3">
                {!! Form::label('validade', 'Validade:') !!}
                {!! Form::date('validade', null, ['class'=>'form-control']) !!}
            </div>

            <div class="col-md-3">
                {!! Form::label('acomodacao', 'Acomodação:') !!}
                {!! Form::text('acomodacao', null, ['class'=>'form-control']) !!}
            </div>
        </div>

        <hr size="300" width="100%" align="left" style="padding: 5px;">
        <h5>Dados Familiares</h5>

        <button id="dadosfamiliares" type="button" class="btn-sm btn btn-outline-info" style="font-weight: bold; margin-left: 40%; margin-bottom: 10px; padding: 5px 30px 5px 30px;">
            <i class="fa fa-plus-circle" aria-hidden="true"></i> Incluir Familiar</button>

        <div id="dadosfamiliares_conteudo" class="row" style="padding: 5px; display: none;">
            <div class="col-md-5">
                {!! Form::label('nomeFamiliar', 'Nome:') !!}
                {!! Form::text('nomeFamiliar', null, ['class'=>'form-control']) !!}
            </div>

            <div class="col-md-4">
                {!! Form::label('parentesco', 'Parentesco:') !!}
                {!! Form::text('parentesco', null, ['class'=>'form-control']) !!}
            </div>

            <div class="col-md-3">
                {!! Form::label('telefone', 'Telefone:') !!}
                {!! Form::text('telefone', null, ['class'=>'form-control']) !!}
            </div>
        </div>

        <hr size="300" width="100%" align="left">


        <div class="row" style="padding: 20px;">
            <div class="form-group">
                <a href="{{ route('pacientes') }}" class="btn-sm btn btn-danger">Cancelar</a>
                {!! Form::submit('Salvar', ['class'=>'btn-sm btn btn-success']) !!}
            </div>
        </div>

        {!! Form::close() !!}

        <script type="text/javascript">
            //ativa campos convenio
            $(document).ready(function() {
                document.getElementById('select').addEventListener('change', function(){
                    var index = document.getElementById('convenio').selectedIndex;
                    var id = document.getElementById('convenio').options[index].value;
                    if(id == '') {
                        document.getElementById('infoconvenio').style = 'padding: 5px; display: none;';
                    } else {
                        document.getElementById('infoconvenio').style = 'padding: 5px; display: flex;';
                    }
                });

                $('#convenio').on('change', function(e){
                    var convenio_id = e.target.value;
                    $.get('ajax-planos?convenio=' + convenio_id, function(data){
                        $('#plano').empty();
                        $.each(data, function(index, planoObj){
                            $('#plano').append('<option value="'+planoObj.id+'">'+planoObj.descricao+'</option>')
                        });
                    });
                });

                $('#uf').on('change', function(e){
                    var uf = e.target.value;
                    $.get('ajax-cidades?uf=' + uf, function(data){
                        $('#cidade').empty();
                        $.each(data, function(index, cidadeObj){
                            console.log(cidadeObj.nome);
                            $('#cidade').append('<option value="'+cidadeObj.id+'">'+cidadeObj.nome+'</option>')
                        });
                    });
                });

                $('#dadosfamiliares').click(function(){
                    document.getElementById('dadosfamiliares').style = 'display: none;';
                    document.getElementById('dadosfamiliares_conteudo').style = 'padding: 5px;';
                });
            });

            //mascara campos
            $('input[name="cpf"]').mask('000.000.000-00');
            $('input[name="telefoneResidencial"]').mask('(00) 0000-0000');
            $('input[name="telefoneCelular"]').mask('(00) 00000-0000');
            $('input[name="telefone"]').mask('(00) 00000-0000');

        </script>

    </div>
@endsection