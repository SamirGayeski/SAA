@extends('app')

@section('content')
    <div class="container">
        <h3>Nova Cidade</h3>
        <hr size="300" width="100%" align="left">

        @if($errors->any())
            <ul class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        @endif

        {!! Form::open(['route' => 'cidades.store']) !!}

        <div class="form-group col-md-8">
            {!! Form::label('nome', 'Nome:') !!}
            {!! Form::text('nome', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-8">
            {!! Form::label('uf', 'UF:') !!}
            {!! Form::text('uf', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-8">
            <a href="{{ route('cidades') }}" class="btn btn-danger">Cancelar</a>
            {!! Form::submit('Salvar', ['class'=>'btn btn-success']) !!}
        </div>

        {!! Form::close() !!}

    </div>
@endsection