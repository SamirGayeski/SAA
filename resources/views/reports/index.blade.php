@extends('app')

@section('content')
    <div class="container">
        <h3><i class="fa fa-files-o" aria-hidden="true"></i> Relatórios</h3>
        <hr size="300" width="100%" align="left">

        <div class="row" style="padding: 5px;">
            <div id="select" class="col-md-5">
                {!! Form::label('rel', 'Escolha o relatório desejado:') !!}
                {{ Form::select('rel', ['agendamentos'=>'Agendamentos', 'atendimentos'=>'Atendimentos', 'pacientes'=>'Pacientes'], null, ['class'=>'form-control', 'style'=>'height: 40px;', 'placeholder' => 'Selecione um relatório', 'id' => 'rel']) }}
            </div>

            <!-- Agendamentos -->
            <div id="agendamento" class="col-md-5" style="display: none;">
                {!! Form::label('status', 'Filtro (status):') !!}
                {{ Form::select('status', ['Agendado'=>'Agendado',
                                           'Aguardando atendimento'=>'Aguardando atendimento',
                                           'Atendido'=>'Atendido',
                                           'Cancelado'=>'Cancelado',
                                           'Confirmado'=>'Confirmado',
                                           'Em andamento'=>'Em andamento',
                                           'Não compareceu'=>'Não compareceu'], null, ['class'=>'form-control', 'style'=>'height: 40px;', 'placeholder' => 'Selecione um status', 'id' => 'status']) }}
            </div>

            <!-- Atendimentos -->
            <div id="datainicial" class="col-md-3" style="display: none;">
                {!! Form::label('datainicial', 'Data Inicial:') !!}
<<<<<<< HEAD
                {!! Form::date('datainicial', null, ['class'=>'form-control', 'id'=>'datainicial']) !!}
=======
                {!! Form::date('datafinal', null, ['class'=>'form-control', 'id'=>'datainicial']) !!}
