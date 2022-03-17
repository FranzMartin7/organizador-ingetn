<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'materia_id',
        'grupo'
    ];

    public function materias(){//obsoleto
        return $this->belongsTo(Materia::class,'materia_id');
    }
    public function asignaturas(){
        return $this->hasMany(Asignatura::class,'grupo_id');
    }
    public function registros(){
        return $this->hasMany(Grupo::class,'grupo_id');
    }
}
