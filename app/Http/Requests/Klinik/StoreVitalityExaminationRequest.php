<?php

namespace App\Http\Requests\Klinik;

use Illuminate\Foundation\Http\FormRequest;

class StoreVitalityExaminationRequest extends FormRequest
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
            'examination_id'    => 'required|integer',
            'weight'            => 'nullable',
            'height'            => 'nullable',
            'blood_pressure'    => 'nullable',
            'heart_rate'        => 'nullable',
            'respiratory_rate'  => 'nullable',
            'temperature'       => 'nullable',
            'oxygen_saturation' => 'nullable',
            'body_mass_index'   => 'nullable',
            'ideal_weight'      => 'nullable',
            'body_fat'          => 'nullable',
            'bmi_conclusion'    => 'nullable',

        ];
    }
}
