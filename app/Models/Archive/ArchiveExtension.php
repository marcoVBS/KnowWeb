<?php

namespace App\Models\Archive;

use Illuminate\Database\Eloquent\Model;

class ArchiveExtension extends Model
{
    protected $table = 'tb_extensao_arquivo';
    protected $primaryKey = 'id_extensao_arquivo';
    public $timestamps = false;
}
