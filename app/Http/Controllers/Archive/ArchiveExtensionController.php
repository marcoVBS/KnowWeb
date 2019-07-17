<?php

namespace App\Http\Controllers\Archive;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Archive\ArchiveExtension;

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
        $extensao = ArchiveExtension::find($id);
        
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
