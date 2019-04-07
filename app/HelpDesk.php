<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HelpDesk extends Model
{
    protected $table = 'tb_atendimento';
    protected $primaryKey = 'id_atendimento';
}
