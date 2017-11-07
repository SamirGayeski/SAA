@extends('app')
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

@section('content')
    <div class="container">

        <div class="row" style="float: right;">
            <div style="margin-top: 7px;">
                De:
            </div>
            <div class="col-md-5">
                {!! Form::date('datainicial', new DateTime('-1 month'), ['class'=>'form-control', 'id'=>'datainicial', 'style'=>'height: 35px;']) !!}
            </div>
            <div style="margin-top: 7px;">
                até
            </div>
            <div class="col-md-5">
                {!! Form::date('datafinal', new DateTime(), ['class'=>'form-control', 'id'=>'datafinal', 'style'=>'height: 35px;']) !!}
            </div>
        </div>

        <h3><i class="fa fa-bar-chart" aria-hidden="true"></i> Dashboard</h3>
        <hr size="300" width="100%" align="left">

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load("current", {packages:["corechart"]});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Task', 'Hours per Day'],
                    ['Particular', {{$particular}}],
                    ['Convênio', {{$convenio}}]
                ]);

                var chart = new google.visualization.PieChart(document.getElementById('chart'));
                chart.draw(data, {
                    width: 435,
                    height: 240,
                    pieHole: 0.4,
                    pieSliceTextStyle: {
                        color: '#333',
                    },
                    backgroundColor: 'transparent'
                });

                var chart2 = new google.visualization.PieChart(document.getElementById('chart2'));
                chart2.draw(data, {
                    width: 435,
                    height: 240,
                    pieHole: 0.4,
                    pieSliceTextStyle: {
                        color: '#333',
                    },
                    backgroundColor: 'transparent'
                });

            }
        </script>

        <div class="row">
            <div class="col-md-5 border" style="border-radius:10px; margin: 20px 20px 20px 50px; padding-left: 0px; padding-right: 0px;">
                <div id="dashboard">Particular X Convênio</div>
                <div id="chart"></div>
            </div>
            <div class="col-md-5 border" style="border-radius:10px; margin: 20px 20px 20px 50px; padding-left: 0px; padding-right: 0px;">
                <div id="dashboard">Particular X Convênio</div>
                <div id="chart2"></div>
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