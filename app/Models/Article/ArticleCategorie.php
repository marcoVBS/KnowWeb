<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;

class ArticleCategorie extends Model
{
    protected $table = 'tb_categoria_artigo';
    protected $primaryKey = 'id_categoria_artigo';
    public $timestamps = false;
}
