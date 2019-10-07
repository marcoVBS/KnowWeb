<?php

namespace App\Models\Permission;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    protected $table = 'tb_usuario_permissao';
    protected $primaryKey = 'id_usuario_permissao';
    public $timestamps = false;
}