>>>>>>> b6edc8b7a8144adc2ff6c86127b904ba6b53c1e5
                {!! Form::text('inputinicial', null, ['id'=>'inputinicial', 'style'=>'display: none;']) !!}
            </div>
            <div id="datafinal" class="col-md-3" style="display: none;">
                {!! Form::label('datafinal', 'Data Final:') !!}
                {!! Form::date('datafinal', null, ['class'=>'form-control', 'id'=>'datafinal']) !!}
                {!! Form::text('inputfinal', null, ['id'=>'inputfinal', 'style'=>'display: none;']) !!}
            </div>
        </div>

        <!-- status -->
        <div class="col-md-10" id="statusnull" style="display: none;">
            <div class="alert alert-warning" style="font-style: italic;">
                <strong>Atenção!</strong> Esta opção não possui nenhum registro.
            </div>
        </div>
        <!-- data final maior que inicial -->
        <div class="col-md-11" id="datamaior" style="display: none;">
            <div class="alert alert-warning" style="font-style: italic;">
                <strong>Atenção!</strong> A data final deve ser maior que a data inicial.
            </div>
        </div>
        <!-- intervalo datas sem retorno -->
        <div class="col-md-11" id="datanull" style="display: none;">
            <div class="alert alert-warning" style="font-style: italic;">
                <strong>Atenção!</strong> O intervalo de datas informado não possui registros.
            </div>
        </div>

        <div class="row" id="btn" style="padding: 20px; display: none;">
            <div class="form-group">
                <a class="btn btn-info"><i class="fa fa-share" aria-hidden="true"></i> Gerar Relatório</a>
            </div>
        </div>

        {!! Form::close() !!}

        <script type="text/javascript">
            $(document).ready(function() {
                window.onload = function(){
                    var index = document.getElementById('rel').selectedIndex;
                    var rel = document.getElementById('rel').options[index].value;

                    var indexstatus = document.getElementById('status').selectedIndex;
                    var status = document.getElementById('status').options[indexstatus].value;

                    var datafinal = document.getElementById('inputfinal').value;
                    var datainicial = document.getElementById('inputinicial').value;

                    if (rel == 'agendamentos') {
                        document.getElementById('agendamento').style = '';
                        document.getElementById('datainicial').style = 'display: none;';
                        document.getElementById('datafinal').style = 'display: none;';
                        document.getElementById('btn').style = 'padding: 20px;';
                        $('#btn a').attr('href', 'relatorios/'+status+'/agendamentos');

                    } else if(rel == 'atendimentos') {
                        document.getElementById('agendamento').style = 'display: none;';
                        document.getElementById('datainicial').style = '';
                        document.getElementById('datafinal').style = '';

                        if(datafinal != ""){
                            document.getElementById('btn').style = 'padding: 20px;';
                            $('#btn a').attr('href', 'relatorios/'+datainicial+'/'+datafinal+'/atendimentos');
                        } else if(datainicial != ""){
                            document.getElementById('btn').style = 'padding: 20px;';
                            $('#btn a').attr('href', 'relatorios/'+datainicial+'/'+datafinal+'/atendimentos');
                        } else {
                            document.getElementById('btn').style = 'padding: 20px; display: none;';
                        }

                    } else if (rel == 'pacientes') {
                        document.getElementById('agendamento').style = 'display: none;';
                        document.getElementById('datainicial').style = 'display: none;';
                        document.getElementById('datafinal').style = 'display: none;';
                        document.getElementById('btn').style = 'padding: 20px;';
                        $('#btn a').attr('href', 'relatorios/pacientes');
                    } else {
                        document.getElementById('agendamento').style = 'display: none;';
                        document.getElementById('datainicial').style = 'display: none;';
                        document.getElementById('datafinal').style = 'display: none;';
                    }

                };
                $('#rel').on('change', function(e){
                    var rel = e.target.value;
                    if (rel == 'agendamentos') {
                        document.getElementById('agendamento').style = '';
                        document.getElementById('datainicial').style = 'display: none;';
                        document.getElementById('datafinal').style = 'display: none;';
                        document.getElementById('btn').style = 'padding: 20px; display: none;';
                    } else if(rel == 'atendimentos') {
                        document.getElementById('agendamento').style = 'display: none;';
                        document.getElementById('datainicial').style = '';
                        document.getElementById('datafinal').style = '';
                        document.getElementById('statusnull').style = 'display: none;';
                        document.getElementById('datanull').style = 'display: none;';
                        document.getElementById('btn').style = 'padding: 20px; display: none;';
                    } else if (rel == 'pacientes') {
                        document.getElementById('agendamento').style = 'display: none;';
                        document.getElementById('datainicial').style = 'display: none;';
                        document.getElementById('datafinal').style = 'display: none;';
                        document.getElementById('statusnull').style = 'display: none;';
                        document.getElementById('datanull').style = 'display: none;';
                        document.getElementById('btn').style = 'padding: 20px;';
                        $('#btn a').attr('href', 'relatorios/pacientes');
                    } else {
                        document.getElementById('agendamento').style = 'display: none;';
                        document.getElementById('datainicial').style = 'display: none;';
                        document.getElementById('datafinal').style = 'display: none;';
                        document.getElementById('statusnull').style = 'display: none;';
                        document.getElementById('datanull').style = 'display: none;';
                        document.getElementById('btn').style = 'padding: 20px; display: none;';
                    }
                });

                $('#status').on('change', function(e) {
                    var status = e.target.value;

                    $.get('relatorios/ajax-reportsagendamento?status=' + status, function(data){
                        console.log(data);
                        if(data[0] == false) {
                            document.getElementById('statusnull').style = 'display: block; padding: 5px;';
                            document.getElementById('btn').style = 'padding: 20px; display: none;';
                        } else {
                            document.getElementById('statusnull').style = 'display: none;';
                            document.getElementById('btn').style = 'padding: 20px;';
                            $('#btn a').attr('href', 'relatorios/'+status+'/agendamentos');
                        }
                    });
                });

                $('#datainicial').on('change', function(e) {
                    var datainicial = e.target.value;
                    var datafinal = document.getElementById('inputfinal').value;
                    document.getElementById('inputinicial').value = datainicial;

                    if(datainicial > datafinal && datafinal != ""){
                        document.getElementById('datamaior').style = 'display: block; padding: 5px;';
                    } else {
                        document.getElementById('datamaior').style = 'display: none;';
                    }

                    if(datafinal != "" && datainicial < datafinal){

                        $.get('relatorios/ajax-reportsatendimento?datainicial=' + datainicial + '&datafinal=' + datafinal, function(data) {
                            console.log(data);
                            if(data[0] == false) {
                                document.getElementById('datanull').style = 'display: block; padding: 5px;';
                            } else {
                                document.getElementById('datanull').style = 'display: none; padding: 5px;';
                                document.getElementById('btn').style = 'padding: 20px;';
                                $('#btn a').attr('href', 'relatorios/'+datainicial+'/'+datafinal+'/atendimentos');
                            }
                        });

                    } else {
                        document.getElementById('btn').style = 'padding: 20px; display: none;';
                    }

                });

                $('#datafinal').on('change', function(e) {
                    var datafinal = e.target.value;
                    var datainicial = document.getElementById('inputinicial').value;
                    document.getElementById('inputfinal').value = datafinal;

                    if(datainicial > datafinal && datainicial != ""){
                        document.getElementById('datamaior').style = 'display: block; padding: 5px;';
                    } else {
                        document.getElementById('datamaior').style = 'display: none;';
                    }

                    if(datainicial != "" && datainicial < datafinal){

                        $.get('relatorios/ajax-reportsatendimento?datainicial=' + datainicial + '&datafinal=' + datafinal, function(data) {
                            console.log(data);
                            if(data[0] == false) {
                                document.getElementById('datanull').style = 'display: block; padding: 5px;';
                            } else {
                                document.getElementById('datanull').style = 'display: none; padding: 5px;';
                                document.getElementById('btn').style = 'padding: 20px;';
                                $('#btn a').attr('href', 'relatorios/'+datainicial+'/'+datafinal+'/atendimentos');
                            }
                        });

                    } else {
                        document.getElementById('btn').style = 'padding: 20px; display: none;';
                    }
                });

                $('#datainicial').on('focusout', function(e) {
                    var datainicial = e.target.value;
                    var datafinal = document.getElementById('inputfinal').value;
                    document.getElementById('inputinicial').value = datainicial;

                    if(datainicial > datafinal && datafinal != ""){
                        document.getElementById('datamaior').style = 'display: block; padding: 5px;';
                    } else {
                        document.getElementById('datamaior').style = 'display: none;';
                    }

                    if(datafinal != "" && datainicial < datafinal){

                        $.get('relatorios/ajax-reportsatendimento?datainicial=' + datainicial + '&datafinal=' + datafinal, function(data) {
                            console.log(data);
                            if(data[0] == false) {
                                document.getElementById('datanull').style = 'display: block; padding: 5px;';
                            } else {
                                document.getElementById('datanull').style = 'display: none; padding: 5px;';
                                document.getElementById('btn').style = 'padding: 20px;';
                                $('#btn a').attr('href', 'relatorios/'+datainicial+'/'+datafinal+'/atendimentos');
                            }
                        });

                    } else {
                        document.getElementById('btn').style = 'padding: 20px; display: none;';
                    }

                });

                $('#datafinal').on('focusout', function(e) {
                    var datafinal = e.target.value;
                    var datainicial = document.getElementById('inputinicial').value;
                    document.getElementById('inputfinal').value = datafinal;

                    if(datainicial > datafinal && datainicial != ""){
                        document.getElementById('datamaior').style = 'display: block; padding: 5px;';
                    } else {
                        document.getElementById('datamaior').style = 'display: none;';
                    }

                    if(datainicial != "" && datainicial < datafinal){

                        $.get('relatorios/ajax-reportsatendimento?datainicial=' + datainicial + '&datafinal=' + datafinal, function(data) {
                            console.log(data);
                            if(data[0] == false) {
                                document.getElementById('datanull').style = 'display: block; padding: 5px;';
                            } else {
                                document.getElementById('datanull').style = 'display: none; padding: 5px;';
                                document.getElementById('btn').style = 'padding: 20px;';
                                $('#btn a').attr('href', 'relatorios/'+datainicial+'/'+datafinal+'/atendimentos');
                            }
                        });

                    } else {
                        document.getElementById('btn').style = 'padding: 20px; display: none;';
                    }
                });

            });
        </script>

    </div>
@endsection