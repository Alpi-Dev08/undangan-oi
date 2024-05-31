<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class SettingsInfoRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'religion_id'           => 'nullable|integer',
            'gender_id'             => 'nullable|integer',
            'blood_type_id'         => 'nullable|integer',
            'work_id'               => 'nullable|integer',
            'education_id'          => 'nullable|integer',
            'marital_status_id'     => 'nullable|integer',
            'card_type_id'          => 'nullable|integer',
            'country_id'            => 'nullable|integer',
            'province_id'           => 'nullable|integer',
            'city_id'               => 'nullable|integer',
            'district_id'           => 'nullable|integer',
            'sub_district_id'       => 'nullable|integer',
            'card_number'           => 'nullable|string',
            'his_number'            => 'nullable|string',
            'title_prefix'          => 'nullable|string|max:255',
            'title_suffix'          => 'nullable|string|max:255',
            'photo'                 => 'nullable|max:255',
            'place_of_birth'        => 'nullable|string|max:255',
            'date_of_birth'         => 'required|string|max:255',
            'weight'                => 'nullable|string|max:255',
            'height'                => 'nullable|string|max:255',
            'address'               => 'nullable|string',
            'postal_code'           => 'nullable|integer',
            'patient_trusetee_name' => 'nullable|string|max:255',
            'company_name'          => 'nullable',
            'date_of_hire'          => 'nullable',
            'job_title'             => 'nullable',
            'division'              => 'nullable',
            'department'            => 'nullable',
            'section'               => 'nullable',
            'employee_id'           => 'nullable',
            'kind_of_job'           => 'nullable',
            'shift'                 => 'nullable',

        ];
    }
}
