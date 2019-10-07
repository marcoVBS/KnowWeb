<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Permission\Permission;
use App\Models\Permission\UserPermission;
use App\User;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = User::find($request->id);

        $permissions = UserPermission::where('usuario_id', $request->id)->get();
        if(count($permissions) > 0){
            foreach ($permissions as $perm) {
                $permissions_id[] = $perm->permissao_id;
            }
            $user->permissoes = $permissions_id;
        }

        return view('users.userpermissions', ['user' => json_encode($user)]);
    }

    public function getPermissions()
    {
        return response()->json([
            'permissions' => Permission::all()
        ]);
    }

    public function create(Request $request){
        if(count(Permission::where('nome', $request->permissao)->get()) > 0){
            return response()->json([
                'message' => "Permissão já existente no sistema!",
                'stored' => false
            ]);
        }else{
            $permissao = new Permission();
            $permissao->nome = $request->permissao;
            if($permissao->save()){
                return response()->json([
                    'message' => "Permissão {$request->permissao} cadastrada com sucesso!",
                    'stored' => true
                ]);
            }else{
                return response()->json([
                    'message' => "Falha ao cadastrar permissao!",
                    'stored' => false
                ]);
            }
        }
    
    }

    public function delete($id)
    {
        $permissao = Permission::find($id);
        $verifica_registros = UserPermission::where('permissao_id', $id)->get();

        if(count($verifica_registros) > 0){
            return response()->json([
                'message' => "Existem arquivos usuarios que possuem essa permissão, favor desvinculá-los!",
                'deleted' => false
            ]);
        }else{
            if($permissao->delete()){
                return response()->json([
                    'message' => "Permissão {$permissao->nome} excluída com sucesso!",
                    'deleted' => true
                ]);
            }else{
                return response()->json([
                    'message' => "Falha ao extensão permissão!",
                    'deleted' => false
                ]);
            }
        }          
    }

    public function updateUserPermissions(Request $request)
    {
        $stored = true; 

        if(UserPermission::where('usuario_id', $request->id_usuario)->delete()){
            if(count($request->permissoes) > 0){
                foreach ($request->permissoes as $perm) {
                    $user_permission = new UserPermission();
                    $user_permission->usuario_id = $request->id_usuario;
                    $user_permission->permissao_id = $perm;
                    if($user_permission->save()){
                        $stored = true;
                    }else{
                        return response()->json([
                            'message' => "Falha ao atualizar permissões do usuario!",
                            'stored' => false
                        ]);
                    }
                }
            }
        }else{
            return response()->json([
                'message' => "Falha ao atualizar permissões do usuario!",
                'stored' => false
            ]);
        }

        if($stored){
            return response()->json([
                'message' => "Permissões do usuário atualizadas com sucesso!",
                'stored' => true
            ]);
        }

    }
}
