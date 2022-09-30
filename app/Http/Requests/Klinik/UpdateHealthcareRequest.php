<?php

namespace App\Http\Requests\Klinik;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHealthcareRequest extends FormRequest
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
            'name'                   => 'required|max:100|unique:healthcares,name,'.$this->healthcare->id,
            'healthcare_category_id' => 'nullable|integer',
            'healthcare_type_id'     => 'nullable|integer',
            'country_id'             => 'nullable|integer',
            'province_id'            => 'nullable|integer',
            'city_id'                => 'nullable|integer',
            'district_id'            => 'nullable|integer',
            'sub_district_id'        => 'nullable|integer',
            'email'                  => 'nullable|string|max:255',
            'phone'                  => 'nullable|string|max:255',
            'website'                => 'nullable|string|max:255',
            'address'                => 'nullable|string',
            'postal_code'            => 'nullable|integer',
        ];
    }
}
