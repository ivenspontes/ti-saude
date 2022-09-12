<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProcedureRequest;
use App\Http\Resources\ProcedureCollection;
use App\Http\Resources\ProcedureResource;
use App\Models\Procedure;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProcedureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ProcedureCollection
     */
    public function index(): ProcedureCollection
    {
        return new ProcedureCollection(Procedure::simplePaginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProcedureRequest $request
     * @return JsonResponse
     */
    public function store(ProcedureRequest $request): JsonResponse
    {
        $procedure = Procedure::create($request->all());

        return (new ProcedureResource($procedure))
            ->additional(['message' => 'Procedure created successfully'])
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Procedure $procedure
     * @return ProcedureResource
     */
    public function show(Procedure $procedure): ProcedureResource
    {
        return new ProcedureResource($procedure);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProcedureRequest $request
     * @param Procedure $procedure
     * @return ProcedureResource
     */
    public function update(ProcedureRequest $request, Procedure $procedure): ProcedureResource
    {
        $procedure->update($request->all());
        return (new ProcedureResource($procedure))
            ->additional(['message' => 'Patient updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Procedure $procedure
     * @return JsonResponse
     */
    public function destroy(Procedure $procedure): JsonResponse
    {
        $procedure->delete();
        return response()->json(['message' => 'Procedure record delete']);
    }
}
