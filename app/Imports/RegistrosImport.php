<?php

namespace App\Imports;

use App\Models\Registro;
use App\Models\Grupo;
use App\Models\Materia;
use App\Models\Role;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpsertColumns;
use Maatwebsite\Excel\Concerns\WithUpserts;

class RegistrosImport implements OnEachRow,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

/*     public function model(array $row)
    {
        $materia = Materia::where('sigla', $row[3])->first()->toArray();
        return new Registro([
            'user_id'  => $row[0],
            'periodo_id' => $row[1],
            'gestion'    => $row[2],
            'grupo_id'    => $materia['id']
        ]);
    }  */
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $rows      = $row->toArray();
        $User = User::where('numeroCI',$rows['ci'])->first();
        $email = User::where('email',$rows['email'])->first();
        if (!isset($User) && !isset($email)) {
            User::create([
                'name' => $rows['nombres'],
                'apPaterno' => $rows['apellido_paterno'],
                'apMaterno' => $rows['apellido_materno'],
                'numeroCI' => $rows['ci'],
                'registroUniv' => $rows['ru'],
                'nivele_id' => 4,
                'estado_id' => 2,
                'titulo_id' => 4,
                'email' =>$rows['email'],
                'password'=> bcrypt($rows['ci']),
            ])->assignRole(Role::find(4)->name);
        }
        $usuarios = User::where('apPaterno', $rows['apellido_paterno'])->where('apMaterno', $rows['apellido_materno'])->where('name', $rows['nombres'])->first();
        print_r($usuarios->id);
        $materias = Materia::where('sigla', $rows['sigla'])->first();
        $grupo = Grupo::where('grupo', $rows['grupo'])->where('materia_id', $materias->id)->first();
        $registro = Registro::where('user_id',$usuarios->id)->where('periodo_id',$rows['periodo'])->where('gestion',$rows['gestion'])->where('grupo_id',$grupo->id)->first();
        if (isset($registro)) {
            return null;
        } else {
            Registro::create([
                'user_id' => $usuarios->id,
                'periodo_id' => $rows['periodo'],
                'gestion' => $rows['gestion'],
                'grupo_id' => $grupo->id,
            ]);
        }
    }
    public function headingRow(): int
    {
        return 7;
    }
}
