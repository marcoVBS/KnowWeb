<?php

namespace App\Models\Equipment;

use Illuminate\Database\Eloquent\Model;

class EquipmentCategorie extends Model
{
    protected $table = 'tb_categoria_equipamento';
    protected $primaryKey = 'id_categoria_equipamento';
    public $timestamps = false;
}
