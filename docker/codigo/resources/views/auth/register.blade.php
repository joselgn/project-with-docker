@extends('welcome') <!--Extende Layout Principal -->

@section('conteudo')
    <div class="themeTitle">
        <h3> Novo Cadastro </h3>
        <hr/>
    </div>

    <div class="offset2">
        <br>
        <form method="POST" class="form-horizontal " action="{{ route('register') }}" aria-label="{{ __('Register') }}">
            @csrf

            <div class="control-group row">
                <label for="name" class="label label-success">Nome</label>

                <div class="col-md-6">
                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                    @if ($errors->has('name'))
                        <span class="invalid-feedback alert-danger" role="alert">
                            <strong>{!! utf8_encode($errors->first('name')) !!}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="control-group row">
                <label for="email" class="label label-success">Email</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback alert-danger" role="alert">
                            <strong>{!! utf8_encode($errors->first('email')) !!}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="control-group row">
                <label for="password" class="label label-success">Senha</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                    @if ($errors->has('password'))
                        <span class="invalid-feedback alert-danger" role="alert">
                            <strong>{!! utf8_encode($errors->first('password')) !!}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="control-group row">
                <label for="password-confirm" class="label label-success">Confirmaç&atilde;o de Senha</label>

                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>
            </div>

            <div class="control-group row">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        Cadastrar
                    </button>
                </div>
            </div>
        </form>
    </div>

@endsection
