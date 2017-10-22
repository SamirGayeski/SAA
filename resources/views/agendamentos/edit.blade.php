@extends('app')

@section('content')
    <div class="container">
        <?php
        if($agendamento->status == 'Agendado'){
            $color = '#58ACFA'; //azul
        }else if($agendamento->status == 'Confirmado'){
            $color = '#D8D8D8'; //cinza
        }else if($agendamento->status == 'Cancelado'){
            $color = '#FA5858'; //vermelho
        }else if($agendamento->status == 'Aguardando atendimento'){
            $color = '#F5A9F2'; //lilas
        }else if($agendamento->status == 'Não compareceu'){
            $color = '#F7BE81'; //laranja
        }else if($agendamento->status == 'Atendido'){
            $color = '#A9F5A9'; //verde
        }else if($agendamento->status == 'Em andamento'){
            $color = '#F4FA58'; //amarelo
            $andamento = 'readonly';
        }
         ?>
        <h3>
            <svg height="25" width="25">
                <circle cx="15" cy="15" r="10" stroke-width="3" fill="<?php echo $color ?>" />
            </svg>
            Edição Agendamento
            @if($agendamento->status == 'Cancelado' or $agendamento->status == 'Não compareceu' or $agendamento->status == 'Em andamento')
            @else
                <a href="{{ route('atendimentos.create', ['id'=>$agendamento->id]) }}" class="btn-sm btn btn-success" style="float: right; padding: 5px 25px 5px 25px; font-size: 15px; margin-top: 7px; margin-right: 7px;"><i class="fa fa-user-md" aria-hidden="true"></i> Atender Paciente</a>
            @endif
        </h3>
        <hr size="300" width="100%" align="left">
        @if($errors->any())
            <ul class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        @endif

        {!! Form::open(['route' => ["agendamentos.update", $agendamento->id], 'method'=>'put']) !!}

        <div class="row" style="display: none;">
              {{ Form::text('id', $agendamento->id, ['class'=>'form-control', 'id' => 'agendamento_id']) }}
        </div>

        <div class="row" style="padding: 5px;">
            <div class="col-md-6">
                {!! Form::label('usuario_id', 'Profissional da Saúde:') !!}
                {{ Form::select('usuario_id', \App\Usuario::where('tipoUsuario', '=', 'Profissional da Saúde')->where('situacao', '=', 'Ativo')->orderBy('nome')->pluck('nome','id')->toArray(), $agendamento->usuario_id, ['class'=>'form-control', 'placeholder' => 'Selecione um profissional', 'id' => 'usuario', 'style'=>'height: 40px;']) }}
            </div>
        </div>

        <div class="row" style="padding: 5px;">
            <div class="col-md-6">
                {!! Form::label('paciente_id', 'Paciente:') !!}
                <div class="input-group-btn">
                    {{ Form::select('paciente_id', \App\Paciente::where('situacao', '=', 'Ativo')->orderBy('nome')->pluck('nome','id')->toArray(), $agendamento->paciente_id, ['class'=>'form-control', 'placeholder' => 'Selecione um paciente', 'id' => 'paciente', 'style'=>'height: 40px;']) }}
                    <a href="{{ route('pacientes.create') }}" class="btn-sm btn btn-outline-secondary" style="padding: 8.5px 10px 8px 10px;"><i class="fa fa-plus"></i></a>
                </div>
            </div>
        </div>

        <div class="row" style="padding: 5px;">
            <div class="col-md-6">
                {!! Form::label('procedimento_id', 'Procedimento:') !!}
                {{ Form::select('procedimento_id', \App\Procedimento::orderBy('nome')->pluck('nome','id')->toArray(), $agendamento->procedimento_id, ['class'=>'form-control', 'placeholder' => 'Selecione um procedimento', 'id' => 'procedimento', 'style'=>'height: 40px;']) }}
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
        <?php
        if($agendamento->convenio == 'Particular'){
            $buscaconvenio = [$agendamento->convenio=>$agendamento->convenio] + \App\Convenio::where('id', '=', $agendamento->paciente->convenio_id)->pluck('nome','id')->toArray();
        } else {
            $buscaconvenio = ['Particular'=>'Particular', $agendamento->convenio=>$agendamento->convenio];
        }
        ?>
        <div class="row" style="padding: 5px;">
            <div class="col-md-4">
                {!! Form::label('convenio', 'Convênio:') !!}
                {{ Form::select('convenio', $buscaconvenio, $agendamento->convenio, ['class'=>'form-control', 'placeholder' => 'Selecione um convênio', 'id' => 'convenio']) }}
            </div>
        </div>

        <div class="row" style="padding: 5px;">
            <div class="col-md-4">
                {!! Form::label('data', 'Data:') !!}
                {!! Form::date('data', $agendamento->data, ['class'=>'form-control', 'id' => 'data']) !!}
            </div>
        </div>

        <div class="row" style="padding: 5px;">
            <div class="col-md-4">
                {!! Form::label('horario', 'Horário:') !!}
                {!! Form::select('horario', \App\Horario::orderBy('horario')->pluck('horario', 'horario')->toArray(),$agendamento->horario, ['class'=>'form-control', 'placeholder' => 'Selecione um horário', 'id'=>'horario']) !!}
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
                {!! Form::select('status', array('Agendado' => 'Agendado',
                                                      'Aguardando atendimento' => 'Aguardando atendimento',
                                                      'Cancelado' => 'Cancelado',
                                                      'Confirmado' => 'Confirmado',
                                                      'Não compareceu' => 'Não compareceu'),
                                                      $agendamento->status, ['class'=>'form-control', 'style'=>'height: 40px;']) !!}
            </div>
        </div>

        <div class="row" style="padding: 5px;">
            <div class="col-md-6">
                {!! Form::label('observacoes', 'Observações:') !!}
                {{ Form::textarea('observacoes', $agendamento->observacoes, ['class'=>'form-control', 'rows'=>'3']) }}
            </div>
        </div>

        <div class="row" style="padding: 20px;">
            <div class="form-group">
                <a href="{{ route('agendamentos') }}" class="btn btn-danger">Cancelar</a>
                {!! Form::submit('Salvar', ['class'=>'btn btn-success']) !!}
            </div>
        </div>

        {!! Form::close() !!}

        <script type="text/javascript">

            $(document).ready(function() {

                $('#paciente').on('change', function(e){
                    var paciente_id = e.target.value;

                    //carrega contatos event change
                    $.get('ajax-pacientesinfo?paciente=' + paciente_id, function(data){
                        console.log(data);
                        $('#telefone_celular').empty();
                        $('#telefone_residencial').empty();

                        $.each(data, function (index, pacienteObj) {
                            $('#telefone_celular').val(pacienteObj.telefoneCelular);
                            $('#telefone_residencial').val(pacienteObj.telefoneResidencial);
                        });

                    });

                    //carrega convenios event change
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
                    var agendamento_id = document.getElementById('agendamento_id').value;

                    $.get('ajax-agendamentodata?data=' + data + '&usuario_id=' + usuario_id + '&agendamento_id=' + agendamento_id, function(data){
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
                    var agendamento_id = document.getElementById('agendamento_id').value;

                    $.get('ajax-agendamentodata?data=' + data + '&usuario_id=' + usuario_id + '&agendamento_id=' + agendamento_id, function(data){
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
                    var agendamento_id = document.getElementById('agendamento_id').value;

                    $.get('ajax-agendamentohorario?data=' + data + '&usuario_id=' + usuario_id + '&horario=' + horario + '&procedimento=' + procedimento_id + '&agendamento_id=' + agendamento_id, function(data){
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
                    var agendamento_id = document.getElementById('agendamento_id').value;

                    $.get('ajax-agendamentohorario?data=' + data + '&usuario_id=' + usuario_id + '&horario=' + horario + '&procedimento=' + procedimento_id + '&agendamento_id=' + agendamento_id, function(data){
                        console.log(data);
                        if(data[0] == true) {
                            document.getElementById('choquehorario').style = 'display: block; padding-left: 5px;';
                        } else {
                            document.getElementById('choquehorario').style = 'display: none;';
                        }


                    });
                });

                window.onload = function(){
                    var index = document.getElementById('paciente').selectedIndex;
                    var paciente_id = document.getElementById('paciente').options[index].value;

                    //carrega contatos ao abrir page
                    $.get('ajax-pacientesinfo?paciente=' + paciente_id, function(data){
                        console.log(data);
                        $('#telefone_celular').empty();
                        $('#telefone_residencial').empty();

                        $.each(data, function (index, pacienteObj) {
                            $('#telefone_celular').val(pacienteObj.telefoneCelular);
                            $('#telefone_residencial').val(pacienteObj.telefoneResidencial);
                        });

                    });

                }
            });

        </script>

    </div>
@endsection