<?php

namespace App\Http\Controllers\Equipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Equipment\EquipmentCategorie;
use App\Models\Equipment\Equipment;

class EquipmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = EquipmentCategorie::all();
        return view('equipments', ['categorias' => json_encode($categories)]);
    }

    public function getEquipments()
    {
        $equipments = Equipment::all();
        foreach($equipments as $equipment){
            $equipment->categoria = EquipmentCategorie::find($equipment->categoria_equipamento_id)->nome;
        }

        return response()->json([
            'equipments' => $equipments
        ]);
    }

    public function create(Request $request)
    {
        $equipment = new Equipment();
        $equipment->descricao = $request->descricao;
        $equipment->caracteristicas = $request->caracteristicas;
        $equipment->categoria_equipamento_id = $request->categoria;
        if($equipment->save()){
            return response()->json([
                'message' => "Equipamento {$request->nome} cadastrado com sucesso!",
                'stored' => true
            ]);
        }else{
            return response()->json([
                'message' => "Falha ao cadastrar equipamento!",
                'stored' => false
            ]);
        }
    }

    public function update(Request $request)
    {
        $equipment = Equipment::find($request->id_equipamento);
        $equipment->descricao = $request->descricao;
        $equipment->caracteristicas = $request->caracteristicas;
        $equipment->categoria_equipamento_id = $request->categoria_equipamento_id;
        if($equipment->save()){
            return response()->json([
                'message' => "Equipamento atualizado com sucesso!",
                'stored' => true
            ]);
        }else{
            return response()->json([
                'message' => "Falha ao atualizar equipamento!",
                'stored' => false
            ]);
        }
    }

    public function delete($id)
    {
        $equipment = Equipment::find($id);
        
        if($equipment->delete()){
            return response()->json([
                'message' => "Equipamento {$equipment->descricao} excluído com sucesso!",
                'deleted' => true
            ]);
        }else{
            return response()->json([
                'message' => "Falha ao excluir equipamento!",
                'deleted' => false
            ]);
        }
    }
}
