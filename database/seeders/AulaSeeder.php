<?php

namespace Database\Seeders;

use App\Models\Aula;
use Illuminate\Database\Seeder;

class AulaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Aula::create([
            'id'=>1,
            'aula'=>'Aula virtual',
            'aulaAbrev'=>'Virtual'
        ]);
        Aula::create([
            'id'=>2,
            'aula'=>'Aula 304',
            'aulaAbrev'=>'Aula 304'
        ]);
        Aula::create([
            'id'=>3,
            'aula'=>'Aula 305',
            'aulaAbrev'=>'Aula 305'
        ]);
        Aula::create([
            'id'=>4,
            'aula'=>'Aula 306',
            'aulaAbrev'=>'Aula 306'
        ]);
        Aula::create([
            'id'=>5,
            'aula'=>'Aula 307',
            'aulaAbrev'=>'Aula 307'
        ]);
        Aula::create([
            'id'=>6,
            'aula'=>'Aula 308',
            'aulaAbrev'=>'Aula 308'
        ]);
        Aula::create([
            'id'=>7,
            'aula'=>'Aula Docente',
            'aulaAbrev'=>'Aula Doc.'
        ]);
        Aula::create([
            'id'=>8,
            'aula'=>'Aula Maestría',
            'aulaAbrev'=>'Aula Mtr'
        ]);
        Aula::create([
            'id'=>9,
            'aula'=>'Laboratorio Electrónica',
            'aulaAbrev'=>'Lab. Etn'
        ]);
        Aula::create([
            'id'=>10,
            'aula'=>'Laboratorio Control',
            'aulaAbrev'=>'Lab. Control'
        ]);
        Aula::create([
            'id'=>11,
            'aula'=>'Laboratorio Telecomunicaciones',
            'aulaAbrev'=>'Lab. Tele'
        ]);
        Aula::create([
            'id'=>12,
            'aula'=>'Laboratorio Sistemas',
            'aulaAbrev'=>'Lab. Sistemas'
        ]);
        Aula::create([
            'id'=>13,
            'aula'=>'Sala Computación',
            'aulaAbrev'=>'Sala Comp.'
        ]);
        Aula::create([
            'id'=>14,
            'aula'=>'Aula Mezzanine',
            'aulaAbrev'=>'Mezzanine'
        ]);
        Aula::create([
            'id'=>15,
            'aula'=>'Aula eléctrica',
            'aulaAbrev'=>'Aula Elt'
        ]);
    }
}
