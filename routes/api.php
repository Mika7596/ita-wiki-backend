<?php

declare (strict_types= 1);

use App\Http\Controllers\RoleController;
use App\Http\Controllers\ResourceController;
use Illuminate\Support\Facades\Route;

Route::get('/resources/lists', function(){
    return "/resources";
});

Route::post('/resource', [ResourceController::class, 'create'])->name('resource.create');
Route::get('/users/user-signedin-as', [RoleController::class, 'getRoleByGithubId']);
