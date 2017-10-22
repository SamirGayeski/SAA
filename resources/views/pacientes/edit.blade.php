@extends('app')

@section('content')
    <div class="container">
        <div class="row" style="margin: 10px 0px 10px 0px;">
            <div class="col-md-4" style="margin-top: 15px;">
                <h style="float: left; font-size: 12px; color: #1f648b;">*Dados Obrigatórios</h>
            </div>
            <div class="col-md-8">
                <h3 style="float: right;">Editando paciente: {{$paciente->nome}}</h3>
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

        {!! Form::open(['route' => ["pacientes.update", $paciente->id], 'method'=>'put']) !!}

        <h5>Dados Pessoais:</h5>
        <div class="row" style="padding: 5px;">
            <div class="col-md-6">
                {!! Form::label('nome', 'Nome: *') !!}
                {!! Form::text('nome', $paciente->nome, ['class'=>'form-control']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('dataNascimento', 'Data de Nascimento: *') !!}
                {!! Form::date('dataNascimento', $paciente->dataNascimento, ['class'=>'form-control']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('sexo', 'Sexo: *') !!}
                {!! Form::select('sexo', array('Masculino' => 'Masculino', 'Feminino' => 'Feminino'), $paciente->sexo, ['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="row" style="padding: 5px;">
            <div class="col-md-8">
                {!! Form::label('email', 'Email:') !!}
                {!! Form::text('email', $paciente->email, ['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="row" style="padding: 5px;">
            <div class="col-md-4">
                {!! Form::label('telefoneCelular', 'Telefone Celular: *') !!}
                {!! Form::text('telefoneCelular', $paciente->telefoneCelular, ['class'=>'form-control']) !!}
            </div>
            <div class="col-md-4">
                {!! Form::label('telefoneResidencial', 'Telefone Residencial:') !!}
                {!! Form::text('telefoneResidencial', $paciente->telefoneResidencial, ['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="row" style="padding: 5px;">
            <div class="col-md-4">
                {!! Form::label('cpf', 'CPF: *') !!}
                {!! Form::text('cpf', $paciente->cpf, ['class'=>'form-control']) !!}
            </div>

            <div class="col-md-4">
                {!! Form::label('rg', 'RG: *') !!}
                {!! Form::text('rg', $paciente->rg, ['class'=>'form-control']) !!}
            </div>
        </div>

        <hr size="300" width="100%" align="left" style="padding: 5px;">

        <h5>Endereço</h5>
        <div class="row" style="padding: 5px;">
            <div class="col-md-5">
                {!! Form::label('endereco', 'Rua/Avenida: *') !!}
                {!! Form::text('endereco', $paciente->endereco, ['class'=>'form-control']) !!}
            </div>
            <div class="col-md-4">
                {!! Form::label('bairro', 'Bairro: *') !!}
                {!! Form::text('bairro', $paciente->bairro, ['class'=>'form-control']) !!}
            </div>
            <div class="col-md-3">
                {!! Form::label('numero', 'Número: *') !!}
                {!! Form::text('numero', $paciente->numero, ['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="row" style="padding: 5px;">

            <div class="col-md-5">
                {!! Form::label('complemento', 'Complemento:') !!}
                {!! Form::text('complemento', $paciente->complemento, ['class'=>'form-control']) !!}
            </div>
            <div class="col-md-2">
                {!! Form::label('estado', 'Estado: *') !!}
                {{ Form::select('estado', \App\Cidade::orderBy('uf')->distinct('uf')->pluck('uf', 'uf')->toArray(), \App\Cidade::where('id', '=', $paciente->cidade_id)->pluck('uf'), ['class'=>'form-control', 'placeholder' => 'UF', 'id'=>'uf']) }}
            </div>
            <div class="col-md-5">
                {!! Form::label('cidade', 'Cidade: *') !!}
                {{ Form::select('cidade_id', \App\Cidade::orderBy('nome')->pluck('nome','id')->toArray(), $paciente->cidade_id, ['class'=>'form-control', 'placeholder' => 'Selecione uma cidade', 'id'=>'cidade']) }}
            </div>
        </div>

        <hr size="300" width="100%" align="left" style="padding: 5px;">

        <h5>Complemento</h5>
        <div class="row" style="padding: 5px;">
            <div class="col-md-4">
                {!! Form::label('estadoCivil', 'Estado Civil:') !!}
                {!! Form::select('estadoCivil', array('Solteiro (a)' => 'Solteiro (a)',
                                                      'Casado (a)' => 'Casado (a)',
                                                      'Viúvo (a)' => 'Viúvo (a)',
                                                      'Divorciado (a)' => 'Divorciado (a)',
                                                      'Separado (a)' => 'Separado (a)'),
                                                      $paciente->estadoCivil, ['class'=>'form-control']) !!}
            </div>
            <div class="col-md-4">
                {!! Form::label('profissao', 'Profissão:') !!}
                {!! Form::text('profissao', $paciente->profissao, ['class'=>'form-control']) !!}
            </div>
        </div>


        <?php
        if ($paciente->situacao == 'Ativo'){
            $ativo = 'true';
            $inativo = '';
        } else if ($paciente->situacao == 'Inativo') {
            $ativo = '';
            $inativo = 'true';
        }
        ?>
        <div class="row" style="padding: 5px;">
            <div class="col-md-4">
                {!! Form::label('situacao', 'Situação:') !!}
                <br/>
                <label class="checkbox-inline">
                    {!! Form::radio('situacao', 'Ativo', $ativo) !!}
                    Ativo</label>&nbsp;&nbsp;
                <label class="checkbox-inline">
                    {!! Form::radio('situacao', 'Inativo', $inativo) !!}
                    Inativo</label>
            </div>
        </div>

        <hr size="300" width="100%" align="left" style="padding: 5px;">
        <h5>Convênio</h5>

        <div id="cns" class="row" style="padding: 5px;">
            <div class="col-md-6">
                {!! Form::label('cns', 'CNS:') !!}
                {!! Form::text('cns', $paciente->cns, ['class'=>'form-control']) !!}
            </div>
        </div>

        <div id="select" class="row" style="padding: 5px;">
            <div class="col-md-6">
                {!! Form::label('convenio_id', 'Convênio:') !!}
                {{ Form::select('convenio_id', [null => 'Nenhum'] + \App\Convenio::orderBy('nome')->pluck('nome','id')->toArray(), $paciente->convenio_id, ['class'=>'form-control', 'placeholder' => 'Selecione um convênio', 'id'=>'convenio']) }}
            </div>
        </div>

        <div id="infoconvenio" class="row" style="padding: 5px; display: none;">
            <div class="col-md-3">
                {!! Form::label('plano_id', 'Plano:') !!}
                {{ Form::select('plano_id', \App\Plano::orderBy('descricao')->where('convenio_id', '=', $paciente->convenio_id)->pluck('descricao','id')->toArray(), $paciente->plano_id, ['class'=>'form-control', 'placeholder' => 'Selecione um plano', 'id'=>'plano']) }}
            </div>

            <div class="col-md-3">
                {!! Form::label('numeroCarteirinha', 'Número Carteirinha:') !!}
                {!! Form::text('numeroCarteirinha', $paciente->numeroCarteirinha, ['class'=>'form-control']) !!}
            </div>

            <div class="col-md-3">
                {!! Form::label('validade', 'Validade:') !!}
                {!! Form::date('validade', $paciente->validade, ['class'=>'form-control']) !!}
            </div>

            <div class="col-md-3">
                {!! Form::label('acomodacao', 'Acomodação:') !!}
                {!! Form::text('acomodacao', $paciente->acomodacao, ['class'=>'form-control']) !!}
            </div>
        </div>

        <?php
        if (count($dadosfamiliar) != 0){
        ?>
        <div class="form-group">
            <hr size="300" width="100%" align="left" style="padding: 5px;">
            <h5>Dados Familiar</h5>
            <button type="button" class="btn-sm btn btn-outline-info" data-toggle="modal" data-target=".bs-example-modal-sm" style="font-weight: bold; float:right; margin-bottom: 10px;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Incluir Familiar</button>

            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Parentesco</th>
                    <th>Telefone</th>
                    <th style="text-align: center; width: 10%">Ação</th>
                </tr>
                </thead>
                <tbody>
                @foreach($dadosfamiliar as $dfamiliar)
                    <tr>
                        <td>{{$dfamiliar->nome}}</td>
                        <td>{{$dfamiliar->parentesco}}</td>
                        <td>{{$dfamiliar->telefone}}</td>
                        <td style="text-align: center;">
                            <a id="editDadosFamiliar" data-toggle="modal" data-target="#modaldadosfamiliaredit" data-id="{{$dfamiliar->id}}" data-nome="{{$dfamiliar->nome}}" data-parentesco="{{$dfamiliar->parentesco}}" data-telefone="{{$dfamiliar->telefone}}" class="btn-sm btn-info" id="#modaldadosfamiliar"><i class="fa fa-pencil-square-o" style="color: white;" aria-hidden="true"></i></a>
                            <a onclick="return confirm('O familiar {{$dfamiliar->nome}} será removido, deseja continuar ?')" href="{{ route('pacientes.destroyfamiliar', ['id'=>$dfamiliar->id, 'id_paciente'=>$paciente->id]) }}" class="btn-sm btn-danger"><i class="fa fa-trash-o " aria-hidden="true"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <hr size="300" width="100%" align="left" style="padding: 5px;">
        </div>

        <?php
        } else {
        ?>
        <hr size="300" width="100%" align="left">
        <h5>Dados Familiar</h5>
        <button data-toggle="modal" data-target="#modaldadosfamiliar" type="button" class="btn-sm btn btn-outline-info" style="font-weight: bold; margin-left: 40%; padding: 5px 30px 5px 30px;">
            <i class="fa fa-plus-circle" aria-hidden="true"></i> Incluir Familiar</button>

        <hr size="300" width="100%" align="left">
        <?php
        }
        ?>

        <div class="row" style="padding: 20px;">
            <div class="form-group">
                <a href="{{ route('pacientes') }}" class="btn btn-danger">Cancelar</a>
                {!! Form::submit('Salvar', ['class'=>'btn btn-success']) !!}
            </div>
        </div>

        {!! Form::close() !!}

        <div id="modaldadosfamiliar" class="modal bs-example-modal-sm" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content" style="width: 450px;">
                    <div class="modal-header">
                        <h class="modal-title" style="font-weight: 600;" id="gridSystemModalLabel">Plano</h>
                    </div>
                    <div>
                        {!! Form::open(['route' => ["pacientes.storefamiliar", $paciente->id], 'method'=>'put']) !!}
                        <div class="col-md-12">
                            {!! Form::label('nomeFamiliar', 'Nome:') !!}
                            {!! Form::text('nomeFamiliar', null, ['class'=>'form-control']) !!}
                        </div>
                        <div class="col-md-12">
                            {!! Form::label('parentesco', 'Parentesco:') !!}
                            {!! Form::text('parentesco', null, ['class'=>'form-control']) !!}
                        </div>
                        <div class="col-md-12">
                            {!! Form::label('telefone', 'Telefone:') !!}
                            {!! Form::text('telefone', null, ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group" style="margin: 15px 15px 15px 0px; float: right;">
                            <button type="button" class="btn btn-danger" class="close" data-dismiss="modal">Cancelar</button>
                            {!! Form::submit('Salvar', ['class'=>'btn btn-success', 'id'=>'buttons']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>

        <div id="modaldadosfamiliaredit" class="modal bs-example-modal-sm" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content" style="width: 450px;">
                    <div class="modal-header">
                        <h class="modal-title" style="font-weight: 600;" id="gridSystemModalLabel">Edição familiar</h>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['route' => ["pacientes.updatefamiliar", 'id'=>'', 'id_paciente'=>$paciente->id], 'method'=>'put']) !!}
                        <div class="col-md-12" style="display: none;">
                            {!! Form::label('id', 'ID:') !!}
                            {!! Form::text('id', '',['class'=>'form-control', 'id'=>'idfamiliar']) !!}
                        </div>
                        <div class="col-md-12">
                            {!! Form::label('nome', 'Nome:') !!}
                            {!! Form::text('nome', '',['class'=>'form-control', 'id'=>'nome']) !!}
                        </div>
                        <div class="col-md-12">
                            {!! Form::label('parentesco', 'Parentesco:') !!}
                            {!! Form::text('parentesco', '',['class'=>'form-control', 'id'=>'parentesco']) !!}
                        </div>
                        <div class="col-md-12">
                            {!! Form::label('telefone', 'Telefone:') !!}
                            {!! Form::text('telefone', '',['class'=>'form-control', 'id'=>'telefone']) !!}
                        </div>
                        <div class="form-group" style="margin: 15px 15px 15px 0px; float: right;">
                            <button type="button" class="btn btn-danger" class="close" data-dismiss="modal">Cancelar</button>
                            {!! Form::submit('Salvar', ['class'=>'btn btn-success', 'id'=>'buttons']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>

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

                window.onload = function(){
                    var index = document.getElementById('convenio').selectedIndex;
                    var convenio_id = document.getElementById('convenio').options[index].value;
                    if(convenio_id == '') {
                        document.getElementById('infoconvenio').style = 'padding: 5px; display: none;';
                    } else {
                        document.getElementById('infoconvenio').style = 'padding: 5px; display: flex;';
                    }

                    var indexplano = document.getElementById('plano').selectedIndex;
                    var plano_id = document.getElementById('plano').options[index].value;
                    if(plano_id != '') {
                        $('#plano').each(function () {
                            // se localizar id, define o atributo selected
                            if ($(this).value() == plano_id) {
                                $(this).attr('selected', true);
                            }
                        });
                    }
                };

                $('#convenio').on('change', function(e){
                    var convenio_id = e.target.value;
                    $.get('ajax-planos?convenio=' + convenio_id, function(data){
                        console.log(data);
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

                $(document).on("click", "#editDadosFamiliar", function() {
                    var idfamiliar = $(this).data('id');
                    var nomefamiliar = $(this).data('nome');
                    var parentesco = $(this).data('parentesco');
                    var telefone = $(this).data('telefone');
                    $(".modal-body #idfamiliar").val(idfamiliar);
                    $(".modal-body #nome").val(nomefamiliar);
                    $(".modal-body #parentesco").val(parentesco);
                    $(".modal-body #telefone").val(telefone);

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