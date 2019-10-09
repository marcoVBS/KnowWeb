<?php

namespace App\Http\Controllers\Computer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Computer\Computer;
use App\Models\Computer\OperationalSystem;
use Illuminate\Support\Facades\Gate;

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
        if (Gate::denies('manage-operational-systems')) {
            return false;
        }

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
        if (Gate::denies('manage-operational-systems')) {
            return false;
        }

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
        if (Gate::denies('manage-operational-systems')) {
            return false;
        }

        if(count(Computer::where('sistema_operacional_id', $id)->get()) == 0){
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
        }else{
            return response()->json([
                'message' => "Existem computadores cadastrados com esse sistema operacional!",
                'deleted' => false
            ]);
        }
    }
}
