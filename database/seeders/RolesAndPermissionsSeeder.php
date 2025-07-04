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
        Permission::create(['name' => 'crear usuario']);
        Permission::create(['name' => 'editar usuario']);
        Permission::create(['name' => 'eliminar usuario']);
        Permission::create(['name' => 'ver usuario']);
        // Permisos de Roles
        Permission::create(['name' => 'crear rol']);
        Permission::create(['name' => 'editar rol']);
        Permission::create(['name' => 'eliminar rol']);
        Permission::create(['name' => 'ver rol']);
        // Permisos de Pnf
        Permission::create(['name' => 'crear pnf']);
        Permission::create(['name' => 'editar pnf']);
        Permission::create(['name' => 'eliminar pnf']);
        Permission::create(['name' => 'ver pnf']);
        // Permisos de Sede
        Permission::create(['name' => 'crear sede']);
        Permission::create(['name' => 'editar sede']);
        Permission::create(['name' => 'eliminar sede']);
        Permission::create(['name' => 'ver sede']);
        //Permisos de Lapso
        Permission::create(['name' => 'crear lapso']);
        Permission::create(['name' => 'editar lapso']);
        Permission::create(['name' => 'eliminar lapso']);
        Permission::create(['name' => 'ver lapso']);
        //Permisos de Trayecto
        Permission::create(['name' => 'crear trayecto']);
        Permission::create(['name' => 'editar trayecto']);
        Permission::create(['name' => 'eliminar trayecto']);
        Permission::create(['name' => 'ver trayecto']);
        //Permisos de unidad curricular
        Permission::create(['name' => 'crear unidad']);
        Permission::create(['name' => 'editar unidad']);
        Permission::create(['name' => 'eliminar unidad']);
        Permission::create(['name' => 'ver unidad']);
        // Permisos de Matricula
        Permission::create(['name' => 'crear matricula']);
        Permission::create(['name' => 'editar matricula']);
        Permission::create(['name' => 'eliminar matricula']);
        Permission::create(['name' => 'ver matricula']);
        // Permisos de Seccion
        Permission::create(['name' => 'crear seccion']);
        Permission::create(['name' => 'editar seccion']);
        Permission::create(['name' => 'eliminar seccion']);
        Permission::create(['name' => 'ver seccion']);
        // Permisos de De Espacios
        Permission::create(['name' => 'Gestionar Espacios']);
        // Permisos de Aulas
        Permission::create(['name' => 'crear aula']);
        Permission::create(['name' => 'editar aula']);
        Permission::create(['name' => 'eliminar aula']);
        Permission::create(['name' => 'ver aula']);
        // Permisos de Laboratorios
        Permission::create(['name' => 'crear laboratorio']);
        Permission::create(['name' => 'editar laboratorio']);
        Permission::create(['name' => 'eliminar laboratorio']);
        Permission::create(['name' => 'ver laboratorio']);
        // Permisos de Turnos
        Permission::create(['name' => 'crear turno']);
        Permission::create(['name' => 'editar turno']);
        Permission::create(['name' => 'eliminar turno']);
        Permission::create(['name' => 'ver turno']);
        // Permisos de Malla de Pnf
        Permission::create(['name' => 'crear malla']);
        Permission::create(['name' => 'editar malla']);
        Permission::create(['name' => 'eliminar malla']);
        Permission::create(['name' => 'ver malla']);
        // Permisos para gestionar Persona
        Permission::create(['name' => 'gestionar persona']);
        // Permisos de Personas
        Permission::create(['name' => 'crear persona']);
        Permission::create(['name' => 'editar persona']);
        Permission::create(['name' => 'eliminar persona']);
        Permission::create(['name' => 'ver persona']);
        // Permisos de Docentes
        Permission::create(['name' => 'crear docente']);
        Permission::create(['name' => 'editar docente']);
        Permission::create(['name' => 'eliminar docente']);
        Permission::create(['name' => 'ver docente']);
        // Permisos de Coordinadores municipales
        Permission::create(['name' => 'crear coordinador']);
        Permission::create(['name' => 'editar coordinador']);
        Permission::create(['name' => 'eliminar coordinador']);
        Permission::create(['name' => 'ver coordinador']);
        // Permisos de Asistentes
        Permission::create(['name' => 'crear asistente']);
        Permission::create(['name' => 'editar asistente']);
        Permission::create(['name' => 'eliminar asistente']);
        Permission::create(['name' => 'ver asistente']);
        // Permisos de Voceros
        Permission::create(['name' => 'crear vocero']);
        Permission::create(['name' => 'editar vocero']);
        Permission::create(['name' => 'eliminar vocero']);
        Permission::create(['name' => 'ver vocero']);
        // Permisos para ver Estadisticas
/*         Permission::create(['name' => 'ver estadisticas']);
        Permission::create(['name' => 'ver general']);
        Permission::create(['name' => 'ver instrucciones']); */

        // Crear Roles y asignar permisos

        //  Crear rol de  Administrador
        $adminRole = Role::create(['name' => 'ADMINISTRADOR']);
        // Asignar todos los permisos al rol de Administrador
        $adminRole->givePermissionTo(Permission::all());

        // Rol de Asistente
        $asistenteRole = Role::create(['name' => 'ASISTENTE']);
        // Asignar permisos al rol de Asistente
        $asistenteRole->givePermissionTo(['ver pnf', 'ver sede', 'ver lapso']);
    }
}
