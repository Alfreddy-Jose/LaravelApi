<?php

use App\Http\Controllers\Api\MatriculaController;
use App\Http\Controllers\Api\PnfController;
use App\Http\Controllers\Api\SedeController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/usuarios', [UserController::class, 'index']);

// Rutas de PNF
Route::get('/pnf', [PnfController::class, 'index']);
Route::post('/pnf', [PnfController::class, 'store']);
Route::get('/pnf/{id}', [PnfController::class, 'show']);
Route::put('/pnf/{id}', [PnfController::class, 'update']);

// Rutas de Sedes
Route::get('/sedes', [SedeController::class, 'index']);
Route::post('/sede', [SedeController::class, 'store']);

// Rutas de Tipo de Matriculas
Route::get('/matriculas', [MatriculaController::class, 'index']);
Route::post('/matricula', [MatriculaController::class, 'store']);