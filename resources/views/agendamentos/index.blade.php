@extends('app')

@section('content')
    <head>
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{asset('/fullcalendar/fullcalendar.css')}}"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="{{asset('/fullcalendar/lib/moment.min.js')}}"></script>
        <script src="{{asset('/fullcalendar/fullcalendar.js')}}"></script>
    </head>
    <body>
        <div class="container">
            <a data-toggle="modal" data-target=".bs-example-modal-sm" title="Legenda" class="btn-sm btn btn-default" style="float: right; padding: 1px 15px 1px 15px; margin-top: 5px; margin-right: 7px; font-size: 18px;"><i class="fa fa-cogs" aria-hidden="true"></i></a>
            <a href="{{ route('agendamentos.create') }}" class="btn-sm btn btn-default" style="float: right; padding: 6px 25px 5px 25px; margin-top: 5px; margin-right: 14px; font-weight: bold;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Incluir Agendamento</a>
            @if((Auth::user()->tipoUsuario == 'Profissional da Saúde' && Auth::user()->flagAdmin == true) or Auth::user()->tipoUsuario == 'Recepcionista')
                <div class="col-md-3" style="float: right; margin-top: 5px;">
                    {{ Form::select('profissional', ['0'=>'Todos os profissionais'] + \App\Usuario::where('tipoUsuario', '=', 'Profissional da Saúde')->orderBy('nome')->pluck('nome','id')->toArray(), null, ['class'=>'form-control', 'placeholder' => 'Selecione um profissional', 'id' => 'profissional', 'style'=>'height: 31px;']) }}
                </div>
            @endif
            <div class="panel panel-primary">
                <div class="panel-heading">
                    @if(isset($profissional))
                        <strong><i class="fa fa-user" aria-hidden="true"></i> Profissional: </strong>{!! $profissional->first()->nome !!}
                        @else
                        Agendamentos
                    @endif
                </div>
                <div class="panel-body">

                    {!! $calendar->calendar() !!}
                    {!! $calendar->script() !!}

                    <div>

                        <div class="modal bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="gridSystemModalLabel">Legenda Agendamentos</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div style="margin-left: 10%;">
                                        <table style="margin: 5%">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <svg height="30" width="30">
                                                            <circle cx="15" cy="15" r="10" stroke-width="3" fill="#58ACFA" />
                                                        </svg>
                                                    </td>
                                                    <td>Agendado</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <svg height="30" width="30">
                                                            <circle cx="15" cy="15" r="10" stroke-width="3" fill="#D8D8D8" />
                                                        </svg>
                                                    </td>
                                                    <td>Confirmado</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <svg height="30" width="30">
                                                            <circle cx="15" cy="15" r="10" stroke-width="3" fill="#F5A9F2" />
                                                        </svg>
                                                    </td>
                                                    <td>Aguardando atendimento</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <svg height="30" width="30">
                                                            <circle cx="15" cy="15" r="10" stroke-width="3" fill="#F4FA58" />
                                                        </svg>
                                                    </td>
                                                    <td>Em andamento</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <svg height="30" width="30">
                                                            <circle cx="15" cy="15" r="10" stroke-width="3" fill="#A9F5A9" />
                                                        </svg>
                                                    </td>
                                                    <td>Atendido</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <svg height="30" width="30">
                                                            <circle cx="15" cy="15" r="10" stroke-width="3" fill="#FA5858" />
                                                        </svg>
                                                    </td>
                                                    <td>Cancelado</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <svg height="30" width="30">
                                                            <circle cx="15" cy="15" r="10" stroke-width="3" fill="#F7BE81" />
                                                        </svg>
                                                    </td>
                                                    <td>Não compareceu</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('#profissional').on('change', function(e){
                    var profissional_id = e.target.value;
                    var url = "{{ route('agendamentos.profissional', ":profissional_id") }}";
                    url = url.replace(':profissional_id', profissional_id);

                    window.location.href=url;

                });
            });
        </script>
    </body>
@endsection