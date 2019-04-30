<?php

namespace App\Models\HelpDesk;

use Illuminate\Database\Eloquent\Model;

class HelpDeskArchive extends Model
{
    protected $table = 'tb_arquivo_atendimento';
    protected $primaryKey = 'id_arquivo_atendimento';
    public $timestamps = false;
}
