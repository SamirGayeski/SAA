@extends('app')
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

@section('content')
    <div class="container">

        {!! Form::open(['route' => 'dashboard.search']) !!}
        <div class="row" style="float: right;">
            <div style="margin-top: 7px;">
                De:
            </div>
            <div class="col" style="width: 175px;">
                {!! Form::date('datainicial', $datainicial, ['class'=>'form-control', 'id'=>'datainicial', 'style'=>'height: 35px; font-size: small;']) !!}
            </div>
            <div style="margin-top: 7px;">
                até
            </div>
            <div class="col" style="width: 175px;">
                {!! Form::date('datafinal', $datafinal, ['class'=>'form-control', 'id'=>'datafinal', 'style'=>'height: 35px; font-size: small;']) !!}
            </div>
            @if(Auth::user()->tipoUsuario == 'Profissional da Saúde' && Auth::user()->flagAdmin == true)
                <div class="col">
                    {{ Form::select('profissional', ['0'=>'Todos os profissionais'] + \App\Usuario::where('tipoUsuario', '=', 'Profissional da Saúde')->orderBy('nome')->pluck('nome','id')->toArray(), $profissional, ['class'=>'form-control', 'id' => 'profissional', 'style'=>'height: 35px; font-size: small; width: 220px;']) }}
                </div>
            @elseif(Auth::user()->tipoUsuario == 'Profissional da Saúde' && Auth::user()->flagAdmin == false)
                <div class="col">
                    {{ Form::select('profissional', [Auth::user()->id=>Auth::user()->nome], $profissional, ['class'=>'form-control', 'id' => 'profissional', 'style'=>'height: 35px; font-size: small; width: 220px;']) }}
                </div>
            @elseif(Auth::user()->tipoUsuario == 'Recepcionista')
                <div class="col">
                    {{ Form::select('profissional', ['972382'=>'Todos os profissionais'] + \Illuminate\Support\Facades\DB::table('recepcionista_atendes')->join('usuarios', 'recepcionista_atendes.profissionalsaude_id', '=', 'usuarios.id')->where('recepcionista_atendes.recepcionista_id', '=', Auth::user()->id)->select('usuarios.id', 'usuarios.nome')->orderBy('nome')->pluck('nome','id')->toArray(), $profissional, ['class'=>'form-control', 'id' => 'profissional', 'style'=>'height: 35px; font-size: small; width: 220px;']) }}
                </div>
            @endif
            <button type="submit" class="btn-sm btn btn-outline-secondary" id="refresh" style="margin-right: 15px; padding-top: 5px; height: 34px;" title="Atualizar"><i class="fa fa-refresh" aria-hidden="true"></i></button>
        </div>
        {!! Form::close() !!}

        <h3><i class="fa fa-bar-chart" aria-hidden="true"></i> Dashboard</h3>
        <hr size="300" width="100%" align="left">

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load("current", {packages:["corechart"]});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
                var data1 = google.visualization.arrayToDataTable([
                    ['Task', 'Hours per Day'],
                    ['Particular', {{$particular}}],
                    ['Convênio', {{$convenio}}]
                ]);

                var data2 = google.visualization.arrayToDataTable([
                    ['Task', 'Hours per Day'],
                    ['Homens', {{$homens}}],
                    ['Mulheres', {{$mulheres}}]
                ]);

                var chart = new google.visualization.PieChart(document.getElementById('chart'));
                chart.draw(data1, {
                    width: 480,
                    height: 300,
                    pieHole: 0.6,
                    pieSliceTextStyle: {
                        color: '#333',
                    },
                    backgroundColor: '#eceff1',
                    colors: ['#f5d2be', '#f1ab67'],
                    legend: {position: 'bottom', textStyle: {fontSize: 13}}
                });

                var chart2 = new google.visualization.PieChart(document.getElementById('chart2'));
                chart2.draw(data2, {
                    width: 500,
                    height: 300,
                    pieSliceTextStyle: {
                        color: '#333',
                    },
                    backgroundColor: '#eceff1',
                    colors: ['#bed6ec', '#49a0d2'],
                    legend: {position: 'right', textStyle: {fontSize: 13}}
                });

            }
        </script>

        <div class="row">
            <div class="col border" style="border-radius:10px; margin: 20px 7px 20px 50px; padding-left: 0px; padding-right: 0px;">
                <div id="dashboard_cabecalho_agendados"><i class="fa fa-calendar"></i> Agendados</div>
                <div id="dashboard_detalhes_agendados">{{$agendados}}</div>
            </div>
            <div class="col border" style="border-radius:10px; margin: 20px 7px 20px 7px; padding-left: 0px; padding-right: 0px;">
                <div id="dashboard_cabecalho_confirmados"><i class="fa fa-check"></i> Confirmados</div>
                <div id="dashboard_detalhes_confirmados">{{$confirmados}}</div>
            </div>
            <div class="col border" style="border-radius:10px; margin: 20px 7px 20px 7px; padding-left: 0px; padding-right: 0px;">
                <div id="dashboard_cabecalho_atendidos"><i class="fa fa-user-md"></i> Atendidos</div>
                <div id="dashboard_detalhes_atendidos">{{$atendidos}}</div>
            </div>
            <div class="col border" style="border-radius:10px; margin: 20px 7px 20px 7px; padding-left: 0px; padding-right: 0px;">
                <div id="dashboard_cabecalho_naocompareceu"><i class="fa fa-ban"></i> Não compareceram</div>
                <div id="dashboard_detalhes_naocompareceu">{{$naocompareceu}}</div>
            </div>
            <div class="col border" style="border-radius:10px; margin: 20px 50px 20px 7px; padding-left: 0px; padding-right: 0px;">
                <div id="dashboard_cabecalho_media"><i class="fa fa-clock-o"></i> Duração média</div>
                <div id="dashboard_detalhes_media">
                    @if(empty($duracao->duracao))
                        {{'00:00:00'}}
                    @else
                        {{substr($duracao->duracao, 0, 8)}}
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col border" style="border-radius:10px; margin: 20px 10px 20px 50px; padding-left: 0px; padding-right: 0px;">
                <div id="dashboard_cabecalho_chart"><i class="fa fa-bar-chart"></i> Particular X Convênio</div>
                <div id="chart" style="background: #eceff1;"></div>
            </div>
            <div class="col border" style="border-radius:10px; margin: 20px 50px 20px 10px; padding-left: 0px; padding-right: 0px;">
                <div id="dashboard_cabecalho_chart"><i class="fa fa-bar-chart"></i> Homens X Mulheres</div>
                <div id="chart2" style="background: #eceff1;"></div>
            </div>
        </div>

    </div>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script>
        $(function() {
            $( "#datepicker" ).datepicker();
        });
    </script>
@endsection