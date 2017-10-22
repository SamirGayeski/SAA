@extends('app')

@section('content')
    <div class="container">
        <h3>Histórico de Pacientes</h3>
        <hr size="300" width="100%" align="left">

        {!! Form::open(['route' => 'historicos.search']) !!}

        <div class="row" style="padding: 5px;">
            <div id="select" class="col-md-6">
                {!! Form::label('paciente', 'Paciente:') !!}
                {{ Form::select('paciente', \App\Paciente::orderBy('nome')->pluck('nome','id')->toArray(), null, ['class'=>'form-control', 'placeholder' => 'Selecione um paciente', 'id' => 'paciente']) }}
            </div>
        </div>

        <div class="row" style="padding: 20px;">
            <div class="form-group">
                {!! Form::submit('Buscar Histórico', ['class'=>'btn btn-primary']) !!}
            </div>
        </div>

        {!! Form::close() !!}

    </div>
@endsection