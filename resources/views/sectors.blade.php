@extends('layouts.app')

@section('title', 'Categorias')

@section('content')

    <div class="container">
        <h4 class="header grey-text center-align">Gestão de setores</h4>
        <div class="row">
            <div class="col s12">
                <sectors-component></sectors-component>
            </div>
        </div>
    </div>

@endsection