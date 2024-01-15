<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Os extends Model
{
    use HasFactory;

    protected $fillable =[
        'descripcion',
        'id_cliente',
        'user_id',
        'estado_id'
    ];
}
