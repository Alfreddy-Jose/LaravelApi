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
                Permission::firstOrCreate(['name' => 'usuario.crear']);
                Permission::firstOrCreate(['name' => 'usuario.editar']);
                Permission::firstOrCreate(['name' => 'usuario.eliminar']);
                Permission::firstOrCreate(['name' => 'usuario.ver']);
                // Permisos rol
                Permission::firstOrCreate(['name' => 'rol.crear']);
                Permission::firstOrCreate(['name' => 'rol.editar']);
                Permission::firstOrCreate(['name' => 'rol.eliminar']);
                Permission::firstOrCreate(['name' => 'rol.ver']);
                // Permisos pnf
                Permission::firstOrCreate(['name' => 'pnf.crear']);
                Permission::firstOrCreate(['name' => 'pnf.editar']);
                Permission::firstOrCreate(['name' => 'pnf.eliminar']);
                Permission::firstOrCreate(['name' => 'pnf.ver']);
                Permission::firstOrCreate(['name' => 'pnf.pdf']);
                // Permisos sede
                Permission::firstOrCreate(['name' => 'sede.crear']);
                Permission::firstOrCreate(['name' => 'sede.editar']);
                Permission::firstOrCreate(['name' => 'sede.eliminar']);
                Permission::firstOrCreate(['name' => 'sede.ver']);
                Permission::firstOrCreate(['name' => 'sede.pdf']);
                //Permisos lapso
                Permission::firstOrCreate(['name' => 'lapso.crear']);
                Permission::firstOrCreate(['name' => 'lapso.editar']);
                Permission::firstOrCreate(['name' => 'lapso.eliminar']);
                Permission::firstOrCreate(['name' => 'lapso.ver']);
                Permission::firstOrCreate(['name' => 'lapso.pdf']);
                Permission::firstOrCreate(['name' => 'lapso.cambiar estado']);
                //Permisos trayecto
                Permission::firstOrCreate(['name' => 'trayecto.crear']);
                Permission::firstOrCreate(['name' => 'trayecto.editar']);
                Permission::firstOrCreate(['name' => 'trayecto.eliminar']);
                Permission::firstOrCreate(['name' => 'trayecto.ver']);
                Permission::firstOrCreate(['name' => 'trayecto.pdf']);
                //Permisos unidad curricular
                Permission::firstOrCreate(['name' => 'unidad Curricular.crear']);
                Permission::firstOrCreate(['name' => 'unidad Curricular.editar']);
                Permission::firstOrCreate(['name' => 'unidad Curricular.eliminar']);
                Permission::firstOrCreate(['name' => 'unidad Curricular.ver']);
                Permission::firstOrCreate(['name' => 'unidad.pdf']);
                // Permisos tipo de matricula
                Permission::firstOrCreate(['name' => 'Tipo Matricula.crear']);
                Permission::firstOrCreate(['name' => 'Tipo Matricula.editar']);
                Permission::firstOrCreate(['name' => 'Tipo Matricula.eliminar']);
                Permission::firstOrCreate(['name' => 'Tipo Matricula.ver']);
                Permission::firstOrCreate(['name' => 'Tipo Matricula.pdf']);
                // Permisos seccion
                Permission::firstOrCreate(['name' => 'seccion.crear']);
                Permission::firstOrCreate(['name' => 'seccion.editar']);
                Permission::firstOrCreate(['name' => 'seccion.eliminar']);
                Permission::firstOrCreate(['name' => 'seccion.ver']);
                Permission::firstOrCreate(['name' => 'seccion.pdf']);
                // Permisos espacios
                Permission::firstOrCreate(['name' => 'Gestionar Espacios']);
                // Permisos aulas
                Permission::firstOrCreate(['name' => 'aula.crear']);
                Permission::firstOrCreate(['name' => 'aula.editar']);
                Permission::firstOrCreate(['name' => 'aula.eliminar']);
                Permission::firstOrCreate(['name' => 'aula.ver']);
                Permission::firstOrCreate(['name' => 'aula.pdf']);
                // Permisos laboratorios
                Permission::firstOrCreate(['name' => 'laboratorio.crear']);
                Permission::firstOrCreate(['name' => 'laboratorio.editar']);
                Permission::firstOrCreate(['name' => 'laboratorio.eliminar']);
                Permission::firstOrCreate(['name' => 'laboratorio.ver']);
                Permission::firstOrCreate(['name' => 'laboratorio.pdf']);
                // Permisos turno
                Permission::firstOrCreate(['name' => 'turno.crear']);
                Permission::firstOrCreate(['name' => 'turno.editar']);
                Permission::firstOrCreate(['name' => 'turno.eliminar']);
                Permission::firstOrCreate(['name' => 'turno.ver']);
                Permission::firstOrCreate(['name' => 'turno.pdf']);
                // Permisos malla de Pnf
                /*         Permission::firstOrCreate(['name' => 'malla.crear']);
        Permission::firstOrCreate(['name' => 'malla.editar']);
        Permission::firstOrCreate(['name' => 'malla.eliminar']);
        Permission::firstOrCreate(['name' => 'malla.ver']); */
                // Permisos gestionar Persona
                Permission::firstOrCreate(['name' => 'gestionar persona']);
                // Permisos personas
                Permission::firstOrCreate(['name' => 'persona.crear']);
                Permission::firstOrCreate(['name' => 'persona.editar']);
                Permission::firstOrCreate(['name' => 'persona.eliminar']);
                Permission::firstOrCreate(['name' => 'persona.ver']);
                Permission::firstOrCreate(['name' => 'persona.pdf']);
                // Permisos docentes
                Permission::firstOrCreate(['name' => 'docente.crear']);
                Permission::firstOrCreate(['name' => 'docente.editar']);
                Permission::firstOrCreate(['name' => 'docente.eliminar']);
                Permission::firstOrCreate(['name' => 'docente.ver']);
                Permission::firstOrCreate(['name' => 'docente.pdf']);
                // Permisos coordinador municipales
                Permission::firstOrCreate(['name' => 'coordinador.crear']);
                Permission::firstOrCreate(['name' => 'coordinador.editar']);
                Permission::firstOrCreate(['name' => 'coordinador.eliminar']);
                Permission::firstOrCreate(['name' => 'coordinador.ver']);
                Permission::firstOrCreate(['name' => 'coordinador.pdf']);
                // Permisos asistente
                /*         Permission::firstOrCreate(['name' => 'asistente.crear']);
        Permission::firstOrCreate(['name' => 'asistente.editar']);
        Permission::firstOrCreate(['name' => 'asistente.eliminar']);
        Permission::firstOrCreate(['name' => 'asistente.ver']); */
                // Permisos vocero
                Permission::firstOrCreate(['name' => 'vocero.crear']);
                Permission::firstOrCreate(['name' => 'vocero.editar']);
                Permission::firstOrCreate(['name' => 'vocero.eliminar']);
                Permission::firstOrCreate(['name' => 'vocero.ver']);
                Permission::firstOrCreate(['name' => 'vocero.pdf']);
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
                $asistenteRole->givePermissionTo(['pnf.ver', 'sede.ver', 'lapso.ver']);
        }
}
