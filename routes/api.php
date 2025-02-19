<?php

use App\Http\Controllers\ResourceController;
use Illuminate\Support\Facades\Route;

Route::get('/resources/lists', [ResourceController::class, 'get']);
/*Route::post('/resources', [ResourceController::class, 'store']);
Route::delete('/resources/{resource}', [ResourceController::class, 'destroy']);*/