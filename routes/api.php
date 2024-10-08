<?php

use App\Http\Controllers\Api\V1\AuthenticatedUserController;
use App\Http\Controllers\Api\V1\OAuthController;
use App\Http\Controllers\Api\V1\SettingsController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/occupations', [SettingsController::class, 'getOccupationsList']);
    Route::get('/colors', [SettingsController::class, 'getColors']);
    Route::get('/effects', [SettingsController::class, 'getEffects']);

    Route::post('/authenticate/{provider}', [OAuthController::class, 'authenticateWithOAuth'])
        ->name('oauth.handle');

    Route::middleware(['auth:sanctum', 'throttle:30,1'])
        ->prefix('/me')
        ->group(function () {
            Route::get('/settings', [AuthenticatedUserController::class, 'getSettings'])
                ->name('auth.my-settings');
            Route::put('/update-settings', [AuthenticatedUserController::class, 'putSettings'])
                ->name('auth.update-settings');
            Route::patch('/update-settings', [AuthenticatedUserController::class, 'patchSettings'])
                ->name('auth.update-single-setting');
        });
});
