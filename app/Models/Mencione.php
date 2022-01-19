<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mencione extends Model
{
    use HasFactory;
    /* Relaciones muchos a muchos */
    public function materias(){
        return $this->belongsToMany(Materia::class,'programas','mencion_id','materia_id');
    }
    public function semestres(){
        return $this->belongsToMany(Semestre::class,'programas','mencion_id','semestre_id');
    }
    public function programas(){
        return $this->hasMany(Programa::class,'registro_id');
    }
}
