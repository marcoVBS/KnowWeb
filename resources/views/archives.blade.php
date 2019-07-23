@extends('layouts.app')

@section('title', 'Arquivos')

@section('content')

    <div>
        <h5 class="header grey-text center-align">Gestão de arquivos</h5>
        <div class="row">
            <archives-component :categories="{{ $categorias }}"></archives-component>
        </div>
    </div>

@endsection