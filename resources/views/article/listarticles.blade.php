@extends('layouts.app')

@section('title', 'Artigos')

@section('content')

    <div class="container container2">
        <div class="row">
            <articles-component :user_id="{{ Auth::user()->id_usuario }}"
                :create_article="{{ Auth::user()->can('create-article') ? 1 : 0 }}"
                :edit_article="{{ Auth::user()->can('edit-article') ? 1 : 0 }}"
                :delete_article="{{ Auth::user()->can('delete-article') ? 1 : 0 }}"></articles-component>
        </div>
        
    </div>

@endsection