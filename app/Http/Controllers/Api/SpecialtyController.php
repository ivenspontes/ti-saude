<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SpecialtyRequest;
use App\Http\Resources\SpecialtyCollection;
use App\Http\Resources\SpecialtyResource;
use App\Models\Specialty;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SpecialtyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return SpecialtyCollection
     */
    public function index(): SpecialtyCollection
    {
        return new SpecialtyCollection(Specialty::simplePaginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SpecialtyRequest $request
     * @return JsonResponse
     */
    public function store(SpecialtyRequest $request): JsonResponse
    {
        $specialty = Specialty::create($request->validated());

        return (new SpecialtyResource($specialty))
            ->additional(['message' => 'Specialty created successfully'])
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Specialty $specialty
     * @return SpecialtyResource
     */
    public function show(Specialty $specialty): SpecialtyResource
    {
        return new SpecialtyResource($specialty);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SpecialtyRequest $request
     * @param Specialty $specialty
     * @return SpecialtyResource
     */
    public function update(SpecialtyRequest $request, Specialty $specialty): SpecialtyResource
    {
        $specialty->update($request->validated());

        return (new SpecialtyResource($specialty))
            ->additional(['message' => 'Specialty updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Specialty $specialty
     * @return JsonResponse
     */
    public function destroy(Specialty $specialty): JsonResponse
    {
        $specialty->delete();

        return response()->json('Specialty deleted successfully');
    }
}
