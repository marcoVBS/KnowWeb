<?php

namespace App\Models\HelpDesk;

use Illuminate\Database\Eloquent\Model;

class HelpDeskCategorie extends Model
{
    protected $table = 'tb_categoria_atendimento';
    protected $primaryKey = 'id_categoria_atendimento';
    public $timestamps = false;
}
