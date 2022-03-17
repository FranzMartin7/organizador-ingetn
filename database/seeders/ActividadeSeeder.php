<?php

namespace Database\Seeders;

use App\Models\Actividade;
use Illuminate\Database\Seeder;

class ActividadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Actividade::create([
            'id'=>1,
            'actividad'=>'Teoría',
            'actividadAbrev'=>'Teo.'
        ]);
        Actividade::create([
            'id'=>2,
            'actividad'=>'Laboratorio',
            'actividadAbrev'=>'Lab.'
        ]);
        Actividade::create([
            'id'=>3,
            'actividad'=>'Ayudantía',
            'actividadAbrev'=>'Aux.'
        ]);
        Actividade::create([
            'id'=>4,
            'actividad'=>'Clase recuperatoria',
            'actividadAbrev'=>'Recuperatorio.'
        ]);
        Actividade::create([
            'id'=>5,
            'actividad'=>'Clase extra',
            'actividadAbrev'=>'Extra'
        ]);
        Actividade::create([
            'id'=>6,
            'actividad'=>'Examen parcial',
            'actividadAbrev'=>'Parcial'
        ]);
        Actividade::create([
            'id'=>7,
            'actividad'=>'Examen previo',
            'actividadAbrev'=>'Previo'
        ]);
        Actividade::create([
            'id'=>8,
            'actividad'=>'Examen final',
            'actividadAbrev'=>'Final'
        ]);
        Actividade::create([
            'id'=>9,
            'actividad'=>'Exmmen 2T',
            'actividadAbrev'=>'2T'
        ]);
        Actividade::create([
            'id'=>10,
            'actividad'=>'Entrega de práctica',
            'actividadAbrev'=>'Práctica'
        ]);
        Actividade::create([
            'id'=>11,
            'actividad'=>'Entrega de informe',
            'actividadAbrev'=>'Informe'
        ]);
        Actividade::create([
            'id'=>12,
            'actividad'=>'Presentación de proyecto',
            'actividadAbrev'=>'Proyecto'
        ]);
    }
}
