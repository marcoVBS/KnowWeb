<?php

namespace App\Models\Permission;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'tb_permissao';
    protected $primaryKey = 'id_permissao';
    public $timestamps = false;
}
