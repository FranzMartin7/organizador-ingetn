<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'apPaterno',
        'apMaterno',
        'nivele_id',
        'estado_id',
        'titulo_id',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        /* 'password', */
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function materias(){
        return $this->hasManyThrough(Materia::class,Asignatura::class,'user_id','id','id','materia_id');
    }
    /* Relaciones uno a muchos */
    public function asignaturas(){
        return $this->hasMany(Asignatura::class,'user_id','id');
    }
    public function registros(){
        return $this->hasMany(Registro::class,'user_id');
    }
    public function titulos(){
        return $this->belongsTo(Titulo::class,'titulo_id','id');
    }
    public function niveles(){ //obsoleto
        return $this->belongsTo(Nivele::class,'nivele_id','id');
    } 
    public function adminlte_image(){
        return auth()->user()->profile_photo_url;
    }
    public function adminlte_desc()
    {
        return auth()->user()->niveles->nivel;
    }

    public function adminlte_profile_url()
    {
        return 'profile/show';
    }
}
