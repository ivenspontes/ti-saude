<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProcedureRequest;
use App\Http\Resources\ProcedureCollection;
use App\Http\Resources\ProcedureResource;
use App\Models\Procedure;
use Illuminate\Http\Request;

class ProcedureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ProcedureCollection
     */
    public function index()
    {
        return new ProcedureCollection(Procedure::simplePaginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProcedureRequest $request)
    {
        $procedure = Procedure::create($request->all());

        return response()->json([
            "message" => "Procedure record created"
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Procedure $procedure
     * @return ProcedureResource
     */
    public function show(Procedure $procedure)
    {
        return new ProcedureResource($procedure);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Procedure $procedure
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ProcedureRequest $request, Procedure $procedure)
    {
        $procedure->update($request->all());
        return response()->json([
            "message" => "Procedure record updated"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Procedure $procedure
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Procedure $procedure)
    {
        $procedure->delete();
        return response()->json(['message' => 'Procedure record delete']);
    }
}
