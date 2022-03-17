<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call(AcontecimientoSeeder::class);
        $this->call(ActividadeSeeder::class);
        $this->call(AreaSeeder::class);
        $this->call(DocenciaSeeder::class);
        $this->call(EstadoSeeder::class);
        $this->call(NiveleSeeder::class);
        $this->call(PeriodoSeeder::class);
        $this->call(SemestreSeeder::class);
        $this->call(AulaSeeder::class);
        $this->call(MencioneSeeder::class);
        $this->call(TituloSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
      /*   $this->call(UserSeeder::class); */
    }
}
