<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'asignatura_id',
        'actividade_id',
        'aula_id',
        'descripcion',
        'enlace',
        'fecha',
        'horaInicio',
        'horaFinal',
        'acontecimiento_id',
        'periodo_id',
        'gestion'
    ];
    
    protected $dates = ['fecha','horaInicio','horaFinal'];

    public function asignaturas(){
        return $this->belongsTo(Asignatura::class,'id');
    }
    public function actividades(){
        return $this->belongsTo(Actividade::class,'actividade_id');
    }
    public function aulas(){
        return $this->belongsTo(Aula::class,'aula_id');
    }
}
