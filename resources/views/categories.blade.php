@extends('layouts.app')

@section('title', 'Categorias')

@section('content')

    <div class="container container2">
        <h4 class="header grey-text center-align">Gestão de categorias</h4>
        <div class="row">
            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s3"><a class="active" href="#atendimento">Atendimento</a></li>
                    <li class="tab col s3"><a href="#arquivo">Arquivo</a></li>
                    <li class="tab col s3"><a href="#artigo">Artigo</a></li>
                    <li class="tab col s3"><a href="#equipamento">Equipamento</a></li>
                </ul>
                <div class="divider"></div>
            </div>
            <div id="atendimento" class="col s12">
                <categorie-helpdesk-component></categorie-helpdesk-component>
            </div>
            <div id="arquivo" class="col s12">
                <categorie-archive-component></categorie-archive-component>
            </div>
            <div id="artigo" class="col s12">
                <categorie-article-component></categorie-article-component>
            </div>
            <div id="equipamento" class="col s12">
                <categorie-equipment-component></categorie-equipment-component>
            </div>
        </div>
    </div>

@endsection