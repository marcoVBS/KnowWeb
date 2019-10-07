@extends('layouts.app')

@section('title', 'Permissões')

@section('content')

    <div class="container container3">
        <div class="row">
            <user-permissions-component :user="{{ $user }}"></user-permisses-component>
        </div>
    </div>

@endsection