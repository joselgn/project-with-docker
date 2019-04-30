@extends('welcome')

@section('conteudo')

    <div id="login">
        <div class="themeTitle">
            <h3>&Aacute;rea Restrita</h3>
            <hr/>
        </div>

        <br>

        @if (session()->has('error'))
            @if (session()->get('error')=='1' && session()->has('msg'))
                <div class="alert alert-danger">
                    <h3>Erro ao fazer o login</h3>
                    {!! session()->get('msg') !!}
                </div>
            @else
                @if(session()->has('msg'))
                    <div class="alert alert-success">
                        <h3>{!! session()->get('msg') !!}</h3>
                    </div>
                @endif
            @endif
        @endif

        <form class="form-horizontal loginFrm" method="POST" action="{{ route('login') }}">
            @csrf

            <!-- EMAIL -->
            <div class="control-group">
                <label class="label label-success" for="email" >EMAIL</label>
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? '-is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="Email">

                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <!-- SENHA -->
            <div class="control-group">
                <label  class="label label-success" for="password">SENHA</label>
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Password">

                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <!-- REMEMBER-ME -->
            <div class="control-group">
                <label class="label checkbox" for="remember">
                    {{ __('Remember Me') }}
                </label>
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            </div>

            <!-- BOTOES -->
            <div class="control-group">
                <button type="submit" class="btn btn-primary">
                    Entrar
                </button>

                <a class="btn btn-link" href="{{ route('password.request') }}">
                    Esquece sua senha?
                </a>
            </div>
        </form>
    </div>

@endsection
