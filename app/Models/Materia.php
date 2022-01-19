<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombreMat',
        'sigla',
        'area_id',
        'estado_id',
        'color'
    ];

    public function asignaturas(){
        return $this->hasMany(Asignatura::class,'materia_id');
    }
    public function grupos(){
        return $this->hasMany(Grupo::class,'materia_id');
    }
    public function registros(){
        return $this->hasMany(Registro::class,'id');
    }
    /* Relaciones muchos a muchos */
    public function menciones(){
        return $this->belongsToMany(Mencione::class,'programas','materia_id','mencion_id');
    }
    public function semestres(){
        return $this->belongsToMany(Semestre::class,'programas','materia_id','semestre_id');
    }
    public function programas(){
        return $this->hasMany(Programa::class,'materia_id');
    }
}
