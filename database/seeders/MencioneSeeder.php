<?php

namespace Database\Seeders;

use App\Models\Mencione;
use Illuminate\Database\Seeder;

class MencioneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Mencione::create([
            'id'=>1,
            'mencion'=>'Control',
            'mencionAbrev'=>'Control'
        ]);
        Mencione::create([
            'id'=>2,
            'mencion'=>'Sistemas de computación',
            'mencionAbrev'=>'Sistemas'
        ]);
        Mencione::create([
            'id'=>3,
            'mencion'=>'Telecomunicaciones',
            'mencionAbrev'=>'Telecomunicaciones'
        ]);
    }
}
