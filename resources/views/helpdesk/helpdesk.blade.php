@extends('layouts.app')

@section('title', 'Help Desk')

@section('content')

    <div class="container">
        <helpdesk-component :helpdesk="{{  $helpdesk  }}"></helpdesk-component>
    </div>

@endsection