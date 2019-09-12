@extends('layouts.app')

@section('title', 'Artigos')

@section('content')

    <div class="container container3">
        <div class="row">
            <form-article-component :update="{{ $update }}" :categories="{{ $categories }}" :all_tags="{{ $tags }}"
            @isset($articleUpdate) 
                    :articleUpdate="{{ $articleUpdate }}"
            @endisset
            ></form-article-component>
        </div>
        
    </div>

@endsection