<?php

namespace App\Models\Computer;

use Illuminate\Database\Eloquent\Model;

class OperationalSystem extends Model
{
    protected $table = 'tb_sistema_operacional';
    protected $primaryKey = 'id_sistema_operacional';
    public $timestamps = false;
}
