@extends('layouts.app')

@section('title', 'Artigos')

@section('content')

    <div class="container container3">
        <div class="row">
            <article-component :article="{{ $article }}"></article-component>
        </div>
    </div>

@endsection