<?php

namespace App\Models\HelpDesk;

use Illuminate\Database\Eloquent\Model;

class HelpDesk extends Model
{
    protected $table = 'tb_atendimento';
    protected $primaryKey = 'id_atendimento';
    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i'
    ];
}
