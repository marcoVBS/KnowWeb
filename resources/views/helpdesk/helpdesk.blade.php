@extends('layouts.app')

@section('title', 'Help Desk')

@section('content')

    <div class="container">
        <helpdesk-component :user_id="{{ Auth::id() }}" :helpdesk="{{  $helpdesk  }}"></helpdesk-component>
    </div>

@endsection