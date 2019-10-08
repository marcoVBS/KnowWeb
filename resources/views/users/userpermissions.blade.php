@extends('layouts.app')

@section('title', 'Permissões')

@section('content')

    <div class="container container3">
        <div class="row">
            <user-permissions-component :user="{{ $user }}"
                :manage_permissions="{{ Auth::user()->can('manage-permissions') ? 1 : 0 }}"
                :set_user_permissions="{{ Auth::user()->can('set-user-permissions') ? 1 : 0 }}"></user-permisses-component>
        </div>
    </div>

@endsection