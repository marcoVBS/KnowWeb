@extends('layouts.app')

@section('title', 'Computadores')

@section('content')

    <div class="container container2">
        <div class="row">
            
            <form-computer-component :update="{{ $update }}" :sos="{{ $sos }}" :setores="{{ $setores }}" 
                @isset($computerUpdate) 
                    :computerupdate="{{ $computerUpdate }}"
                @endisset 

                :create_computer="{{ Auth::user()->can('create-computer') ? 1 : 0 }}"
                :edit_computer="{{ Auth::user()->can('edit-computer') ? 1 : 0 }}"
                :manage_operational_systems="{{ Auth::user()->can('manage-operational-systems') ? 1 : 0 }}">
            </form-computer-component>
            
        </div>
    </div>

@endsection