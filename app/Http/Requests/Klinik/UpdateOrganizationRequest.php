<?php

namespace App\Http\Requests\Klinik;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrganizationRequest extends FormRequest
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
            'name'            => 'required',
            'organization_id' => 'required|unique:organizations,organization_id,' . $this->organization->id,
            'email'           => 'required|email',
            'phone'           => 'required',
            'fax'             => 'nullable',
            'logo'            => 'nullable |image',
            'country_id'      => 'required',
            'province_id'     => 'required',
            'city_id'         => 'required',
            'district_id'     => 'required',
            'sub_district_id' => 'required',
            'address'         => 'required',
            'postal_code'     => 'required',
            'json_satu_sehat' => 'nullable'
        ];
    }
}
