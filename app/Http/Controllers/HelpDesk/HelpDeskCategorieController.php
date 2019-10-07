<?php

namespace App\Http\Controllers\HelpDesk;

use Illuminate\Http\Request;
use App\Models\HelpDesk\HelpDeskCategorie;
use App\Http\Controllers\Controller;
use App\Models\HelpDesk\HelpDesk;

class HelpDeskCategorieController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request){
        $categoria = new HelpDeskCategorie();
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
            'categories' => HelpDeskCategorie::all()
        ]);
    }

    public function delete($id){
        if(count(HelpDesk::where('categoria_atendimento_id', $id)->get()) == 0){
            $categorie = HelpDeskCategorie::find($id);
            
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
                'message' => "Existem atendimentos cadastrados com esta categoria!",
                'deleted' => false
            ]);
        }
    }

    public function update(Request $request){
        $categorie = HelpDeskCategorie::find($request->id_categoria_atendimento);
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