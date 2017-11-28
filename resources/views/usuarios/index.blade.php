@extends('app')

@section('content')
    <div class="container">
        <h3><i class="fa fa-user" aria-hidden="true"></i> Usuários
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
        <a href="{{ route('usuarios.create') }}" class="btn-sm btn btn-outline-info" style="float: right; margin-bottom: 10px; margin-top: 25px; font-weight: bold;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Incluir Usuário</a>
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Situação</th>
                <th>Tipo</th>
                <th style="text-align: center; width: 15%">Ação</th>
            </tr>
            </thead>
            <tbody>
            @foreach($usuarios as $user)
                <tr>
                    <td>{{$user->nome}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->telefone}}</td>
                    <td>{{$user->situacao}}</td>
                    <td>{{$user->tipoUsuario}}</td>
                    <td style="text-align: center;">
                        @if ($user->tipoUsuario == 'Recepcionista')
                            <a href="{{ route('usuarios.config', ['id'=>$user->id]) }}" class="btn-sm btn-secondary" title="Configurações"><i class="fa fa-gear" aria-hidden="true"></i></a>
                        @endif
                        <a href="{{ route('usuarios.edit', ['id'=>$user->id]) }}" class="btn-sm btn-info" title="Editar"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        <a onclick="return confirm('O usuario {{$user->nome}} será removido, deseja continuar ?')" href="{{ route('usuarios.destroy', ['id'=>$user->id]) }}" class="btn-sm btn-danger" title="Remover"><i class="fa fa-trash-o " aria-hidden="true"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#pesquisa').on('click', function(){
                    var search = document.getElementById('search').value;
                    var url = "{{ route('usuarios.search', '_search_') }}".replace('_search_', search);
                    $('#pesquisa').attr('href', url);
                });
            });
        </script>
        <div style="text-align: center;">
            {!! $usuarios->links() !!}
        </div>
    </div>
@endsection