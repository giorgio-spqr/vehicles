<?php

use App\Http\Controllers\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('vehicles')->group(function () {
    Route::get('/', [VehicleController::class, 'index']);
    Route::get('/{vin}', [VehicleController::class, 'show']);
    Route::post('/', [VehicleController::class, 'store']);
    Route::patch('/{vin}', [VehicleController::class, 'update']);
    Route::delete('/{vin}', [VehicleController::class, 'destroy']);
});
