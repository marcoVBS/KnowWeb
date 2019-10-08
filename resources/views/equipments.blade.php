@extends('layouts.app')

@section('title', 'Equipamentos')

@section('content')

    <div class="container container2">
        <h5 class="header grey-text center-align">Gestão de equipamentos</h5>
        <div class="row">
            <equipments-component :categories="{{ $categorias }}"
                :list_equipments="{{ Auth::user()->can('list-equipments') ? 1 : 0 }}"
                :view_equipment="{{ Auth::user()->can('view-equipment') ? 1 : 0 }}"
                :create_equipment="{{ Auth::user()->can('create-equipment') ? 1 : 0 }}"
                :edit_equipment="{{ Auth::user()->can('edit-equipment') ? 1 : 0 }}"
                :delete_equipment="{{ Auth::user()->can('delete-equipment') ? 1 : 0 }}"></equipments-component>
        </div>
    </div>

@endsection