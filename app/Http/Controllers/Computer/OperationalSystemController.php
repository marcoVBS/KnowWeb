<?php

namespace App\Http\Controllers\Computer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Computer\OperationalSystem;

class OperationalSystemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getSOs()
    {
        $sos = OperationalSystem::all();

        return response()->json([
            'systems' => $sos
        ]);
    }

    public function create(Request $request){
        $operSystem = new OperationalSystem();
        $operSystem->nome = $request->nome;
        $operSystem->versao = $request->versao;
        $operSystem->arquitetura = $request->arquitetura;
        if($operSystem->save()){
            return response()->json([
                'message' => "Sistema Operacional {$request->nome} cadastrado com sucesso!",
                'stored' => true
            ]);
        }else{
            return response()->json([
                'message' => "Falha ao cadastrar sistema operacional!",
                'stored' => false
            ]);
        }
    }

    public function update(Request $request)
    {
        $operSystem = OperationalSystem::find($request->id_sistema_operacional);
        $operSystem->nome = $request->nome;
        $operSystem->versao = $request->versao;
        $operSystem->arquitetura = $request->arquitetura;
        if($operSystem->save()){
            return response()->json([
                'message' => "Sistema operacional {$operSystem->nome} atualizado com sucesso!",
                'stored' => true
            ]);
        }else{
            return response()->json([
                'message' => "Falha ao atualizar sistema operacional!",
                'stored' => false
            ]);
        }
    }

    public function delete($id)
    {
        $operSystem = OperationalSystem::find($id);
        
        if($operSystem->delete()){
            return response()->json([
                'message' => "Sistema operacional {$operSystem->nome} excluído com sucesso!",
                'deleted' => true
            ]);
        }else{
            return response()->json([
                'message' => "Falha ao extensão sistema operacional!",
                'deleted' => false
            ]);
        }
    }
}
