<?php

namespace App\Models\Archive;

use Illuminate\Database\Eloquent\Model;

class ArchiveCategorie extends Model
{
    protected $table = 'tb_categoria_arquivo';
    protected $primaryKey = 'id_categoria_arquivo';
    public $timestamps = false;
}
