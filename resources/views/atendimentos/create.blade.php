@extends('app')

@section('content')
    <div class="container">
        <script>

            var segundo = 0+"0";
            var minuto = 0+"0";
            var hora = 0+"0";

            function tempo(){
                if (segundo < 59){
                    segundo++;
                    if(segundo < 10){segundo = "0"+segundo}
                }else
                if(segundo == 59 && minuto < 59){
                    segundo = 0+"0";
                    minuto++;
                    if(minuto < 10){minuto = "0"+minuto}
                }
                if(minuto == 59 && segundo == 59 && hora < 23){
                    segundo = 0+"0";
                    minuto = 0+"0";
                    hora++;
                    if(hora < 10){hora = "0"+hora}
                }else
                if(minuto == 59 && segundo == 59 && hora == 23){
                    segundo = 0+"0";
                    minuto = 0+"0";
                    hora = 0+"0";
                }
                document.getElementById('duracaoAtendimento').value = hora + ":" + minuto + ":" + segundo;
                timercount = setTimeout("tempo()", 983);
            }
            window.onload = function(){
                tempo();
            }
        </script>
        <?php
        function calcula_idade($data_nascimento) {
            $data_nasc = explode('-', $data_nascimento);
            $data = date('Y-m-d');
            $data = explode("-", $data);
            $anos = $data[0] - $data_nasc[0];

            if ($data_nasc[1] >= $data[1]){
                if ($data_nasc[2] <= $data[2]){
                    return $anos;
                } else {
                    return $anos-1;
                }
            } else {
                return $anos;
            }
        }
        ?>

        @if($errors->any())
            <ul class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        @endif

        {!! Form::open(['route' => 'atendimentos.store']) !!}

        <h3>Atendimento
            <div class="row" style="float: right;">
                <div class="col-md-6">
                    <div class="input-group-btn">
                        <div class="input-group-addon" style="padding: 10px 12px 10px 12px; background-color: white;"><i class="fa fa-clock-o"></i></div>
                        {!! Form::text('duracaoAtendimento', '00:00:00', ['class'=>'form-control', 'readonly', 'id'=>'duracaoAtendimento', 'style'=>'border-bottom-left-radius: 0px; border-top-left-radius: 0px; text-align: center; font-weight: bold; background-color: rgba(221, 239, 225, 0.6);']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <!-- <a href="{{ route('agendamentos') }}" class="btn btn-danger">Cancelar</a> -->
                   {!! Form::submit('Finalizar Atendimento', ['class'=>'btn btn-success', 'style'=>'margin-left: 5px;']) !!}
                </div>
            </div>
        </h3>
            <hr size="300" width="0%" align="left">

        <ul class="nav nav-tabs" role="tablist" style="margin-top: 20px;">
            <li class="nav-item">
                <a class="nav-link active" href="#paciente" role="tab" data-toggle="tab">Paciente</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#anamnese" role="tab" data-toggle="tab">Anamnese</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#examefisico" role="tab" data-toggle="tab">Exame Físico</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#hipotesediagnostica" role="tab" data-toggle="tab">Hipótese Diagnóstica</a>
            </li>
            <li class="nav-item" style="display: none;">
                <a class="nav-link" href="#anexos" role="tab" data-toggle="tab">Anexos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#historico" role="tab" data-toggle="tab">Histórico</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">

            <!-- Paciente -->
            <div role="tabpanel" class="tab-pane in active" id="paciente">
                <div class="row" style="padding: 5px; margin: 10px 10px 10px 5px;">
                    <div class="col-md-7" style="display: none;">
                        {!! Form::text('agendamento_id', $agendamento->id, ['class'=>'form-control', 'readonly', 'id'=>'agendamento_id']) !!}
                    </div>
                    <div class="col-md-7">
                        {!! Form::label('paciente', 'Paciente:') !!}
                        {!! Form::text('paciente', $agendamento->paciente->nome, ['class'=>'form-control', 'readonly', 'id'=>'paciente']) !!}
                    </div>
                    <div class="col-md-3">
                        {!! Form::label('idade', 'Idade:') !!}
                        {!! Form::text('idade', calcula_idade($agendamento->paciente->dataNascimento)." anos", ['class'=>'form-control', 'readonly', 'id'=>'idade']) !!}
                    </div>
                </div>
                <div class="row" style="padding: 5px; margin: 10px 10px 10px 5px;">
                    <div class="col-md-5">
                        {!! Form::label('sexo', 'Sexo:') !!}
                        {!! Form::text('sexo', $agendamento->paciente->sexo, ['class'=>'form-control', 'readonly', 'id'=>'sexo']) !!}
                    </div>
                    <div class="col-md-5">
                        {!! Form::label('convenio', 'Convênio:') !!}
                        {!! Form::text('convenio', $agendamento->convenio, ['class'=>'form-control', 'readonly', 'id'=>'convenio']) !!}
                    </div>
                </div>

                <hr size="300" width="100%" align="left">

                <div class="row" style="padding: 5px; margin: 10px 10px 10px 5px;">
                    <div class="col-md-5">
                        {!! Form::label('descricaoPrincipal', 'Descrição Principal:') !!}
                        {{ Form::textarea('descricaoPrincipal', null, ['class'=>'form-control', 'rows'=>'3']) }}
                    </div>
                    <div class="col-md-5">
                        {!! Form::label('evolucao', 'Evolução:') !!}
                        {{ Form::textarea('evolucao', null, ['class'=>'form-control', 'rows'=>'3']) }}
                    </div>
                </div>

                <hr size="300" width="100%" align="left">

            </div>

            <!-- Anamnese -->
            <div role="tabpanel" class="tab-pane" id="anamnese">
                <div class="row" style="padding: 5px; margin: 10px 10px 10px 5px;">
                    <div class="col-md-5">
                        {!! Form::label('queixaPrincipal', 'Queixa Principal:') !!}
                        {{ Form::textarea('queixaPrincipal', null, ['class'=>'form-control', 'rows'=>'2']) }}
                    </div>
                    <div class="col-md-5">
                        {!! Form::label('historia', 'História:') !!}
                        {{ Form::textarea('historia', null, ['class'=>'form-control', 'rows'=>'2']) }}
                    </div>
                </div>

                <hr size="300" width="100%" align="left">

                <div class="row" style="padding: 5px; margin: 10px 10px 10px 5px;">
                    <div class="col-md-5">
                        {!! Form::label('problemasRenais', 'Problemas Renais:') !!}
                        {!! Form::text('problemasRenais', null, ['class'=>'form-control']) !!}
                    </div>
                    <div class="col-md-5">
                        {!! Form::label('problemasArticulares', 'Problemas Articulares:') !!}
                        {!! Form::text('problemasArticulares', null, ['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="row" style="padding: 5px; margin: 10px 10px 10px 5px;">
                    <div class="col-md-5">
                        {!! Form::label('problemasCardiacos', 'Problemas Cardíacos:') !!}
                        {!! Form::text('problemasCardiacos', null, ['class'=>'form-control']) !!}
                    </div>
                    <div class="col-md-5">
                        {!! Form::label('problemasRespiratorios', 'Problemas Respiratórios:') !!}
                        {!! Form::text('problemasRespiratorios', null, ['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="row" style="padding: 5px; margin: 10px 10px 10px 5px;">
                    <div class="col-md-5">
                        {!! Form::label('problemasGastricos', 'Problemas Gástricos:') !!}
                        {!! Form::text('problemasGastricos', null, ['class'=>'form-control']) !!}
                    </div>
                    <div class="col-md-5">
                        {!! Form::label('alergias', 'Alergias:') !!}
                        {!! Form::text('alergias', null, ['class'=>'form-control']) !!}
                    </div>
                </div>

                <hr size="300" width="100%" align="left">

                <?php
                if ($agendamento->paciente->sexo == 'Masculino'){
                    $gravidez = 'display: none;';
                } else {
                    $gravidez = '';
                }
                    ?>
                <div class="row" style="padding: 5px; margin: 10px 10px 10px 5px;">
                    <div class="col-md-3">
                        {!! Form::label('hepatite', 'Hepatite:') !!}
                        <br/>
                        <label class="checkbox-inline">
                            {!! Form::radio('hepatite', 1) !!}
                            Sim</label>&nbsp;&nbsp;
                        <label class="checkbox-inline">
                            {!! Form::radio('hepatite', 0) !!}
                            Não</label>
                    </div>
                    <div class="col-md-3" style="<?php echo $gravidez ?>">
                        {!! Form::label('gravidez', 'Gravidez:') !!}
                        <br/>
                        <label class="checkbox-inline">
                            {!! Form::radio('gravidez', 1) !!}
                            Sim</label>&nbsp;&nbsp;
                        <label class="checkbox-inline">
                            {!! Form::radio('gravidez', 0) !!}
                            Não</label>
                    </div>
                    <div class="col-md-2">
                        {!! Form::label('diabetes', 'Diabetes:') !!}
                        <br/>
                        <label class="checkbox-inline">
                            {!! Form::radio('diabetes', 1) !!}
                            Sim</label>&nbsp;&nbsp;
                        <label class="checkbox-inline">
                            {!! Form::radio('diabetes', 0) !!}
                            Não</label>
                    </div>
                </div>

                <hr size="300" width="100%" align="left">

                <div class="row" style="padding: 5px; margin: 10px 10px 10px 5px;">
                    <div class="col-md-5">
                        {!! Form::label('usoMedicamento', 'Uso de Medicamentos:') !!}
                        {{ Form::textarea('usoMedicamento', null, ['class'=>'form-control', 'rows'=>'2']) }}
                    </div>
                </div>

                <hr size="300" width="100%" align="left" style="margin-bottom: 40px;">

            </div>

            <!-- Exame Físico -->
            <div role="tabpanel" class="tab-pane" id="examefisico">
                <div class="row" style="padding: 5px; margin: 10px 10px 10px 5px;">
                    <div class="col-md-3">
                        {!! Form::label('altura', 'Altura:') !!}
                        <div class="input-group-btn">
                            {!! Form::number('altura', null, ['class'=>'form-control', 'style'=>'border-bottom-right-radius: 0px; border-top-right-radius: 0px;']) !!}
                            <div class="input-group-addon">cm</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        {!! Form::label('peso', 'Peso:') !!}
                        <div class="input-group-btn">
                            {!! Form::number('peso', null, ['class'=>'form-control', 'style'=>'border-bottom-right-radius: 0px; border-top-right-radius: 0px;']) !!}
                            <div class="input-group-addon">kg</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        {!! Form::label('frenquenciaCardiaca', 'Frequência Cardíaca:') !!}
                        <div class="input-group-btn">
                            {!! Form::number('frenquenciaCardiaca', null, ['class'=>'form-control', 'style'=>'border-bottom-right-radius: 0px; border-top-right-radius: 0px;']) !!}
                            <div class="input-group-addon">bpm</div>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding: 5px; margin: 10px 10px 10px 5px;">
                    <div class="col-md-3">
                        {!! Form::label('pressaoSistolica', 'Pressão Sistólica:') !!}
                        <div class="input-group-btn">
                            {!! Form::text('pressaoSistolica', null, ['class'=>'form-control', 'style'=>'border-bottom-right-radius: 0px; border-top-right-radius: 0px;']) !!}
                            <div class="input-group-addon">mm/Hg</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        {!! Form::label('pressaoDiastolica', 'Pressão Diastólica:') !!}
                        <div class="input-group-btn">
                            {!! Form::text('pressaoDiastolica', null, ['class'=>'form-control', 'style'=>'border-bottom-right-radius: 0px; border-top-right-radius: 0px;']) !!}
                            <div class="input-group-addon">mm/Hg</div>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding: 5px; margin: 10px 10px 10px 5px;">
                    <div class="col-md-6">
                        {!! Form::label('observacoesGerais', 'Observações Gerais:') !!}
                        {{ Form::textarea('observacoesGerais', null, ['class'=>'form-control', 'rows'=>'2']) }}
                    </div>
                </div>

                <hr size="300" width="100%" align="left" style="margin-bottom: 40px;">

            </div>

            <!-- Diagnostico -->
            <div role="tabpanel" class="tab-pane" id="hipotesediagnostica">
                <div class="row" style="padding: 5px; margin: 10px 10px 10px 5px;">
                    <div class="col-md-5">
                        {!! Form::label('diagnostico', 'Diagnóstico:') !!}
                        {{ Form::textarea('diagnostico', null, ['class'=>'form-control', 'rows'=>'3']) }}
                    </div>
                    <div class="col-md-5">
                        {!! Form::label('observacoes', 'Observações:') !!}
                        {{ Form::textarea('observacoes', null, ['class'=>'form-control', 'rows'=>'3']) }}
                    </div>
                </div>

                <hr size="300" width="100%" align="left" style="margin-bottom: 40px;">
            </div>

            <!-- Anexos -->
            <div role="tabpanel" class="tab-pane" id="anexos" style="display: none;">
                <div class="row" style="padding: 5px; margin: 10px 10px 10px 5px;">
                    <div class="col-md-12">
                        <div class="input-group-btn">
                            {{Form::file('nomearquivo', ['class'=>'form-control', 'style'=>'border-bottom-right-radius: 0; border-top-right-radius: 0;', 'id'=>'nomearquivo'])}}
                            <input type="button" id="storeanexo" class="btn-sm btn btn-info" style="padding: 11px 10px 10px 10px; border-bottom-left-radius: 0; border-top-left-radius: 0; font-weight: 600;" value="Salvar Arquivo"></input>
                        </div>
                    </div>
                    <table>
                        <tbody>
                            <tr id="resultanexo">

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Historico -->
            <div role="tabpanel" class="tab-pane" id="historico">
                @if(count($historicos) != 0)
                    @foreach($historicos as $historico)
                        <ul class="timeline">
                            <li class="timeline-inverted">
                                <div class="timeline-badge"><i class="#"></i></div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <h class="timeline-title" style="margin-top: 20px; font-weight: bold; font-style: italic; text-decoration: underline;">Atendimento: {{date( 'd/m/Y' , strtotime($historico->data))}}</h>
                                        <p>
                                            <small class="text-muted"><i class="fa fa-clock-o"></i> Duração: {{$historico->duracaoAtendimento}} - {{$historico->nome}}</small>
                                        </p>
                                    </div>
                                    <div class="timeline-body">
                                        <div class="row">
                                            <div class="col-md-6" style="font-style: italic; font-weight: 500; color: rgb(73, 80, 87)">
                                                Descrição Principal:
                                            </div>
                                            <div class="col-md-6" style="font-style: italic; font-weight: 500; color: rgb(73, 80, 87)">
                                                Queixa:
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6" style="font-weight: 300;">
                                                <p>{{$historico->descricaoPrincipal}}</p>
                                            </div>
                                            <div class="col-md-6" style="font-weight: 300;">
                                                <p>{{$historico->queixaPrincipal}}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12" style="font-style: italic; font-weight: 500; color: rgb(73, 80, 87)">
                                                Diagnóstico:
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12" style="font-weight: 300;">
                                                <p>{{$historico->diagnostico}}</p>
                                            </div>
                                        </div>
                                        <hr size="300" width="100%" align="left">
                                        <div class="row">
                                            <div class="col-md-6" style="font-weight: 300;">
                                                <i style="font-weight: 500; color: rgb(73, 80, 87)">Peso: </i>{{$historico->peso}} kg
                                            </div>
                                            <div class="col-md-6" style="font-weight: 300;">
                                                <i style="font-weight: 500; color: rgb(73, 80, 87)">Frequência Cardíaca: </i>{{$historico->frenquenciaCardiaca}} bpm
                                            </div>
                                        </div><div class="row">
                                            <div class="col-md-6" style="font-weight: 300;">
                                                <i style="font-weight: 500; color: rgb(73, 80, 87)">Pressão Sistólica: </i>{{$historico->pressaoSistolica}} mm/Hg
                                            </div>
                                            <div class="col-md-6" style="font-weight: 300;">
                                                <i style="font-weight: 500; color: rgb(73, 80, 87)">Pressão Diastólica: </i>{{$historico->pressaoDiastolica}} mm/Hg
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    @endforeach
                @else
                    <div class="alert alert-warning" style="margin: 15px; font-weight: 100; font-style: italic;">
                        <strong> - Paciente não possui histórico de atendimentos. </strong>
                    </div>
                @endif
            </div>

        </div>

        {!! Form::close() !!}

    </div>
@endsection