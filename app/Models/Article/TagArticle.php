<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;

class TagArticle extends Model
{
    protected $table = 'tb_artigo_tag';
    protected $primaryKey = 'id_artigo_tag';
    public $timestamps = false;
}
