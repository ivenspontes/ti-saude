<?php

use App\Http\Controllers\Api\{ConsultationController,
    DoctorController,
    HealthInsuranceController,
    PatientController,
    ProcedureController,
    SpecialtyController};
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

require __DIR__ . '/auth.php';

Route::middleware('auth:api')->group(function () {
    Route::apiResources([
        'patients' => PatientController::class,
        'health-insurances' => HealthInsuranceController::class,
        'procedures' => ProcedureController::class,
        'specialties' => SpecialtyController::class,
        'doctors' => DoctorController::class,
        'consultations' => ConsultationController::class,
    ]);
});
