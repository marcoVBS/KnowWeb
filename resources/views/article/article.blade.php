@extends('layouts.app')

@section('title', 'Artigos')

@section('content')

    <div class="container container2">
        <div class="row">
            <article-component :article="{{ $article }}"
                :edit_article="{{ Auth::user()->can('edit-article') ? 1 : 0 }}"
                :download_files="{{ Auth::user()->can('download-files') ? 1 : 0 }}"
                :view_password="{{ Auth::user()->can('view-password') ? 1 : 0 }}"></article-component>
        </div>
    </div>

@endsection