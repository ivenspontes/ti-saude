<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'birthday' => ['required', 'dateformat:d/m/Y'],
            'phones' => ['required', 'array'],
            'health_insurances' => ['array'],
            'health_insurances.*.id' => ['integer', 'exists:health_insurances,id'],
            'health_insurances.*.contract_number' => ['integer'],
        ];
    }
}
