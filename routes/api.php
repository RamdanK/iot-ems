<?php

use App\Http\Controllers\Api\UpdateDeviceStatusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('v1')->as('v1.')->group(function () {
        Route::prefix('devices')->as('devices.')->group(function () {
            Route::post('/{device}/actions/update-status', UpdateDeviceStatusController::class)->name('update-device-status');
        });
    });
});
