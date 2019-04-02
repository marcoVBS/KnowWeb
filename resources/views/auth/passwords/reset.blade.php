@extends('layouts.begin')

@section('title', 'Resetar senha')

@section('content_begin')
<div class="container">
    <div class="row">
        <div class="col s12">
            <h3 class="header grey-text">Resetar senha</h3>
            
            <div class="card">
                <div class="card-content">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="input-field col s12">
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required class="validate">
                            <label for="email">Email</label>
    
                            @if ($errors->has('email'))
                                <span class="helper-text red-text">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <div class="input-field col s12 m6">
                            <input id="password" type="password" name="password" required class="validate">
                            <label for="password">Senha</label>

                            @if ($errors->has('password'))
                                <span class="helper-text red-text">{{ $errors->first('password') }}</span>
                            @endif

                        </div>
                        
                        <div class="input-field col s12 m6">
                            <input id="password-confirm" type="password" name="password_confirmation" required class="validate">
                            <label for="password-confirm">Confirme a senha</label>
                        </div>

                        <button class="btn waves-effect waves-light" type="submit">Resetar senha
                            <i class="material-icons right">send</i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection