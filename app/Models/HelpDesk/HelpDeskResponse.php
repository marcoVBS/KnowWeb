<?php

namespace App\Models\HelpDesk;

use Illuminate\Database\Eloquent\Model;

class HelpDeskResponse extends Model
{
    protected $table = 'tb_resposta_atendimento';
    protected $primaryKey = 'id_resposta_atendimento';
}
