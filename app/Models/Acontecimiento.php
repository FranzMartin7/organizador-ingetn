<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acontecimiento extends Model
{
    use HasFactory;
    protected $fillable = [
        'acontecimiento'
    ];
    public function eventos(){
        return $this->hasMany(Evento::class,'id');
    }
}
