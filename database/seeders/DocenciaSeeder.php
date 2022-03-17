<?php

namespace Database\Seeders;
use App\Models\Docencia;
use Illuminate\Database\Seeder;

class DocenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Docencia::create([
            'id'=>1,
            'docencia'=>'Teórica'
        ]);
        Docencia::create([
            'id'=>2,
            'docencia'=>'Práctica'
        ]);
    }
}
