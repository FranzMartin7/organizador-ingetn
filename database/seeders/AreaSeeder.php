<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Area::create([
            'id'=>1,
            'area'=>'Básico'
        ]);
        Area::create([
            'id'=>2,
            'area'=>'Profesional'
        ]);
        Area::create([
            'id'=>3,
            'area'=>'Especialidad'
        ]);
    }
}
