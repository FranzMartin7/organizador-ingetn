<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name'=>'Administrador']);
        $role2 = Role::create(['name'=>'Docente']);
        $role3 = Role::create(['name'=>'Auxiliar']);
        $role4 = Role::create(['name'=>'Estudiante']);

        Permission::create(['name'=>'admin.eventosVista'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.eventos'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.horarios'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.asignaturas'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.programas'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.materias'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.registros'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.users'])->syncRoles([$role1]);
        Permission::create(['name'=>'docente.eventosVista'])->syncRoles([$role2]);
        Permission::create(['name'=>'docente.eventosEdicion'])->syncRoles([$role2]);
        Permission::create(['name'=>'auxiliar.eventosVista'])->syncRoles([$role3]);
        Permission::create(['name'=>'auxiliar.eventosEdicion'])->syncRoles([$role3]);
        Permission::create(['name'=>'estudiante.eventosVista'])->syncRoles([$role4]);
        Permission::create(['name'=>'docente.reporte'])->syncRoles([$role2]);
        Permission::create(['name'=>'admin.horariosVista'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.horariosExportar'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.grupos'])->syncRoles([$role1]);
        Permission::create(['name'=>'auxiliar.reporte'])->syncRoles([$role3]);
        Permission::create(['name'=>'estudiante.horario'])->syncRoles([$role4]);
        Permission::create(['name'=>'estudiante.registro'])->syncRoles([$role4]);
    }
}
