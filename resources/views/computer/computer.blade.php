@extends('layouts.app')

@section('title', 'Computadores')

@section('content')

    <div class="container container2">
        <div class="row">
            <computer-component :computer="{{ $computer }}" :articles="{{ $articles }}"
                :view_computer="{{ Auth::user()->can('view-computer') ? 1 : 0 }}"></computer-component>
        </div>
    </div>

@endsection