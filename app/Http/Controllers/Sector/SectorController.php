<?php

namespace App\Http\Controllers\Sector;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Computer\Computer;
use App\Models\Sector\Setor;
use App\User;
use Illuminate\Support\Facades\Gate;

class SectorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Gate::allows('manage-sectors')) {
            return view('sectors');
        }else{
            abort(403,'Você não possui permissão para fazer gerenciar setores. Contate o administrador!');
        }
    }

    public function getSectors()
    {
        return response()->json([
            'sectors' => Setor::all()
        ]);
    }

    public function create(Request $request)
    {
        if (Gate::denies('manage-sectors')) {
            return false;
        }

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
        if (Gate::denies('manage-sectors')) {
            return false;
        }

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
        if (Gate::denies('manage-sectors')) {
            return false;
        }

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
