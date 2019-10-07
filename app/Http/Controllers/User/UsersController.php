<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Sector\Setor;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $sectors = Setor::all();
        return view('users.users', ['sectors' => json_encode($sectors)]);
    }

    public function getUsers(){
        $users = User::orderBy('tipo_usuario', 'asc')->orderBy('nome', 'asc')->get();
        foreach ($users as $user) {
            $user->setor = Setor::find($user->setor_id)->nome;
        }
        return response()->json([
            'users' => $users
        ]);
    }

    public function create(Request $request)
    {
        $user = new User();
        $user->nome = $request->nome;
        
        if(count(User::where('email', $request->email)->get()) > 0){
            return response()->json([
                'message' => "O email informado já existe no sistema!",
                'stored' => false
            ]);
        }else{
            $user->email = $request->email;
        }

        $user->telefone = $request->telefone;

        if(count(User::where('cpf', $request->cpf)->get()) > 0){
            return response()->json([
                'message' => "O CPF informado já existe no sistema!",
                'stored' => false
            ]);
        }else{
            $user->cpf = $request->cpf;
        }
        
        $user->password = Hash::make($request->password);
        $user->tipo_usuario = $request->tipo_usuario;
        $user->setor_id = $request->setor_id;
        
        if($user->save()){
            return response()->json([
                'message' => "Usuário {$request->nome} cadastrado com sucesso!",
                'stored' => true
            ]);
        }else{
            return response()->json([
                'message' => "Falha ao cadastrar usuário!",
                'stored' => false
            ]);
        }
    }

    public function update(Request $request)
    {
        $user = User::find($request->id_usuario);
        $user->nome = $request->nome;
        
        $verifica_email = User::where('email', $request->email)->get();
        if(count($verifica_email) > 0){
            if($verifica_email[0]->id_usuario !== $request->id_usuario){
                return response()->json([
                    'message' => "O email informado já existe no sistema!",
                    'stored' => false
                ]);
            }
        }
        $user->email = $request->email;

        $user->telefone = $request->telefone;

        $verifica_cpf = User::where('cpf', $request->cpf)->get();
        if(count($verifica_cpf) > 0){
            if($verifica_cpf[0]->id_usuario !== $request->id_usuario){
                return response()->json([
                    'message' => "O CPF informado já existe no sistema!",
                    'stored' => false
                ]);
            }
        }
        $user->cpf = $request->cpf;

        if($request->password){
            $user->password = Hash::make($request->password);
        }

        $user->setor_id = $request->setor_id;
        $user->tipo_usuario = $request->tipo_usuario;

        if($user->save()){
            return response()->json([
                'message' => "Usuário {$request->nome} atualizado com sucesso!",
                'stored' => true
            ]);
        }else{
            return response()->json([
                'message' => "Falha ao atualizar usuário!",
                'stored' => false
            ]);
        }
    }

    public function delete($id)
    {
        $user = User::find($id);
        
        if($user->delete()){
            return response()->json([
                'message' => "Usuario {$user->nome} excluído com sucesso!",
                'deleted' => true
            ]);
        }else{
            return response()->json([
                'message' => "Falha ao excluir usuário!",
                'deleted' => false
            ]);
        }
    }

}
