<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class HealthInsuranceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
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
