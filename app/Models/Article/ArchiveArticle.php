<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;

class ArchiveArticle extends Model
{
    protected $table = 'tb_artigo_arquivo';
    protected $primaryKey = 'id_artigo_arquivo';
    public $timestamps = false;
}
