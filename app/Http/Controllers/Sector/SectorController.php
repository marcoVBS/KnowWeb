<?php

namespace App\Http\Controllers\Sector;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Computer\Computer;
use App\Models\Sector\Setor;
use App\User;

class SectorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('sectors');
    }

    public function getSectors()
    {
        return response()->json([
            'sectors' => Setor::all()
        ]);
    }

    public function create(Request $request)
    {
        $setor = new Setor();
        $setor->nome = $request->nome;
        $setor->descricao = $request->descricao;
        if($setor->save()){
            return response()->json([
                'message' => "Setor {$request->nome} cadastrado com sucesso!",
                'stored' => true
            ]);
        }else{
            return response()->json([
                'message' => "Falha ao cadastrar setor!",
                'stored' => false
            ]);
        }
    }

    public function update(Request $request)
    {
        $setor = Setor::find($request->id_setor);
        $setor->nome = $request->nome;
        $setor->descricao = $request->descricao;
        if($setor->save()){
            return response()->json([
                'message' => "Setor {$setor->nome} atualizado com sucesso!",
                'stored' => true
            ]);
        }else{
            return response()->json([
                'message' => "Falha ao atualizar setor!",
                'stored' => false
            ]);
        }
    }

    public function delete($id)
    {
        if(count(User::where('setor_id', $id)->get()) == 0 && count(Computer::where('setor_id', $id)->get()) == 0){
            $setor = Setor::find($id);
            
            if($setor->delete()){
                return response()->json([
                    'message' => "Setor {$setor->nome} excluído com sucesso!",
                    'deleted' => true
                ]);
            }else{
                return response()->json([
                    'message' => "Falha ao excluir setor!",
                    'deleted' => false
                ]);
            }
        }else{
            return response()->json([
                'message' => "Existem usuários e/ou computadores cadastrados com este setor!",
                'deleted' => false
            ]);
        }
    }
}
