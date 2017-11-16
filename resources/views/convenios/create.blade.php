@extends('app')

@section('content')
    <div class="container">
        <h3>Novo Convênio</h3>
        <hr size="300" width="100%" align="left">

        @if($errors->any())
            <ul class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        @endif

        {!! Form::open(['route' => 'convenios.store']) !!}

        <div class="form-group col-md-8">
            {!! Form::label('nome', 'Nome:') !!}
            {!! Form::text('nome', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-8">
            {!! Form::label('numeroRegistro', 'Número do Registro:') !!}
            {!! Form::number('numeroRegistro', null, ['class'=>'form-control']) !!}
        </div>

        <hr size="300" width="100%" align="left">

        <h5>Planos</h5>
        <button id="planos" type="button" class="btn-sm btn btn-outline-info" style="font-weight: bold; margin-left: 40%; padding: 5px 30px 5px 30px;">
            <i class="fa fa-plus-circle" aria-hidden="true"></i> Incluir Plano</button>

        <div id="plano_descricao" style="display: none;" class="form-group col-md-6">
            {!! Form::label('descricao', 'Descrição:') !!}
            {!! Form::text('descricao', null, ['class'=>'form-control']) !!}
        </div>

        <hr size="300" width="100%" align="left">

        <div class="form-group">
            <a href="{{ route('convenios') }}" class="btn-sm btn btn-danger">Cancelar</a>
            {!! Form::submit('Salvar', ['class'=>'btn-sm btn btn-success']) !!}
        </div>

        {!! Form::close() !!}

        <script type="text/javascript">
            $(document).ready(function() {
                $('#planos').click(function(){
                    document.getElementById('planos').style = 'display: none;';
                    document.getElementById('plano_descricao').style = 'display: block;';
                });
            });
        </script>

    </div>
@endsection