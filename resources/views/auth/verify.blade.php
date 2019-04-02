@extends('layouts.begin')

@section('title', 'Verificação')

@section('content_begin')
<div class="container">
    <div class="row">
        <div class="col s12">
            <h3 class="header">Verifique seu endereço de e-mail</h3>
            <div class="card">
                
                <div class="card-content">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            <p>Um link de verificação foi enviado para o seu endereço de e-mail.</p>
                        </div>
                    @endif
                </div>

                <div class="card-action">
                    <p>Verifique seu e-mail em busca do link de verificação.</p>
                    <p>Se você não recebeu o email <a href="{{ route('verification.resend') }}">clique aqui para solicitar outro</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
