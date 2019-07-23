<?php

namespace App\Models\Archive;

use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    protected $table = 'tb_arquivo';
    protected $primaryKey = 'id_arquivo';
    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i'
    ];
}
