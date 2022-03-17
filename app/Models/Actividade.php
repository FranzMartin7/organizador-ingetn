<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividade extends Model
{
    use HasFactory;
    protected $fillable = [
        'actividad',
        'actividadAbrev'
    ];

    public function asignaturas(){
        return $this->hasMany(Asignatura::class,'id');
    }
    public function eventos(){
        return $this->hasMany(Evento::class,'id');
    }
}
