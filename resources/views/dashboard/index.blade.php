@extends('app')

@section('content')
    <div class="container">

        <div class="alert alert-success">
            Usuário <strong>{{ Auth::user()->nome}}</strong> logado com sucesso!
        </div>
    </div>
    <script>
        $('div.alert').not('.alert-important').delay(5000).fadeOut(350);
    </script>
@endsection