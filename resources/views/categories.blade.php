@extends('layouts.app')

@section('title', 'Categorias')

@section('content')

    <div class="container container2">
        <h4 class="header grey-text center-align">Gestão de categorias</h4>
        <div class="row">
            @canany(['manage-categorie-helpdesk', 'manage-categorie-file', 'manage-categorie-equipment', 'manage-categorie-article'])
                <div class="col s12">
                    <ul class="tabs">
                        @can('manage-categorie-helpdesk')
                            <li class="tab col s3"><a class="active" href="#atendimento">Atendimento</a></li>
                        @endcan
                        @can('manage-categorie-file')
                            <li class="tab col s3"><a href="#arquivo">Arquivo</a></li>
                        @endcan
                        @can('manage-categorie-article')
                            <li class="tab col s3"><a href="#artigo">Artigo</a></li>
                        @endcan
                        @can('manage-categorie-equipment')
                            <li class="tab col s3"><a href="#equipamento">Equipamento</a></li>
                        @endcan
                    </ul>
                    <div class="divider"></div>
                </div>
                @can('manage-categorie-helpdesk')
                    <div id="atendimento" class="col s12">
                        <categorie-helpdesk-component></categorie-helpdesk-component>
                    </div>
                @endcan
                @can('manage-categorie-file')
                    <div id="arquivo" class="col s12">
                        <categorie-archive-component></categorie-archive-component>
                    </div>
                @endcan
                @can('manage-categorie-article')
                    <div id="artigo" class="col s12">
                        <categorie-article-component></categorie-article-component>
                    </div>
                @endcan
                @can('manage-categorie-equipment')
                    <div id="equipamento" class="col s12">
                        <categorie-equipment-component></categorie-equipment-component>
                    </div>
                @endcan
            @endcan
        </div>
    </div>

@endsection