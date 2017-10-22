@extends('app')

@section('content')
    <div class="container">
        <h3>Convênios</h3>
        <a href="{{ route('convenios.create') }}" class="btn-sm btn btn-outline-info" style="float: right; margin-bottom: 10px; margin-top: 25px; font-weight: bold;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Incluir Convênio</a>
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Número de Registro</th>
                <th style="text-align: center; width: 10%">Ação</th>
            </tr>
            </thead>
            <tbody>
            @foreach($convenios as $conv)
                <tr>
                    <td>{{$conv->nome}}</td>
                    <td>{{$conv->numeroRegistro}}</td>
                    <td style="text-align: center;">
                        <a href="{{ route('convenios.edit', ['id'=>$conv->id]) }}" class="btn-sm btn-info"><i class="fa fa-pencil-square-o " aria-hidden="true"></i></a>
                        <a onclick="return confirm('O convenio {{$conv->nome}} será removido, como também todos os planos vinculados ao mesmo. Deseja continuar ?')" href="{{ route('convenios.destroy', ['id'=>$conv->id]) }}" class="btn-sm btn-danger"><i class="fa fa-trash-o " aria-hidden="true"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="text-align: center;">
            {!! $convenios->links() !!}
        </div>
    </div>
@endsection