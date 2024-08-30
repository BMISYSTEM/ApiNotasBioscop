<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class documentacion_modulo extends Model
{
    use HasFactory;

    protected $fillable = [

        'nombre',
        'sistema'

    ];
}
