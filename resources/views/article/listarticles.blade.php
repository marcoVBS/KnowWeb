@extends('layouts.app')

@section('title', 'Artigos')

@section('content')

    <div class="container container2">
        <h5 class="header grey-text center-align">Artigos</h5>
        <div class="row">
            <articles-component :user_id="{{ Auth::user()->id_usuario }}" :articles="{{ $articles }}"></articles-component>
        </div>
        
    </div>

@endsection