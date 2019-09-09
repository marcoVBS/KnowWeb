@extends('layouts.app')

@section('title', 'Artigos')

@section('content')

    <div class="container container2">
        <div class="row">
            <form-article-component :update="{{ $update }}" :categories="{{ $categories }}" :all_tags="{{ $tags }}"></form-article-component>
        </div>
        
    </div>

@endsection