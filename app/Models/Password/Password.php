<?php

namespace App\Models\Password;

use Illuminate\Database\Eloquent\Model;

class Password extends Model
{
    protected $table = 'tb_senha';
    protected $primaryKey = 'id_senha';
}
