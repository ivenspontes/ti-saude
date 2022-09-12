<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsultationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
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
