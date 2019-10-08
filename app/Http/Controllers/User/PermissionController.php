<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Permission\Permission;
use App\Models\Permission\UserPermission;
use App\Models\Sector\Setor;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if(Gate::allows('set-user-permissions') && (Auth::id() <> $request->id)) {
            $user = User::find($request->id);
    
            if($user->tipo_usuario == "Membro"){
                $permissions = UserPermission::where('usuario_id', $request->id)->get();
                if(count($permissions) > 0){
                    foreach ($permissions as $perm) {
                        $permissions_id[] = $perm->permissao_id;
                    }
                    $user->permissoes = $permissions_id;
                }
        
                return view('users.userpermissions', ['user' => json_encode($user)]);
            }else{
                return redirect()->route('users');
            }
        }else{
            abort(403,'Você não possui permissão para gerenciar permissões de usuários. Contate o administrador!');
        }

    }

    public function getPermissions()
    {
        if (Gate::allows('manage-permissions') || Gate::allows('set-user-permissions') ) {
            return response()->json([
                'permissions' => Permission::all()
            ]);
        }else{
            return false;
        }

    }

    public function create(Request $request){
        if (Gate::denies('manage-permissions')) {
            return false;
        }

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
        if (Gate::denies('manage-permissions')) {
            return false;
        }

        $permissao = Permission::find($id);
        $verifica_registros = UserPermission::where('permissao_id', $id)->get();

        if(count($verifica_registros) > 0){
            return response()->json([
                'message' => "Existem usuarios que possuem essa permissão, favor desvinculá-los!",
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
        if (Gate::denies('set-user-permissions')) {
            return false;
        }

        $stored = true; 

        if(count(UserPermission::where('usuario_id', $request->id_usuario)->get()) > 0){
            UserPermission::where('usuario_id', $request->id_usuario)->delete(); 
        }

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
       
        if($stored){
            return response()->json([
                'message' => "Permissões do usuário atualizadas com sucesso!",
                'stored' => true
            ]);
        }

    }
}
