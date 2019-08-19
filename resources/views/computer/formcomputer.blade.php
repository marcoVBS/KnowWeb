@extends('layouts.app')

@section('title', 'Computadores')

@section('content')

    <div class="container container2">
        <div class="row">
            
            <form-computer-component :update="{{ $update }}" :sos="{{ $sos }}" :setores="{{ $setores }}" 
                @isset($computerUpdate) 
                    :computerupdate="{{ $computerUpdate }}"
                @endisset 
            >
            </form-computer-component>
            
        </div>
    </div>

@endsection