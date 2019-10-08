@extends('layouts.app')

@section('title', 'Setores')

@section('content')

    <div class="container">
        <h4 class="header grey-text center-align">Gestão de setores</h4>
        <div class="row">
            <div class="col s12">
                @can('manage-sectors')
                    <sectors-component></sectors-component>
                @endcan
            </div>
        </div>
    </div>

@endsection