<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientRequest;
use App\Http\Resources\PatientCollection;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use Illuminate\Http\Request;

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
     * @param  PatientRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PatientRequest $request)
    {
        $patient = Patient::create($request->all());
        return response()->json($patient->toArray(), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $patient
     * @return PatientResource
     */
    public function show(Patient $patient)
    {
        return new PatientResource($patient);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PatientRequest $request
     * @param  Patient  $patient
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PatientRequest $request, Patient $patient)
    {
        if ($patient->update($request->all())) {
            return response()->json($patient->toArray());
        }
        return response()->json('Error updating patient', 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Patient  $patient
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Patient $patient)
    {
        if ($patient->delete()) {
            return response()->json('Patient deleted successfully', 204);
        }
        return response()->json('Error deleting patient', 500);
    }
}
