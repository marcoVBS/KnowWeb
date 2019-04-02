@extends('layouts.begin')

@section('title', 'Registro')

@section('content_begin')
<div class="container">
    <div class="row">
        <div class="col s12 m4">
            <h3 class="header grey-text center-align">Registrar-se</h3>
            <div class="divider"></div>
            <img class="responsive-img logo-begin" src="{{ asset('img/begin/logo4.png') }}" alt="logo_knowweb">
        </div>

        <div class="col s12 m8 form-register">
            <div class="row">
                
                <form class="col s12" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="nome" type="text" class="validate" name="nome" value="{{ old('nome') }}" required>
                            <label for="nome">Nome</label>

                            @if ($errors->has('nome'))
                                <span class="helper-text red-text">{{ $errors->first('nome') }}</span>
                            @endif

                        </div>

                        <div class="input-field col s12">
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required class="validate">
                            <label for="email">Email</label>

                            @if ($errors->has('email'))
                                <span class="helper-text red-text">{{ $errors->first('email') }}</span>
                            @endif

                        </div>

                        <div class="input-field col s12 m6">
                            <input id="telefone_user" type="tel" name="telefone" value="{{ old('telefone') }}" required class="validate">
                            <label for="telefone_user">Telefone</label>
                        </div>
                        
                        <div class="input-field col s12 m6">
                            <input id="cpf_user" type="text" name="cpf" value="{{ old('cpf') }}" required class="validate">
                            <label for="cpf_user">CPF</label>
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

                        <div class="input-field col s12 m6">
                            <select name="tipo_usuario" required>
                                <option value="" disabled selected>Selecione...</option>
                                <option value="Usuario">Usuário</option>
                                <option value="Membro">Membro da equipe</option>
                                <option value="Administrador">Administrador</option>
                            </select>
                            <label>Tipo de usuário</label>
                        </div>

                        <div class="input-field col s12 m6">
                                <select name="setor_id" required>
                                    <option value="" disabled selected>Selecione...</option>
                                    @if($setores)
                                        @foreach ($setores as $setor)
                                            <option value="{{ $setor->id_setor }}"> {{ $setor->nome }} </option>        
                                        @endforeach
                                    @endif
                                </select>
                                <label>Setor</label>
                        </div>

                    </div>    

                    <div class="divider"></div><br>
                    <div class="row center-align">    
                        <button class="btn waves-effect waves-light green" type="submit">Enviar
                            <i class="material-icons right">send</i>
                        </button>
    
                        <button class="btn waves-effect waves-light red" type="reset">Limpar
                            <i class="material-icons right">clear</i>
                        </button>
                    </div>
                   
                </form>
            </div>   
        </div>
    </div>
</div>
@endsection
