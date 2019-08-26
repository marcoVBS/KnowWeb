<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Sector\Setor;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $setores = Setor::all();
        return view('profile', ['sectors' => json_encode($setores)]);
    }

    public function updateImage(Request $request)
    {
        if($request->hasFile('file') && $request->file('file')->isValid()){
            $extension = $request->file->getClientOriginalExtension();
            $name = Auth::user()->cpf.'.'.$extension;
            $path = '/KnowWeb/public/storage/usuarios/' . $name;
            if($request->file->storeAs('/usuarios/', $name)){
                $user = User::find(Auth::id());
                $user->foto = $path;
                if($user->save()){
                    return response()->json([
                        'message' => "Foto atualizada com sucesso!",
                        'stored' => true
                    ]);
                }else{
                    return response()->json([
                        'message' => "Falha ao atualizar foto!",
                        'stored' => false
                    ]);
                }
            }else{
                return response()->json([
                    'message' => "Falha ao atualizar foto!",
                    'stored' => false
                ]);
            }
        }
    }

    public function updateProfile(Request $request)
    {
        $user = User::find($request->id_usuario);
        $user->nome = $request->nome;
        $verifica_email = User::where('email', $request->email)->get();
        if(count($verifica_email) > 0){
            return response()->json([
                'message' => "O email informado já existe no sistema!",
                'stored' => false
            ]);
        }
        $user->email = $request->email;
        $user->telefone = $request->telefone;
        $user->cpf = $request->cpf;
        $user->setor_id = $request->setor_id;
        if($user->save()){
            return response()->json([
                'message' => "Perfil atualizado com sucesso!",
                'stored' => true
            ]);
        }else{
            return response()->json([
                'message' => "Falha ao atualizar perfil!",
                'stored' => false
            ]);
        }
    }

    public function updatePassword(Request $request)
    {
        $user = User::find(Auth::id());
        $nova_senha = Hash::make($request->nova_senha);
        
        if(Hash::check($request->senha_atual, $user->password)){
            $user->password = $nova_senha;
            if($user->save()){
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
        }else{
            return response()->json([
                'message' => "A senha atual informada não confere",
                'stored' => false
            ]);
        }
    }
}