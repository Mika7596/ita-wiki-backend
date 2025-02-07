<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\GitHubAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth/github')->group(function () {
    Route::get('redirect', [GitHubAuthController::class, 'redirectToGitHub'])->name('github.redirect');
    Route::get('callback', [GitHubAuthController::class, 'handleGitHubCallback'])->name('github.callback');
});
