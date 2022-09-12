<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorRequest;
use App\Http\Resources\DoctorCollection;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return DoctorCollection
     */
    public function index()
    {
        return new DoctorCollection(Doctor::simplePaginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DoctorRequest $request
     * @return JsonResponse
     */
    public function store(DoctorRequest $request)
    {
        Doctor::create($request->validated());

        return response()->json(['message' => 'Doctor created successfully'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Doctor $doctor
     * @return DoctorResource
     */
    public function show(Doctor $doctor)
    {
        return new DoctorResource($doctor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DoctorRequest $request
     * @param Doctor $doctor
     * @return JsonResponse
     */
    public function update(DoctorRequest $request, Doctor $doctor)
    {
        $doctor->update($request->validated());

        return response()->json(['message' => 'Doctor updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Doctor $doctor
     * @return JsonResponse
     */
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return response()->json(['message' => 'Doctor deleted successfully']);
    }
}
