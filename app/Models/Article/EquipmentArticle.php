<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;

class EquipmentArticle extends Model
{
    protected $table = 'tb_artigo_equipamento';
    protected $primaryKey = 'id_artigo_equipamento';
    public $timestamps = false;
}
