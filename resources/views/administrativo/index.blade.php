@extends('platform.layouts.app')

@section('content')
    <br>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"> <div class="row">
                            <div class="col-sm-6 text-left">
                                <h4>Administrativo</h4>
                            </div>
                            <div class="col-sm-6 text-right">
                                <a href="{{ url('administrativo/adicionar-usuario') }}"><button type="button" class="btn btn-outline-secondary btn-sm">Adicionar Usuário</button></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="col-md-12">
                            <table id="tabela" class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">E-mail</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($usuarios as $usuario)
                                    <tr>
                                        <td>{{ $usuario->id }}</td>
                                        <td>{{ $usuario->name }}</td>
                                        <td>{{ $usuario->email }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection