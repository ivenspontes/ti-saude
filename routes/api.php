<?php

use App\Http\Controllers\Api\HealthInsuranceController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\AuthController;
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

require __DIR__.'/auth.php';

Route::middleware('auth:api')->group(function () {
    Route::apiResources([
        'patients' => PatientController::class,
        'health-insurances' => HealthInsuranceController::class
    ]);
});
