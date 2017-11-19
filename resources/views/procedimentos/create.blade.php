@extends('app')

@section('content')
    <div class="container">
        <h3>Novo Procedimento</h3>
        <hr size="300" width="100%" align="left">

        @if($errors->any())
            <ul class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        @endif

        {!! Form::open(['route' => 'procedimentos.store']) !!}

        <div class="form-group col-md-8">
            {!! Form::label('nome', 'Nome:') !!}
            {!! Form::text('nome', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-8">
            {!! Form::label('duracao', 'Duração:') !!}
            {!! Form::time('duracao', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-8">
            {!! Form::label('descricao', 'Descrição:') !!}
            {!! Form::text('descricao', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-8">
            <a href="{{ route('procedimentos') }}" class="btn-sm btn btn-danger">Cancelar</a>
            {!! Form::submit('Salvar', ['class'=>'btn-sm btn btn-success']) !!}
        </div>

        {!! Form::close() !!}

    </div>
@endsection