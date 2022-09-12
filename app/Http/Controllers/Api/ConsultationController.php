<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConsultationRequest;
use App\Http\Resources\ConsultationCollection;
use App\Http\Resources\ConsultationResource;
use App\Models\Consultation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ConsultationCollection
     */
    public function index()
    {
        return new ConsultationCollection(Consultation::simplePaginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ConsultationRequest $request
     * @return JsonResponse
     */
    public function store(ConsultationRequest $request)
    {
        $consultation = Consultation::create($request->validated());

        $consultation->procedures()->sync($request->procedures);

        return (new ConsultationResource($consultation))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Consultation $consultation
     * @return ConsultationResource
     */
    public function show(Consultation $consultation)
    {
        return new ConsultationResource($consultation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Consultation $consultation
     * @return ConsultationResource
     */
    public function update(ConsultationRequest $request, Consultation $consultation)
    {
        $consultation->update($request->validated());

        $consultation->procedures()->sync($request->procedures);
        return (new ConsultationResource($consultation))
            ->additional(['message' => 'Consultation updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Consultation $consultation
     * @return JsonResponse
     */
    public function destroy(Consultation $consultation)
    {
        $consultation->delete();
        return response()->json('Consultation record deleted.');
    }
}
