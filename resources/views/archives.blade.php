@extends('layouts.app')

@section('title', 'Arquivos')

@section('content')

    <div>
        <h5 class="header grey-text center-align">Gestão de arquivos</h5>
        <div class="row">
            <archives-component :categories="{{ $categorias }}"
                :manage_file_extensions="{{ Auth::user()->can('manage-file-extensions') ? 1 : 0 }}"
                :list_files="{{ Auth::user()->can('list-files') ? 1 : 0 }}"
                :upload_files="{{ Auth::user()->can('upload-files') ? 1 : 0 }}"
                :download_files="{{ Auth::user()->can('download-files') ? 1 : 0 }}"
                :delete_file="{{ Auth::user()->can('delete-file') ? 1 : 0 }}"></archives-component>
        </div>
    </div>

@endsection