<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->scheduled_date,
            'time' => $this->scheduled_time,
            'private' => $this->private,
            'patient' => new PatientResource($this->patient),
            'doctor' => new DoctorResource($this->doctor),
            'procedures' => new ProcedureCollection($this->procedures),
        ];
    }
}
