<?php

declare (strict_types= 1);

use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\ResourceEditController;
use Illuminate\Support\Facades\Route;


Route::post('/resources', [ResourceController::class, 'store'])->name('resources.store');

Route::get('/resources', [ResourceController::class, 'index'])->name('resources');

Route::get('/users/user-signedin-as', [RoleController::class, 'getRoleByGithubId']);

Route::put('/resources/{resource}', [ResourceEditController::class, 'update'])->name('resources.update');

Route::get('/bookmarks/{github_id}', [BookmarkController::class,'studentBookmarksGetter'])->name('bookmarks'); // retrieves bookmarks of a given student

Route::post('/bookmarks', [BookmarkController::class,'studentBookmarkCreate'])->name('bookmark.create');

Route::delete('/bookmarks', [BookmarkController::class,'studentBookmarkDelete'])->name('bookmark.delete');