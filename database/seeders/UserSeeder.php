<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id'=>'1',
            'name'=>'Franz Martin',
            'apPaterno'=>'Chuquichambi',
            'apMaterno'=>'Ramos',
            'numeroCI'=>6744782,
            'registroUniv'=>1659611,
            'nivele_id'=>1,
            'estado_id'=>2,
            'titulo_id'=>4,
            'email'=>'fmart777.ingetn@gmail.com',
            'password'=> bcrypt('6744782')
        ])->assignRole('Administrador');
        User::create([
            'id'=>'1',
            'name'=>'Administrador',
            'apPaterno'=>'Administrador',
            'apMaterno'=>'Administrador',
            'numeroCI'=>26041971,
            'registroUniv'=>26041971,
            'nivele_id'=>1,
            'estado_id'=>2,
            'titulo_id'=>4,
            'email'=>'admingetn@gmail.com',
            'password'=> bcrypt('26041971')
        ])->assignRole('Administrador');
    }
}
