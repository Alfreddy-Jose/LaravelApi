<?php

use App\Http\Controllers\Api\Auth\AutenticacionController;
use App\Http\Controllers\Api\LapsoAcademicoController;
use App\Http\Controllers\Api\MatriculaController;
use App\Http\Controllers\Api\PersonaController;
use App\Http\Controllers\Api\PnfController;
use App\Http\Controllers\Api\RolesController;
use App\Http\Controllers\Api\SedeController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Rutas de Usuarios y Autenticación
Route::post('/login', [AutenticacionController::class, 'login']);
Route::get('/usuarios', [UserController::class, 'index']);

// Rutas de PNF
Route::get('/pnf', [PnfController::class, 'index']);
Route::post('/pnf', [PnfController::class, 'store']);
Route::get('/pnf/{id}', [PnfController::class, 'show']);
Route::put('/pnf/{id}', [PnfController::class, 'update']);
Route::delete('/pnf/{id}', [PnfController::class, 'destroy']);

// Rutas de Sedes
Route::get('/sedes', [SedeController::class, 'index']);
Route::post('/sede', [SedeController::class, 'store']);
Route::get('/sede/{id}', [SedeController::class, 'show']);
Route::put('/sede/{id}', [SedeController::class, 'update']);
Route::delete('/sede/{id}', [SedeController::class, 'destroy']);

// Rutas de Tipo de Matriculas
Route::get('/matriculas', [MatriculaController::class, 'index']);
Route::get('/matricula/{id}', [MatriculaController::class, 'show']);
Route::post('/matricula', [MatriculaController::class, 'store']);
Route::put('/matricula/{id}', [MatriculaController::class, 'update']);
Route::delete('/matricula/{id}', [MatriculaController::class, 'destroy']);


// Rutas de los Roles
Route::get('/roles', [RolesController::class, 'index']);

// Rutas de los Lapso
Route::get('/lapsos', [LapsoAcademicoController::class, 'index']);
Route::post('/lapso', [LapsoAcademicoController::class, 'store']);
Route::get('/lapso/{id}', [LapsoAcademicoController::class, 'show']);
Route::put('/lapso/{id}', [LapsoAcademicoController::class, 'update']);
Route::delete('/lapso/{id}', [LapsoAcademicoController::class, 'destroy']);

// Rutas de Personas
Route::get('/personas', [PersonaController::class, 'index']);
Route::post('/persona', [PersonaController::class, 'store']);
Route::get('/persona/{id}', [PersonaController::class, 'show']);
Route::delete('/persona/{id}', [PersonaController::class, 'destroy']);