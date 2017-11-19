@extends('app')

@section('content')
    <div class="container">

        {!! Form::open(['route' => 'logs.search']) !!}
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
            <button type="submit" class="btn-sm btn btn-outline-secondary" id="refresh" style="margin-right: 15px; padding-top: 5px; height: 34px;" title="Atualizar"><i class="fa fa-refresh" aria-hidden="true"></i></button>
        </div>
        {!! Form::close() !!}

        <h3><i class="fa fa-tasks" aria-hidden="true"></i> Logs</h3>
        @if(count($logs) == 0)
        <!-- parametro não retornou resultados -->
            <div class="col-md-11" style="margin-top: 30px;">
                <div class="alert alert-warning" style="font-style: italic;">
                    <strong>Atenção!</strong> Nenhum registro para os parâmetros informados.
                </div>
            </div>
        @else
        <table class="table table-striped table-bordered table-hover" style="margin-top: 20px;">
            <thead>
            <tr>
                <th width="18%">Horário</th>
                <th width="18%">Usuário</th>
                <th width="18%">Email</th>
                <th>Mensagem</th>
            </tr>
            </thead>
            <tbody>
            @foreach($logs as $log)
                <tr>
                    <td width="18%">
                        <?php
                            $fuso = new DateTimeZone('America/Sao_Paulo');
                            $data = new DateTime($log->created_at);
                            $data->setTimezone($fuso);
                            echo $data->format('H:i:s - d/m/Y');
                        ?>
                    </td>
                    <td width="18%">{{$log->usuario}}</td>
                    <td width="18%">{{$log->email}}</td>
                    <td>Ação: {{$log->acao}} / Descrição: {{$log->tabela}} {{$log->descricao}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @endif

        <div style="text-align: center;">
            {!! $logs->links() !!}
        </div>
    </div>

@endsection