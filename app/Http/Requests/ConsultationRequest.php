<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsultationRequest extends FormRequest
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
            'scheduled_date' => ['required', 'date_format:d/m/Y'],
            'scheduled_time' => ['required', 'date_format:H:i'],
            'private' => ['required', 'boolean'],
            'patient_id' => ['required', 'exists:patients,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'procedures' => ['array'],
            'procedures.*' => ['exists:procedures,id'],
        ];
    }
}
