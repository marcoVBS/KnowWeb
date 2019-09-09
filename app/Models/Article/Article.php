<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'tb_artigo';
    protected $primaryKey = 'id_artigo';
    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i',
        'updated_at' => 'datetime:d/m/Y H:i'
    ];
}