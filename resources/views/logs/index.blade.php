@extends('app')

@section('content')
    <div class="container">
        <h3><i class="fa fa-tasks" aria-hidden="true"></i> Logs</h3>
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
                    <td width="18%"><?php
                        $fuso = new DateTimeZone('America/Sao_Paulo');
                        $data = new DateTime($log->created_at);
                        $data->setTimezone($fuso);
                        echo $data->format('H:i:s - d/m/Y');
                        ?></td>
                    <td width="18%">{{$log->usuario}}</td>
                    <td width="18%">{{$log->email}}</td>
                    <td>Ação: {{$log->acao}} / Descrição: {{$log->tabela}} {{$log->descricao}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="text-align: center;">
            {!! $logs->links() !!}
        </div>
    </div>
@endsection