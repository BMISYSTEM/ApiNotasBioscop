<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OsApuntamiento extends Model
{
    use HasFactory;

    protected $fillable =[
        'id_user',
        'id_os',
        'id_estado',
        'nota',
        'fecha',
        'hora'
    ];
}
