@extends('app')

@section('content')
    <div class="container">
        <h3><i class="fa fa-male" aria-hidden="true"></i> Pacientes
            <div class="input-group-btn" style="float: right;">
                <?php
                if (isset($pesquisa)){
                    $value = $pesquisa;
                } else {
                    $value = null;
                }
                ?>
                {!! Form::text('search', $value, ['class'=>'form-control', 'style'=>'border-bottom-right-radius: 0px; border-top-right-radius: 0px;', 'id'=>'search']) !!}
                <div class="input-group-addon"><a href="" id="pesquisa"><i class="fa fa-search" aria-hidden="true"></i></a></div>
            </div>
        </h3>
            <a href="{{ route('pacientes.create') }}" class="btn-sm btn btn-outline-info" style="float: left; margin-bottom: 10px; margin-top: 25px; font-weight: bold;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Incluir Paciente</a>
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Data de Nascimento</th>
                <th>Sexo</th>
                <th>Estado Civil</th>
                <th>CPF</th>
                <th>CNS</th>
                <th style="text-align: center; width: 10%">Ação</th>
            </tr>
            </thead>
            <tbody>
            @foreach($pacientes as $pac)
                <tr>
                    <td>{{$pac->nome}}</td>
                    <td>{{date( 'd/m/Y' , strtotime($pac->dataNascimento))}}</td>
                    <td>{{$pac->sexo}}</td>
                    <td>{{$pac->estadoCivil}}</td>
                    <td>{{$pac->cpf}}</td>
                    <td>{{$pac->cns}}</td>
                    <td style="text-align: center;">
                        <a href="{{ route('pacientes.edit', ['id'=>$pac->id]) }}" class="btn-sm btn-info" title="Editar"><i class="fa fa-pencil-square-o " aria-hidden="true"></i></a>
                        <a onclick="return confirm('O paciente {{$pac->nome}} será removido, deseja continuar ?')" href="{{ route('pacientes.destroy', ['id'=>$pac->id]) }}" class="btn-sm btn-danger" title="Remover"><i class="fa fa-trash-o " aria-hidden="true"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#pesquisa').on('click', function(){
                    var search = document.getElementById('search').value;
                    var url = "{{ route('pacientes.search', '_search_') }}".replace('_search_', search);
                    $('#pesquisa').attr('href', url);
                });
            });
        </script>
        <div style="text-align: center;">
            {!! $pacientes->links() !!}
        </div>


    </div>
@endsection