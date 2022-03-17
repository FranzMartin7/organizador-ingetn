<?php

namespace Database\Seeders;

use App\Models\Semestre;
use Illuminate\Database\Seeder;

class SemestreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Semestre::create([
            'id'=>1,
            'semestre'=>'Primer semestre'
        ]);
        Semestre::create([
            'id'=>2,
            'semestre'=>'Segundo semestre'
        ]);
        Semestre::create([
            'id'=>3,
            'semestre'=>'Tercer semestre'
        ]);
        Semestre::create([
            'id'=>4,
            'semestre'=>'Cuarto semestre'
        ]);
        Semestre::create([
            'id'=>5,
            'semestre'=>'Quinto semestre'
        ]);
        Semestre::create([
            'id'=>6,
            'semestre'=>'Sexto semestre'
        ]);
        Semestre::create([
            'id'=>7,
            'semestre'=>'Séptimo semestre'
        ]);
        Semestre::create([
            'id'=>8,
            'semestre'=>'Octavo semestre'
        ]);
        Semestre::create([
            'id'=>9,
            'semestre'=>'Noveno semestre'
        ]);
        Semestre::create([
            'id'=>10,
            'semestre'=>'Décimo semestre'
        ]);
    }
}
