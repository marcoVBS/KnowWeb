<?php

namespace App\Http\Controllers\Archive;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Archive\Archive;
use App\Models\Archive\ArchiveExtension;
use Illuminate\Support\Facades\Gate;

class ArchiveExtensionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getExtensions()
    {
        return response()->json([
            'extensions' => ArchiveExtension::all()
        ]);
    }

    public function create(Request $request){
        if (Gate::denies('manage-file-extensions')) {
            return false;
        }

        $extensao = new ArchiveExtension();
        $extensao->extensao = $request->extensao;
        if($extensao->save()){
            return response()->json([
                'message' => "Extensão {$request->extensao} cadastrada com sucesso!",
                'stored' => true
            ]);
        }else{
            return response()->json([
                'message' => "Falha ao cadastrar extensão!",
                'stored' => false
            ]);
        }
    }

    public function delete($id)
    {
        if (Gate::denies('manage-file-extensions')) {
            return false;
        }

        $extensao = ArchiveExtension::find($id);
        $verifica_registros = Archive::where('extensao_arquivo_id', $id)->get();

        if(count($verifica_registros) > 0){
            return response()->json([
                'message' => "Existem arquivos cadastrados com essa extensão, favor excluí-los!",
                'deleted' => false
            ]);
        }else{
            if($extensao->delete()){
                return response()->json([
                    'message' => "Extensão {$extensao->extensao} excluída com sucesso!",
                    'deleted' => true
                ]);
            }else{
                return response()->json([
                    'message' => "Falha ao extensão extensão!",
                    'deleted' => false
                ]);
            }
        }
                
    }

}
