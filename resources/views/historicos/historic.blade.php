@extends('app')

@section('content')
    <div class="container">
        <a href="{{ route('historicos') }}" class="btn-sm btn btn-success" style="float: right; padding: 5px 25px 5px 25px; font-size: 15px; margin-right: 7px;"><i class="fa fa-reply" aria-hidden="true"></i> Voltar</a>
        <p style="font-size: 22px;"><strong>Histórico:</strong><i> {{$paciente->first()->nome}}</i></p>

        <hr size="300" width="100%" align="left">

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
@endsection