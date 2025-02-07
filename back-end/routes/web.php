<?php

use Illuminate\Support\Facades\Route;

Route::get('/generar-api-key', [\App\Http\Controllers\ApiKeyController::class, 'generate']);
