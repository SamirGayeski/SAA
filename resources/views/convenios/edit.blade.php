@extends('app')

@section('content')
    <div class="container">
        <h3>Editando convênio: {{$convenio->nome}}</h3>
        <hr size="300" width="100%" align="left">

        @if($errors->any())
            <ul class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        @endif

        {!! Form::open(['route' => ["convenios.update", $convenio->id], 'method'=>'put']) !!}

        <div class="form-group col-md-8">
            {!! Form::label('nome', 'Nome:') !!}
            {!! Form::text('nome', $convenio->nome, ['class'=>'form-control', 'id'=>'nome']) !!}
        </div>

        <div class="form-group col-md-8">
            {!! Form::label('numeroRegistro', 'Número do Registro:') !!}
            {!! Form::number('numeroRegistro', $convenio->numeroRegistro, ['class'=>'form-control', 'id'=>'numeroRegistro']) !!}
        </div>

        <?php
        if (count($planos) != 0){
        ?>
        <div class="form-group">
            <hr size="300" width="100%" align="left">
            <h5>Planos</h5>
            <button type="button" class="btn-sm btn btn-outline-info" data-toggle="modal" data-target=".bs-example-modal-sm" style="font-weight: bold; float:right; margin-bottom: 10px;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Incluir Plano</button>

            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>Descrição</th>
                    <th style="text-align: center; width: 10%">Ação</th>
                </tr>
                </thead>
                <tbody>
                @foreach($planos as $plano)
                    <tr>
                        <td>{{$plano->descricao}}</td>
                        <td style="text-align: center;">
                            <a id="editPlano" data-toggle="modal" data-target="#modalplanoedit" data-id="{{$plano->id}}" data-descricao="{{$plano->descricao}}" class="btn-sm btn-info" id="#modalplano"><i class="fa fa-pencil-square-o" style="color: white;" aria-hidden="true"></i></a>
                            <a onclick="return confirm('O plano {{$plano->descricao}} será removido, deseja continuar ?')" href="{{ route('convenios.destroyplano', ['id'=>$plano->id, 'id_convenio'=>$convenio->id]) }}" class="btn-sm btn-danger"><i class="fa fa-trash-o " aria-hidden="true"></i></a>
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
        <h5>Planos</h5>
            <button data-toggle="modal" data-target="#modalplano" type="button" class="btn-sm btn btn-outline-info" style="font-weight: bold; margin-left: 40%; padding: 5px 30px 5px 30px;">
                <i class="fa fa-plus-circle" aria-hidden="true"></i> Incluir Plano</button>

        <hr size="300" width="100%" align="left">
        <?php
        }
        ?>

        <div class="form-group">
            <a href="{{ route('convenios') }}" class="btn btn-danger">Cancelar</a>
            {!! Form::submit('Salvar', ['class'=>'btn btn-success', 'id'=>'buttons']) !!}
        </div>

        {!! Form::close() !!}

        <div id="modalplano" class="modal bs-example-modal-sm" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content" style="width: 450px;">
                    <div class="modal-header">
                        <h class="modal-title" style="font-weight: 600;" id="gridSystemModalLabel">Plano</h>
                    </div>
                    <div>
                        {!! Form::open(['route' => ["convenios.storeplano", $convenio->id], 'method'=>'put']) !!}
                        <div class="col-md-12">
                            {!! Form::label('descricao', 'Descrição:') !!}
                            {!! Form::text('descricao', null, ['class'=>'form-control']) !!}
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

        <div id="modalplanoedit" class="modal bs-example-modal-sm" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content" style="width: 450px;">
                    <div class="modal-header">
                        <h class="modal-title" style="font-weight: 600;" id="gridSystemModalLabel">Edição plano</h>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['route' => ["convenios.updateplano", 'id'=>'', 'id_convenio'=>$convenio->id], 'method'=>'put']) !!}
                        <div class="col-md-12" style="display: none;">
                            {!! Form::label('id', 'ID:') !!}
                            {!! Form::text('id', '',['class'=>'form-control', 'id'=>'idplano']) !!}
                        </div>
                        <div class="col-md-12">
                            {!! Form::label('descricao', 'Descrição:') !!}
                            {!! Form::text('descricao', '',['class'=>'form-control', 'id'=>'descricaoplano']) !!}
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
            $(document).ready(function () {
                $(document).on("click", "#editPlano", function() {
                    var descricaoplano = $(this).data('descricao');
                    var idplano = $(this).data('id');
                    $(".modal-body #idplano").val(idplano);
                    $(".modal-body #descricaoplano").val(descricaoplano);

                });
            });

        </script>

    </div>
@endsection