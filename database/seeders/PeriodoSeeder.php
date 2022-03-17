<?php

namespace Database\Seeders;

use App\Models\Periodo;
use Illuminate\Database\Seeder;

class PeriodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Periodo::create([
            'id'=>1,
            'periodo'=>'Primero',
            'periodoAbrev'=>'I',
        ]);
        Periodo::create([
            'id'=>2,
            'periodo'=>'Segundo',
            'periodoAbrev'=>'II',
        ]);
        Periodo::create([
            'id'=>3,
            'periodo'=>'Verano',
            'periodoAbrev'=>'Ver',
        ]);
        Periodo::create([
            'id'=>4,
            'periodo'=>'Invierno',
            'periodoAbrev'=>'Inv',
        ]);
    }
}
