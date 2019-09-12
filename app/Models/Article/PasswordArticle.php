<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;

class PasswordArticle extends Model
{
    protected $table = 'tb_artigo_senha';
    protected $primaryKey = 'id_artigo_senha';
    public $timestamps = false;
}
