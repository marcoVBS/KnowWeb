<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tb_tag';
    protected $primaryKey = 'id_tag';
    public $timestamps = false;
}
