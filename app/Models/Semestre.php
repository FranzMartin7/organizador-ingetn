<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semestre extends Model
{
    use HasFactory;
    /* Relaciones muchos a muchos */
    public function materias(){
        return $this->belongsToMany(Materia::class,'programas','semestre_id','materia_id');
    }
    public function menciones(){
        return $this->belongsToMany(Mencione::class,'programas','semestre_id','mencion_id');
    }
    public function programas(){
        return $this->hasMany(Programa::class,'semestre_id');
    }
}
