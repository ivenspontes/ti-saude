<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientRequest;
use App\Http\Resources\PatientCollection;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return PatientCollection
     */
    public function index()
    {
        return new PatientCollection(Patient::simplePaginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PatientRequest $request
     * @return JsonResponse
     */
    public function store(PatientRequest $request)
    {
        $patient = Patient::create($request->validated());

        $healthInsurances = collect($request->health_insurances)->mapWithKeys(function ($healthInsurance) {
            return [$healthInsurance['id'] => ['contract_number' => $healthInsurance['contract_number']]];
        })->toArray();

        $patient->healthInsurances()->sync($healthInsurances);

        return (new PatientResource($patient))
            ->additional(['message' => 'Patient created successfully'])
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Patient $patient
     * @return PatientResource
     */
    public function show(Patient $patient)
    {
        return new PatientResource($patient);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PatientRequest $request
     * @param Patient $patient
     * @return PatientResource
     */
    public function update(PatientRequest $request, Patient $patient)
    {
        $patient->update($request->validated());

        $healthInsurances = collect($request->health_insurances)->mapWithKeys(function ($healthInsurance) {
            return [$healthInsurance['id'] => ['contract_number' => $healthInsurance['contract_number']]];
        })->toArray();

        $patient->healthInsurances()->sync($healthInsurances);

        return (new PatientResource($patient))
            ->additional(['message' => 'Patient updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Patient $patient
     * @return JsonResponse
     */
    public function destroy(Patient $patient)
    {
        try {
            $patient->delete();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Patient could not be deleted',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(['message' => 'Patient deleted successfully']);
    }
}
