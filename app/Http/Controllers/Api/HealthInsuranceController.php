<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\HealthInsuranceRequest;
use App\Http\Resources\HealthInsuranceCollection;
use App\Http\Resources\HealthInsuranceResource;
use App\Models\HealthInsurance;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HealthInsuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return HealthInsuranceCollection
     */
    public function index()
    {
        return new HealthInsuranceCollection(HealthInsurance::simplePaginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param HealthInsuranceRequest $request
     * @return JsonResponse
     */
    public function store(HealthInsuranceRequest $request)
    {
        $healthInsurance = HealthInsurance::create($request->all());
        return response()->json($healthInsurance->toArray(), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param HealthInsurance $healthInsurance
     * @return HealthInsuranceResource
     */
    public function show(HealthInsurance $healthInsurance)
    {
        return new HealthInsuranceResource($healthInsurance);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param HealthInsuranceRequest $request
     * @param HealthInsurance $healthInsurance
     * @return JsonResponse
     */
    public function update(HealthInsuranceRequest $request, HealthInsurance $healthInsurance)
    {
        if ($healthInsurance->update($request->all())) {
            return response()->json($healthInsurance->toArray());
        }
        return response()->json('Error updating patient', 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param HealthInsurance $healthInsurance
     * @return JsonResponse
     */
    public function destroy(HealthInsurance $healthInsurance)
    {
        if ($healthInsurance->delete()) {
            return response()->json('Patient deleted successfully', 204);
        }
        return response()->json('Error deleting patient', 500);
    }
}
