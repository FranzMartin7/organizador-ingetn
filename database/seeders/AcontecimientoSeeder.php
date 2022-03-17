<?php

namespace Database\Seeders;

use App\Models\Acontecimiento;
use Illuminate\Database\Seeder;

class AcontecimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Acontecimiento::create([
            'id'=>1,
            'acontecimiento'=>'Evento recurrente'
        ]);
        Acontecimiento::create([
            'id'=>2,
            'acontecimiento'=>'Evento único'
        ]);
    }
}
