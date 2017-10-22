@extends('app')

@section('content')
    <div class="container">
        <h3>Editando cidade: {{$cidade->nome}}</h3>
        <hr size="300" width="100%" align="left">

        @if($errors->any())
            <ul class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        @endif

        {!! Form::open(['route' => ["cidades.update", $cidade->id], 'method'=>'put']) !!}

        <div class="form-group col-md-8">
            {!! Form::label('nome', 'Nome:') !!}
            {!! Form::text('nome', $cidade->nome, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-8">
            {!! Form::label('uf', 'UF:') !!}
            {!! Form::text('uf', $cidade->uf, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-8">
            <a href="{{ route('cidades') }}" class="btn btn-danger">Cancelar</a>
            {!! Form::submit('Salvar', ['class'=>'btn btn-success']) !!}
        </div>

        {!! Form::close() !!}

    </div>
@endsection