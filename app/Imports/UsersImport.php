<?php

namespace App\Imports;

use App\Models\Registro;
use App\Models\Grupo;
use App\Models\Materia;
use App\Models\Nivel;
use App\Models\Estado;
use App\Models\Nivele;
use App\Models\Titulo;
use App\Models\Role;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpsertColumns;
use Maatwebsite\Excel\Concerns\WithUpserts;

class UsersImport implements /* ToModel, */OnEachRow,WithHeadingRow/* ,WithUpserts */
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
/*     public function model(array $row)
    {
        return new User([
            //
        ]);
    } */
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $rows      = $row->toArray();
        $User = User::where('name',$rows['nombres'])->where('apPaterno',$rows['apellido_paterno'])->where('apMaterno',$rows['apellido_materno'])->where('numeroCI',$rows['ci'])->where('registroUniv',$rows['ru'])->where('nivele_id',$rows['nivel'])->where('email',$rows['email'])->first();
        $email = User::where('email',$rows['email'])->first();
        if (isset($User) || isset($email)) {
            return null;
        } else {
            User::create([
                'name' => $rows['nombres'],
                'apPaterno' => $rows['apellido_paterno'],
                'apMaterno' => $rows['apellido_materno'],
                'numeroCI' => $rows['ci'],
                'registroUniv' => $rows['ru'],
                'nivele_id' => $rows['nivel'],
                'estado_id' => 2,
                'titulo_id' => $rows['titulo'],
                'email' =>$rows['email'],
                'password'=> bcrypt($rows['ci']),
            ])->assignRole(Role::find($rows['nivel'])->name);
        }
    }
    public function headingRow(): int
    {
        return 7;
    }
/*     public function uniqueBy()
    {
        return 'email';
    } */
}
