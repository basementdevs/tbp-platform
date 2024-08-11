<?php

use App\Http\Controllers\Api\V1\AuthenticatedUserController;
use App\Http\Controllers\Api\V1\OAuthController;
use App\Http\Controllers\Api\V1\OccupationsController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/occupations', [OccupationsController::class, 'getOccupationsList']);
    Route::post('/authenticate/{provider}', [OAuthController::class, 'authenticateWithOAuth']);

    Route::middleware(['auth:sanctum', 'throttle:30,1'])->group(function () {
        Route::put('/me/update-settings', [AuthenticatedUserController::class, 'putSettings'])
            ->name('auth.update-settings');
    });
});



