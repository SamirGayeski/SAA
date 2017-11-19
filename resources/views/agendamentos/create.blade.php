@extends('app')

@section('content')
    <div class="container">
        <h3>Novo Agendamento</h3>
        <hr size="300" width="100%" align="left">
        @if($errors->any())
            <ul class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        @endif

        {!! Form::open(['route' => 'agendamentos.store']) !!}

        <div class="row" style="padding: 5px;">
            <div class="col-md-6">
                {!! Form::label('usuario_id', 'Profissional da Saúde:') !!}
                {{ Form::select('usuario_id', \App\Usuario::where('tipoUsuario', '=', 'Profissional da Saúde')->where('situacao', '=', 'Ativo')->orderBy('nome')->pluck('nome','id')->toArray(), null, ['class'=>'form-control', 'placeholder' => 'Selecione um profissional', 'id' => 'usuario']) }}
            </div>
        </div>

        <div class="row" style="padding: 5px;">
            <div class="col-md-6">
                {!! Form::label('paciente_id', 'Paciente:') !!}
                <div class="input-group-btn">
                    {{ Form::select('paciente_id', \App\Paciente::where('situacao', '=', 'Ativo')->orderBy('nome')->pluck('nome','id')->toArray(), null, ['class'=>'form-control', 'placeholder' => 'Selecione um paciente', 'id' => 'paciente']) }}
                    <a href="{{ route('pacientes.create') }}" class="btn-sm btn btn-outline-secondary" style="padding: 7.5px 10px 7.5px 10px;"><i class="fa fa-plus"></i></a>
                </div>
            </div>
        </div>

        <div class="row" style="padding: 5px;">
            <div class="col-md-6">
                {!! Form::label('procedimento_id', 'Procedimento:') !!}
                {{ Form::select('procedimento_id', \App\Procedimento::orderBy('nome')->pluck('nome','id')->toArray(), null, ['class'=>'form-control', 'placeholder' => 'Selecione um procedimento', 'id' => 'procedimento']) }}
            </div>
        </div>

        <div class="row" style="padding: 5px;">
            <div class="col-md-4">
                {!! Form::label('telefone_celular', 'Telefone Celular:') !!}
                {!! Form::text('telefone_celular', null, ['class'=>'form-control', 'readonly', 'id'=>'telefone_celular']) !!}
            </div>
        </div>

        <div class="row" style="padding: 5px;">
            <div class="col-md-4">
                {!! Form::label('telefone_residencial', 'Telefone Residencial:') !!}
                {!! Form::text('telefone_residencial', null, ['class'=>'form-control', 'readonly', 'id'=>'telefone_residencial']) !!}
            </div>
        </div>

        <div class="row" style="padding: 5px;">
            <div class="col-md-4">
                {!! Form::label('convenio', 'Convênio:') !!}
                {{ Form::select('convenio', ['Particular'=>'Particular'], null, ['class'=>'form-control', 'placeholder' => 'Selecione um convênio', 'id' => 'convenio']) }}
            </div>
        </div>

        <div class="row" style="padding: 5px;">
            <div class="col-md-4">
                {!! Form::label('data', 'Data:') !!}
                {!! Form::date('data', null, ['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="row" style="padding: 5px;">
            <div class="col-md-4">
                {!! Form::label('horario', 'Horário:') !!}
                {!! Form::select('horario', \App\Horario::orderBy('horario')->pluck('horario', 'horario')->toArray(), null,['class'=>'form-control', 'placeholder' => 'Selecione um horário', 'id'=>'horario']) !!}
            </div>
        </div>
        <div class="col-md-4" id="choquehorario" style="display: none;">
            <div class="alert alert-danger">
                <strong>Atenção!</strong> Conflito de horários.
            </div>
        </div>

        <div class="row" style="padding: 5px;">
            <div class="col-md-4">
                {!! Form::label('status', 'Status:') !!}
                {!! Form::text('status', 'Agendado', ['class'=>'form-control', 'readonly']) !!}
            </div>
        </div>

        <div class="row" style="padding: 5px;">
            <div class="col-md-6">
                {!! Form::label('observacoes', 'Observações:') !!}
                {{ Form::textarea('observacoes', null, ['class'=>'form-control', 'rows'=>'3']) }}
            </div>
        </div>

        <div class="row" style="padding: 20px;">
            <div class="form-group">
                <a href="{{ route('agendamentos') }}" class="btn-sm btn btn-danger">Cancelar</a>
                {!! Form::submit('Salvar', ['class'=>'btn-sm btn btn-success']) !!}
            </div>
        </div>

        {!! Form::close() !!}

        <script type="text/javascript">

            $(document).ready(function() {

                //carrega convenios
                $('#paciente').on('change', function(e){
                    var paciente_id = e.target.value;

                    $.get('ajax-pacientesinfo?paciente=' + paciente_id, function(data){
                        console.log(data);
                        $('#telefone_celular').empty();
                        $('#telefone_residencial').empty();

                        $.each(data, function (index, pacienteObj) {
                            $('#telefone_celular').val(pacienteObj.telefoneCelular);
                            $('#telefone_residencial').val(pacienteObj.telefoneResidencial);
                        });

                    });

                    $.get('ajax-pacientes?paciente=' + paciente_id, function(data){
                        console.log(data);

                        $('#convenio').empty();

                        if(data.length != 0){
                            $.each(data, function (index, convenioObj) {
                                $('#convenio').append('<option value="' + convenioObj.nome + '">' + convenioObj.nome + '</option>')
                                $('#convenio').append('<option value="Particular">Particular</option>')
                            });
                        } else {
                            $('#convenio').append('<option value="Particular">Particular</option>')
                        }

                    });
                });

                $('#data').change(function(e){
                    var data = e.target.value;
                    var usuario_id = document.getElementById('usuario').value;

                    $.get('ajax-agendamentodata?data=' + data + '&usuario_id=' + usuario_id, function(data){
                        console.log(data);

                        $('#horario').empty();
                        document.getElementById('choquehorario').style = 'display: none;';

                        if(data.length != 0){
                            $('#horario').append('<option value="null">Selecione um horário</option>')
                            $.each(data, function (index, horarioObj) {
                                $('#horario').append('<option value="' + horarioObj.horario + '">' + horarioObj.horario + '</option>')
                            });
                        }

                    });
                });

                $('#usuario').on('change',function(e){
                    var usuario_id = e.target.value;
                    var data = document.getElementById('data').value;

                    $.get('ajax-agendamentodata?data=' + data + '&usuario_id=' + usuario_id, function(data){
                        console.log(data);

                        $('#horario').empty();
                        document.getElementById('choquehorario').style = 'display: none;';

                        if(data.length != 0){
                            $('#horario').append('<option value="null">Selecione um horário</option>')
                            $.each(data, function (index, horarioObj) {
                                $('#horario').append('<option value="' + horarioObj.horario + '">' + horarioObj.horario + '</option>')
                            });
                        }

                    });
                });

              $('#horario').on('change',function(){
                    var horario = document.getElementById('horario').value;
                    var data = document.getElementById('data').value;
                    var usuario_id = document.getElementById('usuario').value;
                    var procedimento_id = document.getElementById('procedimento').value;

                    $.get('ajax-agendamentohorario?data=' + data + '&usuario_id=' + usuario_id + '&horario=' + horario + '&procedimento=' + procedimento_id, function(data){
                        console.log(data);
                        if(data[0] == true) {
                            document.getElementById('choquehorario').style = 'display: block; padding-left: 5px;';
                        } else {
                            document.getElementById('choquehorario').style = 'display: none;';
                        }


                    });
                });

                $('#procedimento').on('change',function(){
                    var horario = document.getElementById('horario').value;
                    var data = document.getElementById('data').value;
                    var usuario_id = document.getElementById('usuario').value;
                    var procedimento_id = document.getElementById('procedimento').value;

                    $.get('ajax-agendamentohorario?data=' + data + '&usuario_id=' + usuario_id + '&horario=' + horario + '&procedimento=' + procedimento_id, function(data){
                        console.log(data);
                        if(data[0] == true) {
                            document.getElementById('choquehorario').style = 'display: block; padding-left: 5px;';
                        } else {
                            document.getElementById('choquehorario').style = 'display: none;';
                        }


                    });
                });
            });

        </script>

    </div>
@endsection