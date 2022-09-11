<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SpecialtyRequest;
use App\Http\Resources\SpecialtyCollection;
use App\Http\Resources\SpecialtyResource;
use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return SpecialtyResource
     */
    public function index()
    {
        return new SpecialtyCollection(Specialty::simplePaginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SpecialtyRequest $request)
    {
        Specialty::create($request->validated());

        return response()->json('Specialty created successfully', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Specialty  $specialty
     * @return SpecialtyResource
     */
    public function show(Specialty $specialty)
    {
        return new SpecialtyResource($specialty);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Specialty  $specialty
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SpecialtyRequest $request, Specialty $specialty)
    {
        $specialty->update($request->validated());

        return response()->json('Specialty updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Specialty  $specialty
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Specialty $specialty)
    {
        $specialty->delete();

        return response()->json('Specialty deleted successfully');
    }
}
