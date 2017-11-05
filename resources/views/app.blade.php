    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
        <title>SAA</title>

        <link href="{{ asset('/css/bootstrap.css') }}" rel="stylesheet">


        <script src="dist/sweetalert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="dist/sweetalert.css">

        <!-- Fonts -->
        <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        @yield('styles')

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-confirmation/1.0.5/bootstrap-confirmation.js"></script>

    </head>
    <body style="background-color: #f8f9fa">
    <head><link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet"></head>
    <div class="container">
        <div class="row">

            <div id="wrapper">
                <!-- Sidebar -->
                <div id="sidebar-wrapper-menu">
                    <ul class="sidebar-nav" style="margin-left:0; font-family: Helvetica,Arial,sans-serif; font-size: 14px;">
                        <li class="sidebar-brand">
                            <a href="#menu-toggle"  id="menu-toggle" style="margin-top: 5px;float:right;" >
                                <img width="120px" style="padding-bottom: 15px;" src="{!! asset('images/logo.png') !!}">
                                <i class="fa fa-bars " style="font-size:30px !Important;" aria-hidden="true" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li style="margin-left: 15px;">
                            <span style="color: #fdfdfe; font-weight: lighter;">
                                <svg height="16" width="16">
                                    <circle cx="6" cy="10" r="6" stroke-width="3" fill="rgb(80, 187, 80)" />
                                </svg>
                                {{ Auth::user()->nome }}
                            </span>
                        </li>
                        <hr size="300" width="100%" align="left" style="border-top: 1.5px solid rgba(238, 238, 238, 0.44); margin-bottom: 2px; margin-top: 4px;">
                        <li>
                            <a href="{{ url('#') }}">
                                <i id="icon" class="fa fa-bar-chart" aria-hidden="true" title="Dashboard"></i>
                                <span style="margin-left:10px;">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('agendamentos') }}">
                                <i id="icon" class="fa fa-calendar" aria-hidden="true" title="Agendamentos"></i>
                                <span style="margin-left:10px;">Agenda</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('pacientes') }}">
                                <i id="icon" class="fa fa-male" aria-hidden="true" title="Pacientes"></i>
                                <span style="margin-left:10px;">Pacientes</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('convenios') }}">
                                <i id="icon" class="fa fa-medkit" aria-hidden="true" title="Convenios"></i>
                                <span style="margin-left:10px;"> Convênios</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('procedimentos') }}">
                                <i id="icon" class="fa fa-stethoscope" aria-hidden="true" title="Procedimentos"></i>
                                <span style="margin-left:10px;">Procedimentos</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('usuarios') }}">
                                <i id="icon" class="fa fa-user" aria-hidden="true" title="Usuários"></i>
                                <span style="margin-left:10px;"> Usuários</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('cidades') }}">
                                <i id="icon" class="fa fa-map-marker" aria-hidden="true" title="Cidades"></i>
                                <span style="margin-left:10px;"> Cidades</span>
                            </a>
                        </li>
                        <hr size="300" width="100%" align="left" style="border-top: 1.5px solid rgba(238, 238, 238, 0.44); margin-bottom: 2px; margin-top: 4px;">
                        <li>
                            <a href="{{ url('historicos') }}">
                                <i id="icon" class="fa fa-h-square" aria-hidden="true" title="Usuários"></i>
                                <span style="margin-left:10px;"> Históricos</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('relatorios') }}">
                                <i id="icon" class="fa fa-files-o" aria-hidden="true" title="Relatórios"></i>
                                <span style="margin-left:10px;"> Relatórios</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('logs') }}">
                                <i id="icon" class="fa fa-tasks" aria-hidden="true" title="Logs"></i>
                                <span style="margin-left:10px;"> Logs</span>
                            </a>
                        </li>
                        <hr size="300" width="100%" align="left" style="border-top: 1.5px solid rgba(238, 238, 238, 0.44); margin-bottom: 2px; margin-top: 4px;">
                        <li>
                            <span>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i id="icon" class="fa fa-sign-out" aria-hidden="true" title="Sair do sistema"></i>
                                    <span style="margin-left:10px;"> Sair</span>
                                </a>
                            </span>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>

                </div>
                <!-- /#sidebar-wrapper -->

                <!-- Page Content -->
                <div id="page-content-wrapper-menu">
                    <!--<nav class="navbar navbar-default navbar-static-top">
                        <div class="container">
                            <div class="navbar-header">
                                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                                    <ul class="nav navbar-nav navbar-right">
                                        <li><a href="#">Sair</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </nav>-->
                    <div class="container" style="position: absolute; margin-top: 20px;">
                        <div class="row">
                            <div class="col-lg-12">


                                <script>
                                    $("#menu-toggle").click(function(e) {
                                        e.preventDefault();
                                        $("#wrapper").toggleClass("toggled");
                                    });
                                </script>



                            </div>
                        </div>



    @include('flash::message')

                        <script>
                            $('div.alert').not('.alert-important').delay(5000).fadeOut(350);
                        </script>

    @yield('content')

    </body>
    </html>