<?php

namespace Database\Seeders;

use App\Models\Titulo;
use Illuminate\Database\Seeder;

class TituloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Titulo::create([
            'id'=>1,
            'titulo'=>'Ingeniero',
            'tituloAbrev'=>'Ing.',
        ]);
        Titulo::create([
            'id'=>2,
            'titulo'=>'Licenciado',
            'tituloAbrev'=>'Lic.',
        ]);
        Titulo::create([
            'id'=>3,
            'titulo'=>'Auxiliar',
            'tituloAbrev'=>'Aux.',
        ]);
        Titulo::create([
            'id'=>4,
            'titulo'=>'Ninguno',
            'tituloAbrev'=>'',
        ]);
        Titulo::create([
            'id'=>5,
            'titulo'=>'Por definir',
            'tituloAbrev'=>'Por',
        ]);
    }
}
