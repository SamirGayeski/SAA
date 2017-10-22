@extends('app')

@section('content')
    <div class="container">
        <h3>Usuários
            <div class="input-group-btn" style="float: right;">
                {!! Form::text('search', null, ['class'=>'form-control', 'style'=>'border-bottom-right-radius: 0px; border-top-right-radius: 0px;']) !!}
                <div class="input-group-addon"><a href="{{ route('usuarios.search') }}"><i class="fa fa-search" aria-hidden="true"></i> </a></div>
            </div>
        </h3>
        <a href="{{ route('usuarios.create') }}" class="btn-sm btn btn-outline-info" style="float: left; margin-bottom: 10px; margin-top: 25px; font-weight: bold;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Incluir Usuário</a>
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Login</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Situação</th>
                <th>Tipo</th>
                <th style="text-align: center; width: 10%">Ação</th>
            </tr>
            </thead>
            <tbody>
            @foreach($usuarios as $user)
                <tr>
                    <td>{{$user->nome}}</td>
                    <td>{{$user->login}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->telefone}}</td>
                    <td>{{$user->situacao}}</td>
                    <td>{{$user->tipoUsuario}}</td>
                    <td style="text-align: center;">
                        <a href="{{ route('usuarios.edit', ['id'=>$user->id]) }}" class="btn-sm btn-info"><i class="fa fa-pencil-square-o " aria-hidden="true"></i></a>
                        <a onclick="return confirm('O usuario {{$user->nome}} será removido, deseja continuar ?')" href="{{ route('usuarios.destroy', ['id'=>$user->id]) }}" class="btn-sm btn-danger"><i class="fa fa-trash-o " aria-hidden="true"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="text-align: center;">
            {!! $usuarios->links() !!}
        </div>
    </div>
@endsection