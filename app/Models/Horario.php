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
    public function asignaturas(){
        return $this->belongsTo(Asignatura::class,'asignatura_id','id');
    }
    public function aulas(){
        return $this->belongsTo(Aula::class,'aula_id','id');
    }
    public function periodos(){
        return $this->belongsTo(Periodo::class,'periodo_id','id');
    }
}
