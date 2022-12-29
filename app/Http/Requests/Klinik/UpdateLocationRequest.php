<?php

namespace App\Http\Requests\Klinik;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLocationRequest extends FormRequest
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
            'uuid'            => 'nullable',
            'code'            => 'required',
            'name'            => 'required',
            'description'     => 'nullable',
            'organization_id' => 'required',
            'email'           => 'required|email',
            'phone'           => 'required',
            'fax'             => 'nullable',
            'country_id'      => 'required',
            'province_id'     => 'required',
            'city_id'         => 'required',
            'district_id'     => 'required',
            'sub_district_id' => 'required',
            'address'         => 'required',
            'postal_code'     => 'required',
            'json_satu_sehat' => 'nullable',
            'status'          => 'nullable'
        ];
    }
}
