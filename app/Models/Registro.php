<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'grupo_id',
        'periodo_id',
        'gestion'
    ];
    public function grupos(){
        return $this->belongsTo(Grupo::class,'grupo_id','id');
    }
    public function users(){
        return $this->belongsTo(User::class,'id');
    }
}
