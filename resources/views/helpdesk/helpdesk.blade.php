@extends('layouts.app')

@section('title', 'Help Desk')

@section('content')

    <div class="container">
        {{-- Mudar para a página de listagem de chamados --}}
        <form-helpdesk-component :categories="{{  $categories  }}"></form-helpdesk-component>
    </div>

@endsection