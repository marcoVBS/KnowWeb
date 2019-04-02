@extends('layouts.begin')

@section('title', 'Login')

@section('content_begin')
<div class="container">
    <div class="row center-align">
        <div class="col s12 m4">
            <img class="responsive-img logo-begin" src="{{ asset('img/begin/logo4.png') }}" alt="logo_knowweb">
        </div>

        <div class="col s12 m8 form-register">
            <div class="row">
                <h3 class="header grey-text">Login no sistema</h3>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-field col s12">
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required class="validate">
                        <label for="email">Email</label>

                        @if ($errors->has('email'))
                            <span class="helper-text red-text">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    <div class="input-field col s12">
                        <input id="password" type="password" name="password" required class="validate">
                        <label for="password">Senha</label>

                        @if ($errors->has('password'))
                            <span class="helper-text red-text">{{ $errors->first('password') }}</span>
                        @endif

                    </div>

                    <div class="col s12 left-align">
                        <p>
                            <label>
                                <input type="checkbox" class="filled-in" name="remember" {{ old('remember') ? 'checked' : '' }}/>
                                <span>Lembrar de mim</span>
                            </label>
                        </p>
                        <br><div class="divider"></div><br>
                    </div>

                    <div class="row">
                        <button class="btn waves-effect waves-light green btn-large" type="submit">Login
                            <i class="material-icons right">lock</i>
                        </button>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">Esqueceu sua senha?</a>
                        @endif

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
