<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'grupo_id',
        'actividade_id',
        'docencia_id',
        'carga',
        'estado_id'
    ];

    public function users(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function actividades(){
        return $this->belongsTo(Actividade::class,'actividade_id','id');
    }
    public function docencias(){
        return $this->belongsTo(Docencia::class,'docencia_id','id');
    }
    public function grupos(){
        return $this->belongsTo(Grupo::class,'grupo_id');
    }
    public function eventos(){
        return $this->hasMany(Evento::class,'id','asignatura_id');
    }
    public function horarios(){
        return $this->hasMany(Horario::class,'id','asignatura_id');
    }    
}
