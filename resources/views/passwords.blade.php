@extends('layouts.app')

@section('title', 'Equipamentos')

@section('content')

    <div class="container container2">
        <h5 class="header grey-text center-align">Gestão de senhas de acesso</h5>
        <div class="row">
            <passwords-component :equipamentos="{{ $equipamentos }}"></passwords-component>
        </div>
    </div>

@endsection