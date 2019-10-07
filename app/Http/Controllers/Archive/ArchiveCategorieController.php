<?php

namespace App\Http\Controllers\Archive;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Archive\Archive;
use App\Models\Archive\ArchiveCategorie;

class ArchiveCategorieController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request){
        $categoria = new ArchiveCategorie();
        $categoria->nome = $request->nome;
        $categoria->descricao = $request->descricao;
        if($categoria->save()){
            return response()->json([
                'message' => "Categoria {$request->nome} cadastrada com sucesso!",
                'stored' => true
            ]);
        }else{
            return response()->json([
                'message' => "Falha ao cadastrar categoria!",
                'stored' => false
            ]);
        }
    }

    public function getCategories(){
        return response()->json([
            'categories' => ArchiveCategorie::all()
        ]);
    }

    public function delete($id){
        if(count(Archive::where('categoria_arquivo_id', $id)->get()) == 0){
            $categorie = ArchiveCategorie::find($id);
            
            if($categorie->delete()){
                return response()->json([
                    'message' => "Categoria {$categorie->nome} excluída com sucesso!",
                    'deleted' => true
                ]);
            }else{
                return response()->json([
                    'message' => "Falha ao excluir categoria!",
                    'deleted' => false
                ]);
            }
        }else{
            return response()->json([
                'message' => "Existem arquivos cadstrados com essa categoria!",
                'deleted' => false
            ]);
        }
    }

    public function update(Request $request){
        $categorie = ArchiveCategorie::find($request->id_categoria_arquivo);
        $categorie->nome = $request->nome;
        $categorie->descricao = $request->descricao;
        if($categorie->save()){
            return response()->json([
                'message' => "Categoria {$request->nome} atualizada com sucesso!",
                'stored' => true
            ]);
        }else{
            return response()->json([
                'message' => "Falha ao atualizar categoria!",
                'stored' => false
            ]);
        }
    }
}
