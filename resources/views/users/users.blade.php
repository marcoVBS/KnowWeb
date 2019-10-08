@extends('layouts.app')

@section('title', 'Usuários')

@section('content')

    <div class="container container2">
        <h5 class="header grey-text center-align">Gestão de usuários e permissões</h5>
        <div class="row">
            <users-component :sectors="{{ $sectors }}" :user_logged="{{ Auth::user() }}" 
                :manage_permissions="{{ Auth::user()->can('manage-permissions') ? 1 : 0 }}"
                :set_user_permissions="{{ Auth::user()->can('set-user-permissions') ? 1 : 0 }}"
                :list_users="{{ Auth::user()->can('list-users') ? 1 : 0 }}"
                :create_user="{{ Auth::user()->can('create-user') ? 1 : 0 }}"
                :disable_user="{{ Auth::user()->can('disable-user') ? 1 : 0 }}"
                :edit_user="{{ Auth::user()->can('edit-user') ? 1 : 0 }}"></users-component>
        </div>
    </div>

@endsection