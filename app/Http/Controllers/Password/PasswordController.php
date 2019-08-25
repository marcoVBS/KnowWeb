<?php

namespace App\Http\Controllers\Password;

use App\Http\Controllers\Controller;
use App\Models\Equipment\Equipment;
use App\Models\Password\Password;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $equipments = Equipment::all();
        return view('passwords', ['equipamentos' => json_encode($equipments)]);
    }

    public function getPasswords()
    {
        $passwords = Password::all();
        foreach($passwords as $pass){
            if($pass->equipamento_id){   
                $pass->equipamento = Equipment::find($pass->equipamento_id);
            }
        }

        return response()->json([
            'passwords' => $passwords
        ]);
    }

    public function create(Request $request)
    {
        $password = new Password();
        $password->descricao = $request->descricao;
        $password->login = $request->login;
        $password->senha = $request->senha;
        $password->observacoes  = $request->observacoes ;
        $password->equipamento_id = $request->equipamento_id;
        if($password->save()){
            return response()->json([
                'message' => "Senha cadastrada com sucesso!",
                'stored' => true
            ]);
        }else{
            return response()->json([
                'message' => "Falha ao cadastrar senha!",
                'stored' => false
            ]);
        }
    }

    public function update(Request $request)
    {
        $password = Password::find($request->id_senha);
        $password->descricao = $request->descricao;
        $password->login = $request->login;
        $password->senha = $request->senha;
        $password->observacoes = $request->observacoes;
        $password->equipamento_id = $request->equipamento_id;
        if($password->save()){
            return response()->json([
                'message' => "Senha atualizada com sucesso!",
                'stored' => true
            ]);
        }else{
            return response()->json([
                'message' => "Falha ao atualizar senha!",
                'stored' => false
            ]);
        }
    }

    public function delete($id)
    {
        $password = Password::find($id);
        
        if($password->delete()){
            return response()->json([
                'message' => "Senha {$password->descricao} excluída com sucesso!",
                'deleted' => true
            ]);
        }else{
            return response()->json([
                'message' => "Falha ao excluir senha!",
                'deleted' => false
            ]);
        }
    }

}
