<?php

use App\Http\Controllers\ResourceController;
use App\Http\Controllers\ResourceEditController;
use Illuminate\Support\Facades\Route;

Route::get('/resources/lists', [ResourceController::class, 'get']);
Route::put('/resources/{resource}', [ResourceEditController::class, 'update']);
/*Route::post('/resources', [ResourceController::class, 'store']);
Route::delete('/resources/{resource}', [ResourceController::class, 'destroy']);*/