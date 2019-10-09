@extends('layouts.app')

@section('title', 'Computadores')

@section('content')

    <div class="container container2">
        <h5 class="header grey-text center-align">Gestão de Computadores</h5>
        <div class="row">
            <computers-component
                :list_computers="{{ Auth::user()->can('list-computers') ? 1 : 0 }}"
                :view_computer="{{ Auth::user()->can('view-computer') ? 1 : 0 }}"
                :create_computer="{{ Auth::user()->can('create-computer') ? 1 : 0 }}"
                :edit_computer="{{ Auth::user()->can('edit-computer') ? 1 : 0 }}"
                :delete_computer="{{ Auth::user()->can('delete-computer') ? 1 : 0 }}"></computers-component>
        </div>
    </div>

@endsection