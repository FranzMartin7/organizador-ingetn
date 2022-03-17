<?php

namespace App\Exports;

use App\Models\Registro;
use GuzzleHttp\Psr7\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RegistrosExport implements FromQuery,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
/*     public function collection()
    {
        return Registro::all();
    } */
    use Exportable;

    public function __construct($idGrupo,$idPeriodo,$gestion)
    {
        $this->idGrupo = $idGrupo;
        $this->idPeriodo = $idPeriodo;
        $this->gestion = $gestion;
    }
    public function query()
    {
        $registros = Registro::query()->join('users','users.id','registros.user_id')
        ->join('grupos','grupos.id','registros.grupo_id')
        ->join('materias','materias.id','grupos.materia_id')
        ->join('periodos','periodos.id','registros.periodo_id')
        ->where('materias.estado_id',2) 
        ->where('users.estado_id',2)
        ->where('registros.periodo_id', $this->idPeriodo)
        ->where('registros.gestion', $this->gestion)
        ->where('grupos.id', $this->idGrupo)
        ->selectRaw("users.numeroCI,
            users.apPaterno,
            users.apMaterno,
            users.name,
            users.email,
            materias.nombreMat,
            materias.sigla,
            grupos.grupo,
            concat(periodos.periodoAbrev,'/',registros.gestion) as semestralAnual            
            ")
        ->orderBy('users.apPaterno','asc')
        ->orderBy('users.apMaterno','asc')
        ->orderBy('materias.nombreMat','asc');

        return $registros;
    }
    public function headings(): array
    {
        return [
            'CI',
            'APELLIDO PATERNO',
            'APELLIDO MATERNO',
            'NOMBRES',
            'EMAIL',
            'MATERIA',
            'SIGLA',
            'GRUPO',
            'GESTIÓN',
        ];
    }
}
