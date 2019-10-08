@extends('layouts.app')

@section('title', 'Senhas')

@section('content')

    <div class="container container2">
        <h5 class="header grey-text center-align">Gestão de senhas de acesso</h5>
        <div class="row">
            <passwords-component :equipamentos="{{ $equipamentos }}"
                :list_passwords="{{ Auth::user()->can('list-passwords') ? 1 : 0 }}"
                :view_password="{{ Auth::user()->can('view-password') ? 1 : 0 }}"
                :create_password="{{ Auth::user()->can('create-password') ? 1 : 0 }}"
                :edit_password="{{ Auth::user()->can('edit-password') ? 1 : 0 }}"
                :delete_password="{{ Auth::user()->can('delete-password') ? 1 : 0 }}"></passwords-component>
        </div>
    </div>

@endsection