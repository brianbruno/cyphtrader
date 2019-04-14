@extends('platform.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-6 text-left">
                                <h4>{{ $usuario->name }}</h4>
                            </div>
                            <div class="col-sm-6 text-right">
                                <a href="{{ url('administrativo/') }}"><button type="button" class="btn btn-outline-danger btn-sm">Voltar</button></a>
                                <a href="{{ url('administrativo/adicionar-usuario') }}"><button type="button" class="btn btn-info btn-sm">Novo usuário</button></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ url('administrativo/editar-usuario') }}" method="POST">
                            @csrf

                            <input type="hidden" id="id" name="id" value="{{ $usuario->id }}">

                            <div class="form-group row">
                                <div class="col-sm-12 col-md-6">
                                    <label for="name">Nome</label>
                                    <input required value="{{ $usuario->name }}" type="text" name="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                           id="name" aria-describedby="descricao-help" placeholder="Nome do Usuário" maxlength="60" minlength="5">
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <label for="email">E-mail</label>
                                    <input required value="{{ $usuario->email }}" type="email" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           id="email" aria-describedby="descricao-help" placeholder="E-mail" maxlength="60" minlength="5">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 col-md-6">
                                    <label for="password">Senha</label>

                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback"><strong>{{ $errors->first('password') }}</strong></span>
                                    @endif
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <label for="password-confirm">Robô</label>

                                    <div>
                                        <select class="form-control selectpicker" data-live-search="true" name="id_user" id="id_user">
                                            @foreach ($robos as $robo)
                                                <option @if($usuario->id_user == $robo->id) selected @endif value="{{ $robo->id }}">{{ $robo->name }}</option>
                                            @endforeach

                                            <option @if(empty($usuario->id_user)) selected @endif value="null">Nenhum</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-secondary ">
                                    Salvar
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
