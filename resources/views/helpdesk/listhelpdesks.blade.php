@extends('layouts.app')

@section('title', 'Help Desk')

@section('content')

    <div>
        <helpdesks-component :helpdesks="{{  $helpdesks  }}"></helpdesks-component>
    </div>

@endsection