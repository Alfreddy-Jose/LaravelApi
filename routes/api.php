<?php

use App\Http\Controllers\Api\Auth\AutenticacionController;
use App\Http\Controllers\Api\EspacioController;
use App\Http\Controllers\Api\DocenteController;
use App\Http\Controllers\Api\LapsoAcademicoController;
use App\Http\Controllers\Api\MatriculaController;
use App\Http\Controllers\Api\PersonaController;
use App\Http\Controllers\Api\PnfController;
use App\Http\Controllers\Api\RolesController;
use App\Http\Controllers\Api\SeccionController;
use App\Http\Controllers\Api\SedeController;
use App\Http\Controllers\Api\TipoPersonaController;
use App\Http\Controllers\Api\TrayectoController;
use App\Http\Controllers\Api\TurnoController;
use App\Http\Controllers\Api\UnidadCurricularController;
use App\Http\Controllers\Api\UniversidadController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\HorarioSelectsController;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Ruta del login
Route::post('/login', [AutenticacionController::class, 'login']);
Route::get('/secciones/pdf', [SeccionController::class, 'pdf']); // <-- Ruta para generar PDF

// Rutas protegidas por middleware de Sanctum
Route::middleware('auth:sanctum')->group(function () {

    // Rutas de Usuarios y Autenticación
    Route::get('/user', [AutenticacionController::class, 'user']);
    Route::get('/usuarios', [UserController::class, 'index']);
    Route::post('/usuarios', [UserController::class, 'store']);
    Route::put('/usuarios/{usuario}', [UserController::class, 'update']);
    Route::put('/password/{usuario}', [UserController::class, 'updatePassword']);
    Route::get('/usuario/{usuario}', [UserController::class, 'show']);
    Route::delete('/usuario/{usuario}', [UserController::class, 'destroy']);
    Route::get('/get_roles', [UserController::class, 'getRoles']);
    Route::post('/logout', [AutenticacionController::class, 'logout']);

    // Rutas de PNF
    Route::get('/pnf', [PnfController::class, 'index']);
    Route::get('/pnf/espacios', [PnfController::class, 'getEspacios']);
    Route::get('/pnf/{pnf}/espacios', [PnfController::class, 'getEspaciosPnf']);
    Route::post('/pnf', [PnfController::class, 'store']);
    Route::get('/pnf/{pnf}', [PnfController::class, 'show']);
    Route::put('/pnf/{pnf}', [PnfController::class, 'update']);
    Route::delete('/pnf/{pnf}', [PnfController::class, 'destroy']);

    // Rutas de Universidades
    Route::get('/universidades', [UniversidadController::class, 'index']);
    Route::post('/universidad', [UniversidadController::class, 'store']);
    Route::get('/universidad', [UniversidadController::class, 'show']);
    Route::put('/universidad/{universidad}', [UniversidadController::class, 'update']);
    //Route::delete('/universidad/{universidad}', [UniversidadController::class, 'destroy']);

    // Rutas de Sedes
    Route::get('/sedes', [SedeController::class, 'index']);
    Route::post('/sede', [SedeController::class, 'store']);
    Route::post('/sedes/{sede}/asignarPnfs', [SedeController::class, 'asignarPnfs']);
    Route::get('/sede/getPnf', [SedeController::class, 'getPnf']);
    Route::get('/sedes/{sede}/pnf', [SedeController::class, 'getPnfSede']);
    Route::get('/sede/{sede}', [SedeController::class, 'show']);
    Route::put('/sede/{sede}', [SedeController::class, 'update']);
    Route::delete('/sede/{sede}', [SedeController::class, 'destroy']);

    // Rutas de Secciones
    Route::get('/secciones', [SeccionController::class, 'index']);
    Route::post('/secciones', [SeccionController::class, 'store']);
    Route::get('/seccion/getDataSelect', [SeccionController::class, 'getDataSelect']);
    Route::get('/seccion/{seccion}', [SeccionController::class, 'show']);
    Route::put('/seccion/{seccion}', [SeccionController::class, 'update']);
    Route::delete('/seccion/{seccion}', [SeccionController::class, 'destroy']);

    // Rutas de Tipo de Matriculas
    Route::get('/matriculas', [MatriculaController::class, 'index']);
    Route::get('/matricula/{matricula}', [MatriculaController::class, 'show']);
    Route::post('/matricula', [MatriculaController::class, 'store']);
    Route::put('/matricula/{matricula}', [MatriculaController::class, 'update']);
    Route::delete('/matricula/{matricula}', [MatriculaController::class, 'destroy']);

    // Rutas de los Roles
    Route::get('/roles', [RolesController::class, 'getRolesWithPermissions']);
    Route::get('/rol/{rol}/edit', [RolesController::class, 'show']);
    Route::post('/roles', [RolesController::class, 'store']);
    Route::put('/rol/{rol}', [RolesController::class, 'update']);
    Route::delete('/rol/{rol}', [RolesController::class, 'destroy']);

    // Rutas de los Lapso
    Route::get('/lapsos', [LapsoAcademicoController::class, 'index']);
    Route::post('/lapsos', [LapsoAcademicoController::class, 'store']);
    Route::get('/lapso/{lapso_academico}', [LapsoAcademicoController::class, 'show']);
    Route::put('/lapso/{lapso_academico}', [LapsoAcademicoController::class, 'update']);
    Route::get('/get_tipoLapsos', [LapsoAcademicoController::class, 'get_tipoLapsos']);
    Route::delete('/lapso/{lapso_academico}', [LapsoAcademicoController::class, 'destroy']);

    // Rutas de Personas
    Route::get('/personas', [PersonaController::class, 'index']);
    Route::get('/persona/get_pnf', [PersonaController::class, 'getPnf']);
    Route::post('/persona', [PersonaController::class, 'store']);
    Route::get('/persona/{persona}', [PersonaController::class, 'show']);
    Route::put('/persona/{persona}', [PersonaController::class, 'update']);
    Route::delete('/persona/{persona}', [PersonaController::class, 'destroy']);

    // Rutas de Docentes
    Route::get('/docente/getDataSelect', [DocenteController::class, 'getDataSelect']);
    Route::post('/docente', [DocenteController::class, 'store']);

    // Rutas de tipos de personas
    Route::get('/tipo_persona', [TipoPersonaController::class, 'getFormData']);
    Route::get('/tipo_personas/list', [TipoPersonaController::class, 'index']);

    // Rutas de Espacios
    Route::get('/aula', [EspacioController::class, 'indexAula']);
    Route::get('/espacio/getSedes', [EspacioController::class, 'getSedes']);
    Route::post('/aula', [EspacioController::class, 'storeAula']);
    Route::get('/aula/{espacio}', [EspacioController::class, 'showAula']);
    Route::put('/aula/{espacio}', [EspacioController::class, 'updateAula']);
    Route::delete('/aula/{espacio}', [EspacioController::class, 'destroyAula']);
    Route::get('/laboratorios', [EspacioController::class, 'indexLaboratorio']);
    Route::post('/laboratorio', [EspacioController::class, 'storeLaboratorio']);
    Route::post('/espacios/{pnf}/asignarEspacios', [EspacioController::class, 'asignarEspacios']); // <- ruta para asignar espacios a un PNF
    Route::get('/laboratorio/{espacio}', [EspacioController::class, 'showLaboratorio']);
    Route::put('/laboratorio/{espacio}', [EspacioController::class, 'updateLaboratorio']);
    Route::delete('/laboratorio/{espacio}', [EspacioController::class, 'destroyLaboratorio']);

    // Rutas de Turnos
    Route::get('/turnos', [TurnoController::class, 'index']);
    Route::post('/turnos', [TurnoController::class, 'store']);
    Route::delete('/turno/{turno}', [TurnoController::class, 'destroy']);

    // Rutas de Unidad Curricular
    Route::get('/unidad_curricular', [UnidadCurricularController::class, 'index']);
    Route::get('/get_trimestres', [UnidadCurricularController::class, 'get_trimestres']);
    Route::post('/unidad_curricular', [UnidadCurricularController::class, 'store']);
    Route::get('/unidad_curricular/{unidad_curricular}', [UnidadCurricularController::class, 'show']);
    Route::put('/unidad_curricular/{unidad_curricular}', [UnidadCurricularController::class, 'update']);
    Route::delete('/unidad_curricular/{unidad_curricular}', [UnidadCurricularController::class, 'destroy']);

    // Rutas de Trayectos
    Route::get('/trayectos', [TrayectoController::class, 'index']);
    Route::post('/trayectos', [TrayectoController::class, 'store']);
    Route::delete('/trayecto/{trayecto}', [TrayectoController::class, 'destroy']);

    // Rutas para selects de Horarios
    Route::get('/horarios/sedes', [HorarioSelectsController::class, 'getSedes']);
    Route::get('/horarios/sedes/{sede}/pnfs', [HorarioSelectsController::class, 'getPnfs']);
    Route::get('/horarios/trayectos', [HorarioSelectsController::class, 'getTrayectos']);
    Route::get('/horarios/trayectos/{trayecto}/trimestres', [HorarioSelectsController::class, 'getTrimestres']);
    Route::get('/horarios/trimestres/{trimestres}/unidadesCurriculares', [HorarioSelectsController::class, 'getUnidadesCurriculares']);
    Route::get('/horarios/unidadesCurriculares/{unidadesCurriculares}/docentes', [HorarioSelectsController::class, 'getdocentes']);
    Route::get('/horarios/sede/{sede}/espacios', [HorarioSelectsController::class, 'getEspacios']);
});
