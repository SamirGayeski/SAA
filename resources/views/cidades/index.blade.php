@extends('app')

@section('content')
    <div class="container">
        <h3><i class="fa fa-map-marker" aria-hidden="true"></i> Cidades</h3>
        <a href="{{ route('cidades.create') }}" class="btn-sm btn btn-outline-info" style="float: right; margin-bottom: 10px; font-weight: bold;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Incluir Cidade</a>
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Nome</th>
                <th>UF</th>
                <th style="text-align: center; width: 10%">Ação</th>
            </tr>
            </thead>
            <tbody>
            @foreach($cidades as $cidade)
                <tr>
                    <td>{{$cidade->nome}}</td>
                    <td>{{$cidade->uf}}</td>
                    <td style="text-align: center;">
                        <a href="{{ route('cidades.edit', ['id'=>$cidade->id]) }}" class="btn-sm btn-info"><i class="fa fa-pencil-square-o " aria-hidden="true"></i></a>
                        <a onclick="return confirm('A cidade {{$cidade->nome}} será removido, deseja continuar ?')" href="{{ route('cidades.destroy', ['id'=>$cidade->id]) }}" class="btn-sm btn-danger"><i class="fa fa-trash-o " aria-hidden="true"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="text-align: center;">
            {!! $cidades->links() !!}
        </div>
    </div>
@endsection