<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear Permisos

        // Permisos de Usuario
        Permission::firstOrCreate(['name' => 'crear usuario']);
        Permission::firstOrCreate(['name' => 'editar usuario']);
        Permission::firstOrCreate(['name' => 'eliminar usuario']);
        Permission::firstOrCreate(['name' => 'ver usuario']);
        // Permisos rol
        Permission::firstOrCreate(['name' => 'crear rol']);
        Permission::firstOrCreate(['name' => 'editar rol']);
        Permission::firstOrCreate(['name' => 'eliminar rol']);
        Permission::firstOrCreate(['name' => 'ver rol']);
        // Permisos pnf
        Permission::firstOrCreate(['name' => 'crear pnf']);
        Permission::firstOrCreate(['name' => 'editar pnf']);
        Permission::firstOrCreate(['name' => 'eliminar pnf']);
        Permission::firstOrCreate(['name' => 'ver pnf']);
        // Permisos sede
        Permission::firstOrCreate(['name' => 'crear sede']);
        Permission::firstOrCreate(['name' => 'editar sede']);
        Permission::firstOrCreate(['name' => 'eliminar sede']);
        Permission::firstOrCreate(['name' => 'ver sede']);
        //Permisos lapso
        Permission::firstOrCreate(['name' => 'crear lapso']);
        Permission::firstOrCreate(['name' => 'editar lapso']);
        Permission::firstOrCreate(['name' => 'eliminar lapso']);
        Permission::firstOrCreate(['name' => 'ver lapso']);
        //Permisos trayecto
        Permission::firstOrCreate(['name' => 'crear trayecto']);
        Permission::firstOrCreate(['name' => 'editar trayecto']);
        Permission::firstOrCreate(['name' => 'eliminar trayecto']);
        Permission::firstOrCreate(['name' => 'ver trayecto']);
        //Permisos unidad curricular
        Permission::firstOrCreate(['name' => 'crear unidad']);
        Permission::firstOrCreate(['name' => 'editar unidad']);
        Permission::firstOrCreate(['name' => 'eliminar unidad']);
        Permission::firstOrCreate(['name' => 'ver unidad']);
        // Permisos tipo de matricula
        Permission::firstOrCreate(['name' => 'crear matricula']);
        Permission::firstOrCreate(['name' => 'editar matricula']);
        Permission::firstOrCreate(['name' => 'eliminar matricula']);
        Permission::firstOrCreate(['name' => 'ver matricula']);
        // Permisos seccion
        Permission::firstOrCreate(['name' => 'crear seccion']);
        Permission::firstOrCreate(['name' => 'editar seccion']);
        Permission::firstOrCreate(['name' => 'eliminar seccion']);
        Permission::firstOrCreate(['name' => 'ver seccion']);
        // Permisos espacios
        Permission::firstOrCreate(['name' => 'Gestionar Espacios']);
        // Permisos aulas
        Permission::firstOrCreate(['name' => 'crear aula']);
        Permission::firstOrCreate(['name' => 'editar aula']);
        Permission::firstOrCreate(['name' => 'eliminar aula']);
        Permission::firstOrCreate(['name' => 'ver aula']);
        // Permisos laboratorios
        Permission::firstOrCreate(['name' => 'crear laboratorio']);
        Permission::firstOrCreate(['name' => 'editar laboratorio']);
        Permission::firstOrCreate(['name' => 'eliminar laboratorio']);
        Permission::firstOrCreate(['name' => 'ver laboratorio']);
        // Permisos turno
        Permission::firstOrCreate(['name' => 'crear turno']);
        Permission::firstOrCreate(['name' => 'editar turno']);
        Permission::firstOrCreate(['name' => 'eliminar turno']);
        Permission::firstOrCreate(['name' => 'ver turno']);
        // Permisos malla de Pnf
        Permission::firstOrCreate(['name' => 'crear malla']);
        Permission::firstOrCreate(['name' => 'editar malla']);
        Permission::firstOrCreate(['name' => 'eliminar malla']);
        Permission::firstOrCreate(['name' => 'ver malla']);
        // Permisos gestionar Persona
        Permission::firstOrCreate(['name' => 'gestionar persona']);
        // Permisos personas
        Permission::firstOrCreate(['name' => 'crear persona']);
        Permission::firstOrCreate(['name' => 'editar persona']);
        Permission::firstOrCreate(['name' => 'eliminar persona']);
        Permission::firstOrCreate(['name' => 'ver persona']);
        // Permisos docentes
        Permission::firstOrCreate(['name' => 'crear docente']);
        Permission::firstOrCreate(['name' => 'editar docente']);
        Permission::firstOrCreate(['name' => 'eliminar docente']);
        Permission::firstOrCreate(['name' => 'ver docente']);
        // Permisos coordinador municipales
        Permission::firstOrCreate(['name' => 'crear coordinador']);
        Permission::firstOrCreate(['name' => 'editar coordinador']);
        Permission::firstOrCreate(['name' => 'eliminar coordinador']);
        Permission::firstOrCreate(['name' => 'ver coordinador']);
        // Permisos asistente
        Permission::firstOrCreate(['name' => 'crear asistente']);
        Permission::firstOrCreate(['name' => 'editar asistente']);
        Permission::firstOrCreate(['name' => 'eliminar asistente']);
        Permission::firstOrCreate(['name' => 'ver asistente']);
        // Permisos vocero
        Permission::firstOrCreate(['name' => 'crear vocero']);
        Permission::firstOrCreate(['name' => 'editar vocero']);
        Permission::firstOrCreate(['name' => 'eliminar vocero']);
        Permission::firstOrCreate(['name' => 'ver vocero']);
        // Permisos para ver Estadisticas
/*         Permission::create(['name' => 'ver estadisticas']);
        Permission::create(['name' => 'ver general']);
        Permission::create(['name' => 'ver instrucciones']); */

        // Crear Roles y asignar permisos

        //  Crear rol de  Administrador
        $adminRole = Role::firstOrCreate(['name' => 'ADMINISTRADOR']);
        // Asignar todos los permisos al rol de Administrador
        $adminRole->givePermissionTo(Permission::all());

        // Rol de Asistente
        $asistenteRole = Role::firstOrCreate(['name' => 'ASISTENTE']);
        // Asignar permisos al rol de Asistente
        $asistenteRole->givePermissionTo(['ver pnf', 'ver sede', 'ver lapso']);
    }
}
