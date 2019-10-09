@extends('layouts.app')

@section('title', 'Artigos')

@section('content')

    <div class="container container3">
        <div class="row">
            <form-article-component :update="{{ $update }}" :categories="{{ $categories }}" :all_tags="{{ $tags }}"
            @isset($articleUpdate) 
                    :articleUpdate="{{ $articleUpdate }}"
            @endisset
            
            :create_article="{{ Auth::user()->can('create-article') ? 1 : 0 }}"
            :edit_article="{{ Auth::user()->can('edit-article') ? 1 : 0 }}"></form-article-component>
        </div>
        
    </div>

@endsection