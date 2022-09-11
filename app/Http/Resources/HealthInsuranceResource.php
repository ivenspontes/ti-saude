<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HealthInsuranceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $inputs = [
            'id' => $this->id,
            'description' => $this->description,
            'phone' => $this->phone,
        ];

        if ($this->pivot) {
            $inputs['contract_number'] = $this->pivot->contract_number;
        }

        return $inputs;
    }
}
