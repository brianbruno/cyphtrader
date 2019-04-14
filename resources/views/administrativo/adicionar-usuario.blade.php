@extends('platform.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Usuário</div>

                    <div class="card-body">
                        <form action="{{ url('administrativo/salvar-usuario') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <div class="col-sm-12 col-md-6">
                                    <label for="name">Nome</label>
                                    <input required value="{{ old('name') }}" type="text" name="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                           id="name" aria-describedby="descricao-help" placeholder="Nome do Usuário" maxlength="60" minlength="5">
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <label for="email">E-mail</label>
                                    <input required value="{{ old('name') }}" type="email" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           id="email" aria-describedby="descricao-help" placeholder="E-mail" maxlength="60" minlength="5">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 col-md-6">
                                    <label for="password">Senha</label>

                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback"><strong>{{ $errors->first('password') }}</strong></span>
                                    @endif
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <label for="password-confirm">Confirme a senha</label>

                                    <div>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">

                                <div class="col-sm-12 col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="criarRobo" id="criarRobo" checked>
                                        <label class="form-check-label" for="criarRobo">
                                            Criar robô
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn btn-secondary ">
                                    Cadastrar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
