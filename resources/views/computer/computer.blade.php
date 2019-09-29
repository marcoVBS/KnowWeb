@extends('layouts.app')

@section('title', 'Computadores')

@section('content')

    <div class="container container2">
        <div class="row">
            <computer-component :computer="{{ $computer }}" :articles="{{ $articles }}"></computer-component>
        </div>
    </div>

@endsection