<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;

class ArticleArchive extends Model
{
    protected $table = 'tb_arquivo_artigo';
    protected $primaryKey = 'id_arquivo_artigo';
    public $timestamps = false;
}
