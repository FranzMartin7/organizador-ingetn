<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = [
        'asignatura_id',
        'dia',
        'horaInicio',
        'horaFinal',
        'aula_id',
        'generado',
        'periodo_id',
        'gestion'
    ];
}
