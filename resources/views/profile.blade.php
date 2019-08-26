@extends('layouts.app')

@section('title', 'Perfil')

@section('content')

    <div class="container container2">
        <div class="row">
            <div class="col s12">
                <profile-component :sectors="{{ $sectors }}" :user_logged="{{ Auth::user() }}"></profile-component>
            </div>
        </div>
    </div>

@endsection