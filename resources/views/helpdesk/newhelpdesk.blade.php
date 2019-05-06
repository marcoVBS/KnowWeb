@extends('layouts.app')

@section('title', 'Help Desk')

@section('content')

    <div class="container">
        <form-helpdesk-component :categories="{{  $categories  }}"></form-helpdesk-component>
    </div>

@endsection