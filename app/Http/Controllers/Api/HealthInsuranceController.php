<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\HealthInsuranceRequest;
use App\Http\Resources\HealthInsuranceCollection;
use App\Http\Resources\HealthInsuranceResource;
use App\Models\HealthInsurance;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class HealthInsuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return HealthInsuranceCollection
     */
    public function index(): HealthInsuranceCollection
    {
        return new HealthInsuranceCollection(HealthInsurance::simplePaginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param HealthInsuranceRequest $request
     * @return JsonResponse
     */
    public function store(HealthInsuranceRequest $request): JsonResponse
    {
        $healthInsurance = HealthInsurance::create($request->validated());

        return (new HealthInsuranceResource($healthInsurance))
            ->additional(['message' => 'Health Insurance created successfully'])
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param HealthInsurance $healthInsurance
     * @return HealthInsuranceResource
     */
    public function show(HealthInsurance $healthInsurance): HealthInsuranceResource
    {
        return new HealthInsuranceResource($healthInsurance);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param HealthInsuranceRequest $request
     * @param HealthInsurance $healthInsurance
     * @return HealthInsuranceResource
     */
    public function update(HealthInsuranceRequest $request, HealthInsurance $healthInsurance): HealthInsuranceResource
    {
        $healthInsurance->update($request->validated());

        return (new HealthInsuranceResource($healthInsurance))
            ->additional(['message' => 'Health Insurance updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param HealthInsurance $healthInsurance
     * @return JsonResponse
     */
    public function destroy(HealthInsurance $healthInsurance): JsonResponse
    {
        try {
            $healthInsurance->delete();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Health Insurance could not be deleted',
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json(['message' => 'Health Insurance deleted successfully']);
    }
}
