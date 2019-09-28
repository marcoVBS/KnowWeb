@extends('layouts.app')

@section('title', 'Usuários')

@section('content')

    <div class="container container2">
        <h5 class="header grey-text center-align">Gestão de usuários</h5>
        <div class="row">
            <users-component :sectors="{{ $sectors }}" :user_logged="{{ Auth::user() }}"></users-component>
        </div>
    </div>

@endsection