@extends('app')

@section('content')
    <div class="container">
        <h3>Procedimentos</h3>
        <a href="{{ route('procedimentos.create') }}" class="btn-sm btn btn-outline-info" style="float: right; margin-bottom: 10px; margin-top: 25px; font-weight: bold;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Incluir Procedimento</a>
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Duração</th>
                <th>Descrição</th>
                <th style="text-align: center; width: 10%">Ação</th>
            </tr>
            </thead>
            <tbody>
            @foreach($procedimentos as $proc)
                <tr>
                    <td>{{$proc->nome}}</td>
                    <td>{{$proc->duracao}}</td>
                    <td>{{$proc->descricao}}</td>
                    <td style="text-align: center;">
                        <a href="{{ route('procedimentos.edit', ['id'=>$proc->id]) }}" class="btn-sm btn-info"><i class="fa fa-pencil-square-o " aria-hidden="true"></i></a>
                        <a onclick="return confirm('O procedimento {{$proc->nome}} será removido, deseja continuar ?')" href="{{ route('procedimentos.destroy', ['id'=>$proc->id]) }}" class="btn-sm btn-danger"><i class="fa fa-trash-o " aria-hidden="true"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="text-align: center;">
            {!! $procedimentos->links() !!}
        </div>
    </div>
@endsection