<?php

namespace App\Http\Controllers\Computer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Computer\Computer;
use App\Models\Sector\Setor;
use App\Models\Computer\OperationalSystem;

class ComputerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('computer.computers');
    }

    public function new()
    {
        $sectors = Setor::all();
        $sos = OperationalSystem::all();
        return view('computer.formcomputer', ['update' => json_encode(false), 'sos' => json_encode($sos),'setores' => json_encode($sectors)]);
    }

    public function change($id)
    {
        $sectors = Setor::all();
        $sos = OperationalSystem::all();
        $pc = Computer::find($id);
        return view('computer.formcomputer', ['update' => json_encode(true), 'sos' => json_encode($sos),'setores' => json_encode($sectors), 'computerUpdate' => json_encode($pc)]);
    }

    public function getComputers()
    {
        $computers = Computer::all();
        foreach($computers as $computer){
            $computer->setor = Setor::find($computer->setor_id)->nome;
        }

        return response()->json([
            'computers' => $computers
        ]);
    }

    public function create(Request $request)
    {
        $computer = new Computer();
        $computer->placa_mae = $request->placa_mae;
        $computer->processador = $request->processador;
        $computer->memoria_ram = $request->memoria_ram;
        $computer->unidade_armazenamento = $request->unidade_armazenamento;
        $computer->mac_ethernet = $request->mac_ethernet;
        $computer->mac_wireless = $request->mac_wireless;
        $computer->senha_usuario_adm = $request->senha_usuario_adm;
        $computer->nome_computador = $request->nome_computador;
        $computer->identificador_computador = $request->identificador_computador;
        $computer->programas_especificos = $request->programas_especificos;
        $computer->sistema_operacional_id = $request->sistema_operacional_id;
        $computer->setor_id = $request->setor_id;
        
        if($computer->save()){
            return response()->json([
                'message' => "Computador cadastrado com sucesso!",
                'stored' => true
            ]);
        }else{
            return response()->json([
                'message' => "Falha ao cadastrar computador!",
                'stored' => false
            ]);
        }
    }

    public function update(Request $request)
    {
        $computer = Computer::find($request->id_computador);
        $computer->placa_mae = $request->placa_mae;
        $computer->processador = $request->processador;
        $computer->memoria_ram = $request->memoria_ram;
        $computer->unidade_armazenamento = $request->unidade_armazenamento;
        $computer->mac_ethernet = $request->mac_ethernet;
        $computer->mac_wireless = $request->mac_wireless;
        $computer->senha_usuario_adm = $request->senha_usuario_adm;
        $computer->nome_computador = $request->nome_computador;
        $computer->identificador_computador = $request->identificador_computador;
        $computer->programas_especificos = $request->programas_especificos;
        $computer->sistema_operacional_id = $request->sistema_operacional_id;
        $computer->setor_id = $request->setor_id;
        if($computer->save()){
            return response()->json([
                'message' => "Computador atualizado com sucesso!",
                'stored' => true
            ]);
        }else{
            return response()->json([
                'message' => "Falha ao atualizar computador!",
                'stored' => false
            ]);
        }
    }

    public function delete($id)
    {
        $computer = Computer::find($id);
        
        if($computer->delete()){
            return response()->json([
                'message' => "Computador excluído com sucesso!",
                'deleted' => true
            ]);
        }else{
            return response()->json([
                'message' => "Falha ao excluir computador!",
                'deleted' => false
            ]);
        }
    }

}
