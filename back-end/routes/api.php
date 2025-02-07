<?php

use App\Http\Middleware\apiKeyMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(apiKeyMiddleware::class)
    ->prefix('v1')
    ->group(function () {
        Route::get('/grados-secciones', [App\Http\Controllers\Api\V1\GradeController::class, 'getGradesAndSections']);
        Route::get('/consultar-alumnos/{id_grado?}/{id_seccion?}', [App\Http\Controllers\Api\V1\StudentController::class, 'index']);
        Route::post('/crear-alumno', [App\Http\Controllers\Api\V1\StudentController::class, 'store']);
        Route::put('/actualizar-alumno/{id}', [App\Http\Controllers\Api\V1\StudentController::class, 'update']);
    });
