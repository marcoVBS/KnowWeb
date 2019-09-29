<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;

class ComputerArticle extends Model
{
    protected $table = 'tb_artigo_computador';
    protected $primaryKey = 'id_artigo_computador';
    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i',
        'updated_at' => 'datetime:d/m/Y H:i'
    ];
}