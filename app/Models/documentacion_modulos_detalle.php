<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class documentacion_modulos_detalle extends Model
{
    use HasFactory;

    protected $fillable = [
        'posicion',
        'tipo',
        'title',
        'image',
        'text',
        'id_modulo'
    ];
}
