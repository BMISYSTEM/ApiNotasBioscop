<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'fecha_inicio',
        'fecha_fin',
        'hora_inicio',
        'hora_fin',
        'user_id',
        'reunion',
        'apuntamiento',
        'completado'
    ];
}
