<?php

namespace App\Http\Controllers\Password;

use App\Http\Controllers\Controller;
use App\Models\Equipment\Equipment;
use App\Models\Password\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(Gate::allows('list-passwords')){
            $equipments = Equipment::all();
            return view('passwords', ['equipamentos' => json_encode($equipments)]);
        }else{
            abort(403,'Você não possui permissão para gerenciar senhas. Contate o administrador!');
        }
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
        if (Gate::denies('create-password')) {
            return false;
        }

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
        if (Gate::denies('edit-password')) {
            return false;
        }

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
        if (Gate::denies('delete-password')) {
            return false;
        }

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
