<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;

class HelpdeskArticle extends Model
{
    protected $table = 'tb_artigo_atendimento';
    protected $primaryKey = 'id_artigo_atendimento';
    public $timestamps = false;
}
