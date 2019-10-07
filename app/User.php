<?php

namespace App;

use App\Models\Permission\Permission;
use App\Models\Permission\UserPermission;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'tb_usuario';
    protected $primaryKey = 'id_usuario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'email', 'telefone', 'cpf', 'foto','password', 'tipo_usuario', 'setor_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //Função do sistema de ACLs
    //Verifica se o usuário possui a determinada permissão
    public function testPermission($id, Permission $permission){
        $user_permissions = UserPermission::where('usuario_id', $id)->get();
        return $user_permissions->contains('permissao_id', $permission->id_permissao);
    }

}
