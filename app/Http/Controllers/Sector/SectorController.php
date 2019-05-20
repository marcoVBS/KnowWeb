<?php

namespace App\Http\Controllers\Sector;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sector\Setor;

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
    }

}
