<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Equipment\Equipment;
use App\Models\Equipment\EquipmentCategorie;

class EquipmentCategorieController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request){
        $categoria = new EquipmentCategorie();
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
            'categories' => EquipmentCategorie::all()
        ]);
    }

    public function delete($id){
        if(count(Equipment::where('categoria_equipamento_id', $id)->get()) == 0){
            $categorie = EquipmentCategorie::find($id);
            
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
                'message' => "Existem equipamentos cadastrados com esta categoria, favor desvinculá-los!",
                'deleted' => false
            ]);
        }
    }

    public function update(Request $request){
        $categorie = EquipmentCategorie::find($request->id_categoria_equipamento);
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
