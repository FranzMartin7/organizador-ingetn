<?php

namespace Database\Seeders;

use App\Models\Nivele;
use Illuminate\Database\Seeder;

class NiveleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Nivele::create([
            'id'=>1,
            'nivel'=>'Administrador'
        ]);
        Nivele::create([
            'id'=>2,
            'nivel'=>'Docente'
        ]);
        Nivele::create([
            'id'=>3,
            'nivel'=>'Auxiliar'
        ]);
        Nivele::create([
            'id'=>4,
            'nivel'=>'Estudiante'
        ]);
    }
}
