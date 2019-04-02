@extends('layouts.begin')

@section('title', 'Enviar link')

@section('content_begin')
<div class="container">
    <div class="row">
        <div class="col s12">
            <h3 class="header grey-text">Resetar senha</h3>
            
            <div class="card">
                

                <div class="card-content">
                    @if (session('status'))
                        <h5 class="green-text">O link de redefinição de senha foi enviado para seu email!</h5>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="input-field col s12">
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required class="validate">
                            <label for="email">Email</label>
    
                            @if ($errors->has('email'))
                                <span class="helper-text red-text">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <button class="btn waves-effect waves-light" type="submit">Enviar link de redefinição de senha
                            <i class="material-icons right">send</i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
