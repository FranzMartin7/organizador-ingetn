<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    use HasFactory;
    protected $fillable = [
        'materia_id',
        'semestre_id',
        'mencione_id'
    ];
    /* Relaciones de muchos a uno */
    public function materias(){
        return $this->belongsTo(Materia::class,'materia_id');
    }
    public function menciones(){
        return $this->belongsTo(Materia::class,'mencione_id');
    }
    public function semestres(){
        return $this->belongsTo(Materia::class,'semestre_id');
    }
}
