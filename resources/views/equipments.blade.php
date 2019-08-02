@extends('layouts.app')

@section('title', 'Equipamentos')

@section('content')

    <div class="container container2">
        <h5 class="header grey-text center-align">Gestão de equipamentos</h5>
        <div class="row">
            <equipments-component :categories="{{ $categorias }}"></equipments-component>
        </div>
    </div>

@endsection