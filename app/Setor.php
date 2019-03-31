<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setor extends Model
{
    protected $table = 'tb_setor';
    protected $primaryKey = 'id_setor';
    public $timestamps = false;
}
